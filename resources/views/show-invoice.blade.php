<div class="m-4 p-4">
    <div class="m-4 p-4">
        <h2 class="text-4xl font-bold dark:text-white">Details Invoice {{$invoice->invoice_number}}</h2>

        <div class="grid grid-flow-row m-1 p-5">
            <div><strong>Company:</strong> {{ $contract->contract->company->name }}</div>
            <div><strong>Contract:</strong> {{ $contract->id }}</div>
        </div>

        <div class="grid grid-flow-row m-1 p-5">
            <div><strong>Client:</strong> {{ $contract->insured->first_name }} {{ $contract->insured->last_name }}</div>
            <div><strong>Address Service:</strong> {{ $contract->insured->address }}</div>
            <div><strong>Issued Date:</strong> {{ \Carbon\Carbon::parse($contract->insured->created_at)->format('F
            j, Y')
            }}</div>
            <div><strong>Phone:</strong> {{ $contract->insured->phone }}</div>
            <div><strong>Email:</strong> {{ $contract->insured->email }}</div>
        </div>

        <div class="grid grid-flow-row m-1 p-5">
            <div><strong>Insurance Company:</strong> {{ $contract->insured->insurance_company }} </div>
            <div><strong>Claim number:</strong> {{ $contract->insured->claim_number }}</div>
        </div>
<div class="grid grid-flow-row m-1 p-5">
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="border-b bg-primary-500 ">
                        <tr>
                            <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                Product
                            </th>
                            <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                Description
                            </th>
                            <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                Quantity
                            </th>
                            <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                Unit Price
                            </th>
                            <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                Total
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($invoice->invoiceResources as $resource)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$resource->insuredContractResource->pricingResources->resource->name}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$resource->description}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$resource->quantity}} hr</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${{$resource->price_cents / 100}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${{$resource->quantity * ($resource->price_cents/100)}}</td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@if($invoice->invoiceFees->count() !== 0)

        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead class="border-b bg-primary-500 ">
                            <tr>
                                <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                    Name
                                </th>
                                <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                    Type
                                </th>
                                <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                    Fee Type
                                </th>
                                <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                    Amount
                                </th>


                            </tr>
                            </thead>
                            <tbody>

                            @foreach($invoice->invoiceFees as $fee)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium
                                text-gray-900">{{$fee->name}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{$fee->type === 'tax'?'text-green-600':'text-blue-600'}}">{{$fee->type}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$fee->fee_type === 'percentage'?'%':''}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium
                                    text-gray-900">{{$fee->fee_type ==='percentage'?$fee->amount:$fee->amount/100}}</td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endif




        <table class="table  m-3" >
            <tr class="grid justify-end text-xl">
                <td colspan="5" class="dark:bg-slate-200 dark:text-black">&nbsp;Total: </td>
                <td class="text-primary-900 dark:bg-slate-200">${{number_format(($total/100),2)}}</td>
            </tr>
        </table>

</div>
    </div>


    <div class="overflow-x-auto relative mt-5">

        <br>
        <button class="bg-white dark:bg-white dark:text-black font-bold py-2 px-4 rounded" wire:click="back"> return
        </button>

        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-3" href="{{route('admin.invoice.pdf',[
        'invoice'=> $invoice->id])}}">
            Print
        </a>
    </div>

</div>
