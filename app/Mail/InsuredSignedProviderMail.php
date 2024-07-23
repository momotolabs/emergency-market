<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\InsuredContract;
use App\Models\Multimedia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class InsuredSignedProviderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public InsuredContract $insuredContract)
    {
        $insuredContract->load('insured', 'insuredSignature', 'contract.company.profileUser');
    }

    public function content()
    {
        return new Content(
            markdown:'emails.provider-contract-signed-mail',
            with:[
                'first_name' => $this->insuredContract->insured->first_name,
                'last_name' => $this->insuredContract->insured->last_name,
                'email' => $this->insuredContract->insured->email,
                'phone' => $this->insuredContract->insured->phone,
                'address' => $this->insuredContract->insured->address,
                'claim' => $this->insuredContract->insured->claim_number,
                'carrier' => $this->insuredContract->insured->insurance_company,
            ]
        );
    }

    public function attachments()
    {
        $logo = Multimedia::where([
            'publishable_id' => $this->insuredContract->contract->company->id,
            'type' => 'avatar',
        ])->first()->path ?? '';
        $pdf = PDF::loadView('Pdfs.contract-complete-pdf', [
            'complete' => $this->insuredContract,
            'resources' => $this->insuredContract->insuredResources->load('pricingResources.resource'),
            'company' => $this->insuredContract->contract->company,
            'logo' => $logo,
        ]);

        return [
            Attachment::fromData(fn () => $pdf->output(), 'contract-signed-'.time().'.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
