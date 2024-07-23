<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Dashboard\ContractBuilder;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Dashboard/Builder/Index', [
            'contracts' => Contract::query()->where('company_id', $request->user()->company->id)->latest('created_at')->paginate()->withQueryString(),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Dashboard/Builder/Create', [

        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string'],
                'content' => ['required', 'string'],
            ]);

            $request->user()->company->contracts()->create([
                'name' => $request->name,
                'content' => $request->content,
                'default' => false,
            ]);

            return to_route('dashboard.builder.index')->with('notification', [
                'type' => 'success',
                'message' => 'Template created successfully',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }

    public function edit(Request $request, Contract $contract)
    {
        return Inertia::render('Dashboard/Builder/Edit', [
            'contract' => $contract,
        ]);
    }

    public function update(Request $request, Contract $contract)
    {
        try {
//        if ($contract->company_id !== $request->user()->company->id) {
//        }

            $request->validate([
                'name' => ['required'],
                'content' => ['required'],
            ]);

            $contract->update([
                'name' => $request->name,
                'content' => $request->content,
            ]);

            return to_route('dashboard.builder.index')->with('notification', [
                'type' => 'success',
                'message' => 'Template update successfully',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }

    public function delete(Request $request, Contract $contract)
    {
        try {
//        if ($contract->company_id !== $request->user()->company->id) {
//        }

            $contract->delete();

            return back()->with('notification', [
                'type' => 'success',
                'message' => 'Contract Deleted',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }

    public function makeDefault(Request $request, Contract $contract)
    {
        try {
            DB::transaction(function () use ($contract) {
                Contract::where('default', true)->where('company_id', '=', Auth::user()->company->id)->update(['default' => false]);
                $contract->update(['default' => true]);
            });

            return back()->with('notification', [
                'type' => 'success',
                'message' => 'Template active was changed',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }

    public function show(Contract $contract)
    {
        return Inertia::render('Dashboard/Builder/Show', [
            'contract' => $contract, /* Auth::user()->company->pricingResource */
        ]);
    }

    public function pdf(Contract $contract)
    {
        try {
            $pdf = Pdf::loadView('Pdfs.contract-template-pdf', [
                'contract' => $contract,
            ])->setPaper('legal');

            return $pdf->download('contract'.time().'.pdf');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }
}
