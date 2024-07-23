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
use Illuminate\Queue\SerializesModels;

class InsuredContractMail extends Mailable implements ShouldQueue
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

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails/insured-contract-signed-mail')->with(['phone' => $this->insuredContract->insured->phone, 'url' => route('directory.contract.complete',
            $this->insuredContract->id)]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return \Illuminate\Mail\Mailables\Attachment[]
     */
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
