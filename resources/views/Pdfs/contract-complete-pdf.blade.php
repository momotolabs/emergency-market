@php use Carbon\Carbon; @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('favicon.ico') }}">
    <title>emergency Market</title>
    <style>
        @media print {
            html,body {
                margin: 2cm;
            }
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;

        }

        body {
            background-color: #FDFDFD;
            margin: 30px;
        }

        .contract {
            width: 90%;
            margin: auto;
            margin-top: 35px;

        }

        .contract ul, .contract ol {
            list-style-position: outside;
            padding-left: 20px;
        }

        .contract-title {
            text-align: center;
            font-size: 22px;
            color: #000000d9;
            font-weight: 600;
            font-family: 'Poppins';
            text-transform: uppercase;

        }
        .contract-subtitle {
            text-align: center;
            font-size: 18px;
            color: #000000d9;
            font-weight: 600;
            font-family: 'Poppins';
            margin-bottom: 5px;

        }

        .contract-content {
            text-align: justify;
            font-size: 16px;
            font-family: 'inter';
            line-height: 25px;
        }

        .contract hr {
            background-color: black;
            height: 1px;
            margin-bottom: 10px;
        }

        .contract > img {
            width: 150px;
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
        .page-break {
            page-break-after: always;
        }

        .logo-container {
            text-align: center;
        }
        .logo{
            width: auto !important;
            height: 64px !important;
            margin: 0 auto;
        }
    </style>
</head>

<body class="antialiased">
<div class="contract">
   <div class="logo-container"> <img src="{{$logo}}" alt="logo" class="logo"> </div>
    <h1 class="contract-title">{{$company->name}}</h1>
    <h2 class="contract-subtitle">{{$company->address}}</h2>

    <h1 class="contract-title">Service contract</h1><br>
    <hr>
    <div class="contract-content">
        {!! $complete->finish_content !!}
    </div>

    <div class="page-break"></div>
    <h2 class="contract-title" style="text-align: left;">Resources</h2>
    <table class="invoice-items" style="width: 65%;">
        <thead>
        <tr>
            <td class="definition">Name</td>
            <td class="definition">Rate per hours</td>
            <td class="definition">Min hour</td>
        </tr>
        </thead>
        <tbody>
        @foreach ($resources as $resource)
            <tr>
                <td>{{ $resource->pricingResources->resource->name }}</td>
                <td>{{ $resource->price_cents / 100 }}</td>
                <td>{{ $resource->units }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <strong>Homeowner:</strong> {{$complete->insured->first_name}}
                            {{$complete->insured->last_name}}  <br>
                            <br>
                            <strong>signature: </strong> <br>

                            @if($complete->insuredSignature !== null)
                                <img src="{{ $complete->insuredSignature->signature }}" width="275px" height="200px" alt="">
                            @else
                                {{ $complete->owner_signed }}
                            @endif

                            <hr>
                            Authorized Signature To Perform Emergency Work <br>
                            <strong>Date signed:</strong> {{ Carbon::parse($complete->signed_at)->format('F j, Y') }}
                            <br>
                            <strong>Phone homeowner:</strong> {{ $complete->insured->phone }}
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td>
                            @if($company->profileUser->signature !== null)
                                <br>
                                <strong>Provider signature: </strong> <br>
                                <img src="{{ $company->profileUser->signature }}" width="275px" height="200px" alt="">
                                <hr>
                            @endif

                            <strong>Company Owner:</strong> {{ $company->profileUser->first_name }} {{ $company->profileUser->last_name }}<br>
                            {{$company->name}}<br>
                            <strong>Phone number:</strong> {{$company->phone}}

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
