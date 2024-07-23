<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Directory;

use App\Http\Controllers\Controller;
use App\Mail\InsuredContractMail;
use App\Mail\InsuredSignedProviderMail;
use App\Models\Company;
use App\Models\Concerns\ContractStatus;
use App\Models\Contract;
use App\Models\Insured;
use App\Models\InsuredContract;
use App\Models\InsuredContractResource;
use App\Models\Multimedia;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use MStaack\LaravelPostgis\Geometries\Point;

class IndexController extends Controller
{
    public function index()
    {
        return Inertia::render('Directory/Index', [
            'companies' => Company::query()->with(['city.state', 'multimedia' => function ($query) {
                $query->where('type', 'avatar');
            }])->has('city.state')->get(),
        ]);
    }

    public function contractDescription($state, $city, Company $company)
    {
        return Inertia::render('Directory/Contract', [
            'company' => $company->load(['city.state']),
            'avatar' => $company?->getAvatar(),
            'gallery' => $company?->getGallery(),
            'contract' => $company->contracts()->default()->first(),
            'resources' => $company->pricingResource->load(['resource']),
        ]);
    }

    public function hireContract($state, $city, Company $company)
    {
        return Inertia::render('Directory/Hire', [
            'company' => $company->load(['city.state']),
            'avatar' => $company?->getAvatar(),
        ]);
    }

    public function store(Request $request, Company $company)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:10'],
            'insurance_company' => ['required', 'string', 'max:255'],
            'claim_number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'latitude' => ['nullable'],
            'longitude' => ['nullable'],
        ]);

        try {
            $insuredContract = DB::transaction(function () use ($company, $request) {
                $company = $company->load(['pricingResource', 'contracts']);
                $contract = $company->contracts()->default()->first();
                $pricingResources = $company->pricingResource()->get();

                $insured = Insured::create([
                    ...$request->except(['latitude', 'longitude']),
                    'coordinates' => new Point($request->latitude, $request->longitude),
                ]);

                $insuredContract = InsuredContract::create([
                    'insured_id' => $insured->id,
                    'contract_id' => $contract->id,
                    'content' => $contract->content,
                    'status' => ContractStatus::VIEWED->value,
                    'meta' => json_decode('0'),
                ]);

                foreach ($pricingResources as $key => $value) {
                    InsuredContractResource::create([
                        'pricing_resource_id' => $value->id,
                        'insured_contract_id' => $insuredContract->id,
                        'price_currency' => $value->price_currency,
                        'price_cents' => $value->price_cents,
                        'units' => $value->minimum_units,
                    ]);
                }

                return $insuredContract;
            });

            // Send link to sign

            return to_route('directory.contract.show', $insuredContract->id)->with('notification', [
                'type' => 'success',
                'message' => 'The contract was contract, now you can sign it',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }

    public function contractShow($insuredcontract)
    {
        $contract = InsuredContract::with(['contract.company.user.providerProfile', 'insured', 'insuredResources.pricingResources.resource'])->findOrFail($insuredcontract);

        // return $contract;
        return Inertia::render('Directory/Show', [
            'contract' => $contract,
        ]);
    }

    public function contractSign(Request $request, InsuredContract $insuredcontract)
    {
        try {
            $insuredcontract = DB::transaction(function () use ($insuredcontract, $request) {
                $insuredcontract->update([
                    'finish_content' => $request->content,
                    'signed_at' => now(),
                    'status' => ContractStatus::OPEN->value,
                ]);

                $insuredcontract->insuredSignature()->create([
                    'signature' => $request->owner_signed_image,
                ]);

                return $insuredcontract;
            });

            $insuredcontract->load('insured', 'insuredSignature', 'contract.company.user');
            Mail::to($insuredcontract->insured->email)
                ->queue(new InsuredContractMail(insuredContract: $insuredcontract));
            Mail::to($insuredcontract->contract->company->user->email)
                ->queue(new InsuredSignedProviderMail(insuredContract: $insuredcontract));

            return Inertia::render('Directory/Complete', [
                'contract' => $insuredcontract,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }

    public function contractLink($kind, $state, $city, Company $company)
    {
        try {
            return Inertia::render('Dashboard/Contracts/ContractLink', [
                'contract' => $company->contracts()->default()->first(),
                'company' => $company,
                'state' => $state,
                'city' => $city,
                'slug' => $company->slug,
                'owner' => $company->profileUser,
                'resources' => $company->pricingResource->load(['resource']),
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }

    public function complete(Request $request, $id)
    {
        try {
            $complete = InsuredContract::with('insured', 'insuredSignature')->findOrFail($id);
            $resources = InsuredContractResource::where('insured_contract_id', $complete->id)
                ->get()
                ->load('pricingResources.resource');

            $contract = Contract::where('id', $complete->contract_id)->first();

            $company = Company::with('profileUser')->where('id', $contract->company_id)->first();
            $logo = Multimedia::where([
                'publishable_id' => $company->id,
                'type' => 'avatar',
            ])->first()->path ?? '';
            $pdf = PDF::loadView('Pdfs.contract-complete-pdf', [
                'complete' => $complete,
                'resources' => $resources,
                'company' => $company,
                'logo' => $logo,
            ]);

            return $pdf->download('contract-signed-'.time().'.pdf');
//             return view('Pdfs.contract-complete-pdf', compact('complete', 'resources','company','logo'));
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }

    public function providerFilter()
    {
        return Inertia::render('Directory/ProviderFilter');
    }
}
