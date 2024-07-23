<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('favicon.ico') }}">
    <title>emergency Market</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #FDFDFD;
        }

        table {
            width: 100%;
        }

        .invoice {
            width: 90%;
            margin: auto;
        }

        .invoice h1 {
            font-size: 35px;
            text-align: left;
            font-weight: 600;
        }

        table.invoice-items {
            margin: 25px 0px;
            background-color: #EFF0F7;
            padding: 15px;
            border-radius: 10px;
        }

        td {
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 20px;
        }

        td:first-child {
            padding-left: 20px;
            padding-right: 0;
        }

        .definition {
            font-weight: 600;
        }

        .text-green {
            color: green;
        }

        .text-blue {
            color: #0F4BAD;
        }

        hr {
            margin: 10px 0px;
        }

        .image {
            width: fit-content;
            height: 300px;
            margin: 5px;
        }
        .logo {
            width: fit-content;
            height: 64px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body class="antialiased">
@php
    setlocale(LC_MONETARY, 'en_US');
@endphp
<div class="invoice">
    <table>
        <tr>
            <td><img src="{{$logo??''}}" class="logo" alt="logo"/>

                <blockquote>
                <h3>{{$contract->contract->company->name}}</h3>
                   <strong>Address: {{$contract->contract->company->address}}</strong> <br>
                   <strong>Phone: {{$contract->contract->company->phone}}</strong>
                </blockquote>

        </td>




        </tr>
        <tr><td> <h1>Invoice for {{ $contract->insured->first_name }} {{ $contract->insured->last_name
        }}</h1></td></tr>
        <tr>
            <td>
                <span class="definition">Subject</span>
                <p>{{ $invoice->subject }}</p>
            </td>
            <td>
                <div style="background-color: #0f4bad; color: #ffffff; padding: 5px;width: 100%">
                    <h2 class="definition">Invoice # {{$invoice->invoice_number }}</h2>
                    <span class="definition">Issue date</span>
                    <p>{{ \Carbon\Carbon::parse($contract->signed_at)->format('F j, Y') }}</p>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div>
                    <span class="definition">Service Address:</span>
                    <span>{{ $contract->insured->address }}</span>
                </div>
                <br>
                <br>
                <div>
                    <span class="definition">Contact details:</span><br>
                    <span>Phone: {{ $contract->insured->phone }}</span><br>
                    <span>Email: {{ $contract->insured->email }}</span>
                </div>
            </td>
        </tr>
    </table>

    <table class="invoice-items">
        <thead>
        <tr>
            <td class="definition">PRODUCT / SERVICE</td>
            <td class="definition">DESCRIPTION</td>
            <td class="definition">QTY</td>
            <td class="definition">UNIT PRICE</td>
            <td class="definition">TOTAL</td>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoice->invoiceResources as $resource)
            <tr>
                <td>{{$resource->insuredContractResource->pricingResources->resource->name}}</td>
                <td>{{$resource->description}}</td>
                <td>{{$resource->quantity}} hr</td>
                <td>@money($resource->price_cents/100)</td>
                <td>@money(($resource->price_cents/100) * $resource->quantity)</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <table>
        <tr>
            <td style="width: 70%;">
                <h3 class="definition">Client note</h3>
                <p>{{ $invoice->message }}</p>
            </td>
            <td style="width: 30%; text-align: right;">

                <h3>Subtotal</h3>
                <p>
                    @money($resourceSum/100)
                </p>
                @if($invoice->invoiceFees->count() !== 0)
                <hr>
                <h3 class="definition">Taxes and Discount</h3>

                @foreach ($invoice->invoiceFees as $fee)
                    <table>
                        <tr>
                            <td class="{{ $fee->type == 'discount' ? 'text-green' : 'text-blue' }}"> ({{$fee->type}})
                            </td>
                            <td class="{{ $fee->type == 'discount' ? 'text-green' : 'text-blue' }}"> ({{$fee->name}})</td>
                            <td class="{{ $fee->type == 'discount' ? 'text-green' : 'text-blue' }}">@if($fee->fee_type == 'discount')
                                    <span>$</span>
                                @else
                                    <span>%</span>
                                @endif</td>
                            <td> {{ $fee->fee_type != 'percentage'?$fee->amount/100:$fee->amount }} </td>
                        </tr>
                    </table>
                @endforeach
                <hr>
                @endif
                <div style="background-color: #0f4bad; color: #ffffff; margin: 5px;padding: 5px">
                <h3 class="definition">Total</h3>
                <p>
                    @money($total/100)
                </p>
                </div>
            </td>
        </tr>
    </table>




</body>

</html>
