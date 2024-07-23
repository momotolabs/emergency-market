<div class="m-4 p-4">
    <div class="m-4 p-4">
<div class="container bg-white dark:bg-slate-800 border rounded shadow p-5 ">
    <h2 class="text-4xl font-bold dark:text-white">Resume Claim:  {{$contract->id}}  </h2>
    <div class="grid grid-flow-row m-1 p-5">
        <div><strong>Insured Name:</strong> {{$contract->insured->first_name}} {{$contract->insured->last_name}}</div>
        <div><strong>Phone:</strong> {{$contract->insured->phone}}</div>
        <div><strong>Email:</strong> {{$contract->insured->email}}</div>
    </div>
    <div class="grid grid-flow-row m-1 p-5">
        <div><strong>Address Service:</strong>{{$contract->insured->email}}</div>
        <div><strong>Signed Date:</strong>{{\Carbon\Carbon::parse($contract->signed_at)->format('F
            j, Y')}}</div>
    </div>
    <div class="grid grid-flow-row m-1 p-5">
        <div><strong>Insurance Company:</strong> {{$contract->insured->insurance_company}} </div>
        <div><strong>Claim number:</strong> {{$contract->insured->claim_number}}</div>
    </div>
    <div class="overflow-x-auto relative mt-5">
        <br>
        <button class="bg-gray-100 dark:bg-white dark:text-black font-bold py-2 px-4 rounded" wire:click="back"> return
        </button>

        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-3" href="{{route('directory.contract.complete',[
        'id'=> $contract->id])}}">
            Print
        </a>
    </div>
</div>
    </div>



</div>
