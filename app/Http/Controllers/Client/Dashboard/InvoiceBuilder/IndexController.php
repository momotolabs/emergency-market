<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Dashboard\InvoiceBuilder;

use App\Http\Controllers\Controller;
use App\Models\Concerns\ContractStatus;
use App\Models\Concerns\FeeTypes;
use App\Models\InsuredContract;
use App\Models\Invoice;
use App\Models\InvoiceFee;
use App\Models\InvoiceResource;
use App\Models\Multimedia;
use App\Traits\S3Upload;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class IndexController extends Controller
{
    use S3Upload;

    public function index(Request $request)
    {
        return Inertia::render('Dashboard/Invoice/Index', [
            'invoices' => Invoice::query()
                ->select('invoices.*')
                ->join('insured_contracts', 'invoices.insured_contract_id', '=', 'insured_contracts.id')
                ->join('contracts', 'insured_contracts.contract_id', '=', 'contracts.id')
                ->with(['insuredContract.insured', 'insuredContract.contract.company'])
                ->where('contracts.company_id', '=', Auth::user()->company->id)
                ->latest('invoices.created_at')->paginate()->withQueryString(),
        ]);
    }

    public function create(Request $request, $id)
    {
        $contract = InsuredContract::findOrFail($id);

        if (! $contract->signed_at) {
            // Restrinct to contracts signeg
        }

        return Inertia::render('Dashboard/Invoice/Create', [
            'contract' => $contract->load('contract', 'insured', 'insuredResources.pricingResources.resource'),
        ]);
    }

    public function store(Request $request, InsuredContract $insuredcontract)
    {
        // return ['request' => $request->all()];
        try {
            DB::transaction(function () use ($request, $insuredcontract) {
                $invoice = Invoice::create([
                    'invoice_number' => $request->invoice_number,
                    'subject' => $request->subject,
                    'message' => $request->clientMessage,
                    'insured_contract_id' => $insuredcontract->id,
                    'internal_notes' => $request->internalNotes,
                ]);

                foreach ($request->invoiceResources as $key => $resource) {
                    InvoiceResource::create([
                        'invoice_id' => $invoice->id,
                        'insured_contract_resource_id' => $resource['resource_id'],
                        'price_cents' => $resource['price_cents'],
                        'quantity' => $resource['quantity'],
                        'description' => $resource['description'],
                    ]);
                }

                foreach ($request->discounts as $key => $discount) {
                    InvoiceFee::create([
                        'invoice_id' => $invoice->id,
                        'type' => FeeTypes::DISCOUNT->value,
                        'fee_type' => $discount['type'] === '$' ? FeeTypes::DISCOUNT->value : FeeTypes::PERCENTAGE->value,
                        'amount' => $discount['type'] === '$' ? $discount['amount'] * 100 : $discount['amount'],
                        'name' => $discount['name'],
                    ]);
                }

                foreach ($request->taxes as $key => $tax) {
                    InvoiceFee::create([
                        'invoice_id' => $invoice->id,
                        'type' => FeeTypes::TAX->value,
                        'fee_type' => $tax['type'] === '$' ? FeeTypes::DISCOUNT->value : FeeTypes::PERCENTAGE->value,
                        'amount' => $tax['type'] === '$' ? $tax['amount'] * 100 : $tax['amount'],
                        'name' => $tax['name'],
                    ]);
                }

                $user = $request->user();
                foreach ($request->images as $key => $value) {
                    $invoice->multimedia()->create([
                        'path' => $this->getUrl($value, "/invoice/{$invoice->id}", $key),
                        'type' => 'evidence',
                    ]);
                }

                $insuredcontract->update(['status' => ContractStatus::CLOSED->value]);
            });

            return to_route('dashboard.invoices.index')->with('notification', [
                'type' => 'success',
                'message' => 'Invoice created',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }

    public function edit(Request $request, Invoice $invoice)
    {
        return Inertia::render('Dashboard/Invoice/Edit', [
            'invoice' => $invoice->load(['invoiceResources.insuredContractResource.pricingResources.resource', 'invoiceFees', 'insuredContract.insured', 'insuredContract.insuredResources.pricingResources.resource']),
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        try {
            DB::transaction(function () use ($request, $invoice) {
                $invoice->update([
                    'invoice_number' => $request->invoice_number,
                    'subject' => $request->subject,
                    'message' => $request->clientMessage,
                    'internal_notes' => $request->internalNotes,
                ]);

                foreach ($request->invoiceResources as $key => $resource) {
                    InvoiceResource::updateOrCreate(
                        [
                            'id' => $resource['id'],
                        ],
                        [
                            'invoice_id' => $invoice->id,
                            'insured_contract_resource_id' => $resource['resource_id'],
                            'price_cents' => $resource['price_cents'],
                            'quantity' => $resource['quantity'],
                            'description' => $resource['description'],
                        ]
                    );
                }

                InvoiceFee::where('invoice_id', '=', $invoice->id)->delete();

                foreach ($request->discounts as $key => $discount) {
                    InvoiceFee::create([
                        'invoice_id' => $invoice->id,
                        'type' => FeeTypes::DISCOUNT->value,
                        'fee_type' => $discount['type'] === '$' ? FeeTypes::DISCOUNT->value : FeeTypes::PERCENTAGE->value,
                        'amount' => $discount['type'] === '$' ? $discount['amount'] * 100 : $discount['amount'],
                        'name' => $discount['name'],
                    ]);
                }

                foreach ($request->taxes as $key => $tax) {
                    InvoiceFee::create([
                        'invoice_id' => $invoice->id,
                        'type' => FeeTypes::TAX->value,
                        'fee_type' => $tax['type'] === '$' ? FeeTypes::DISCOUNT->value : FeeTypes::PERCENTAGE->value,
                        'amount' => $tax['type'] === '$' ? $tax['amount'] * 100 : $tax['amount'],
                        'name' => $tax['name'],
                    ]);
                }

                // $user = $request->user();
                // foreach ($request->images as $key => $value) {
                //     $invoice->multimedia()->create([
                //         'path' => $this->getUrl($value, "/invoice/{$invoice->id}", $key),
                //         'type' => 'evidence',
                //     ]);
                // }

                // $insuredcontract->update(['status' => ContractStatus::CLOSED->value]);
            });

            return to_route('dashboard.invoices.index')->with('notification', [
                'type' => 'success',
                'message' => 'Invoice Updated',
            ]);
        } catch (Exception $e) {
            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request',
            ]);
        }
    }

    public function pdf(Request $request, Invoice $invoice)
    {
        try {
            $invoice = Invoice::with('invoiceFees', 'invoiceResources.insuredContractResource.pricingResources.resource',
                'insuredContract')->find($invoice->id);
            $contract = InsuredContract::with('insured', 'contract.company.profileUser')
                ->where('id', $invoice->insured_contract_id)->first();
            $resourceSum = $invoice->invoiceResources->sum(function ($item) {
                return $item->quantity * $item->price_cents;
            });

            $resourceSubTotalDiscounts = $invoice->invoiceFees->where('type', 'discount')->sum(function ($item) use ($resourceSum) {
                $value = $item->amount;
                if ($item->fee_type === 'percentage') {
                    $value = ($resourceSum * ($item->amount / 100));
                }

                return $value;
            });

            $subDiscount = $resourceSum - $resourceSubTotalDiscounts;

            $resourceSubTotalTax = $invoice->invoiceFees->where('type', 'tax')->sum(function ($item) use ($subDiscount) {
                $value = $item->amount;
                if ($item->fee_type === 'percentage') {
                    $value = $subDiscount * ($item->amount / 100);
                }

                return $value;
            });

            $total = $subDiscount + $resourceSubTotalTax;
            $pdf = Pdf::loadView('Pdfs.invoice-pdf', [
                'invoice' => $invoice,
                'contract' => $contract,
                'resourceSum' => $resourceSum,
                'total' => $total,
                'logo' => Multimedia::where([
                    'publishable_id' => $contract->contract->company->id,
                    'type' => 'avatar',
                ])->first()->path ?? '',
            ]);

            return $pdf->download('invoice-'.$invoice->invoice_number.'.pdf');
//         return view('Pdfs.invoice-pdf', compact('invoice','contract','resourceSum','total'));
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }

    public function show(Request $request, Invoice $invoice)
    {
        return Inertia::render('Dashboard/Invoice/Show', [
            'invoice' => $invoice->load('invoiceFees', 'insuredContract.insured', 'invoiceResources.insuredContractResource.pricingResources.resource'),
            'evidences' => $invoice->multimedia,
        ]);
    }
}
