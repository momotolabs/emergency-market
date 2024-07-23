<div class="m-4 p-4">
<div class="m-4 p-4">
    <h2 class="text-4xl font-bold dark:text-white">Details Data</h2>

</div>
    <div class="grid grid-flow-row">
        <h3 class="text-3xl font-bold dark:text-white">Company: {{$company->name}} </h3>

        <h3 class="text-3xl font-bold dark:text-white"> Resource: {{$resource->name}}</h3>
    </div>

    <div class="overflow-x-auto relative mt-5">
        <div class="text-2xl  m-1">Historical prices</div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6">
                    PRICE
                </th>
                <th scope="col" class="py-3 px-6">
                    MINIMUM HOURS
                </th>
                <th scope="col" class="py-3 px-6">
                    DATE
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($resources as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${{json_decode($item->event_properties,true)['attributes']['price_cents']/100}}.00
                </th>
                <td class="py-4 px-6">
                    {{json_decode($item->event_properties,true)['attributes']['minimum_units']}}
                </td>
                <td class="py-4 px-6">
                    {{Carbon\Carbon::parse(json_decode($item->event_properties,true)['attributes']['updated_at'])
                    ->format('m/d/y')}}
                </td>

            </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <br>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click="back"> return
    </button>

</div>
