<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Models\InsuredContract;
use App\Models\Invoice;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    public function render(): View
    {
        $invoice = Invoice::with('invoiceFees', 'invoiceResources.insuredContractResource.pricingResources.resource',
            'insuredContract')->find($this->data['id']);
        $contract = InsuredContract::with('insured', 'contract.company.profileUser')
            ->where('id', $invoice->insured_contract_id)->first();
        $resourceSum = $invoice->invoiceResources->sum(function ($item) {
            return $item->quantity * $item->price_cents;
        });

        $resourceSubTotalDiscounts = $invoice->invoiceFees->where('type', 'discount')->sum(function ($item) use ($resourceSum) {
            $value = $item->amount;
            if ($item->fee_type === 'percentage') {
                $value = ((($resourceSum) * ($item->amount / 100)));
            }

            return $value;
        });

        $subDiscount = $resourceSum - $resourceSubTotalDiscounts;

        $resourceSubTotalTax = $invoice->invoiceFees->where('type', 'tax')->sum(function ($item) use ($subDiscount) {
            $value = $item->amount;
            if ($item->fee_type === 'percentage') {
                $value = ((($subDiscount) * ($item->amount / 100)));
            }

            return $value;
        });

        $total = $subDiscount + $resourceSubTotalTax;

        return view('show-invoice', compact('contract',
            'invoice',
            'resourceSum',
            'resourceSubTotalDiscounts',
            'resourceSubTotalTax',
            'total'
        )
        );
    }

    public function back()
    {
        return redirect('/admin/invoices');
    }
}
