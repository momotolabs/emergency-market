<x-mail::message>

    **Congratulations!**

    You just had a new job closed through emergency Market. Their information is below:

    1. Name: {{$first_name}} {{$last_name}}
    2. Address: {{$address}}
    3. Phone: {{$phone}}
    4. Email: {{$email}}
    5. Insurance Carrier: {{$carrier}}
    6. Claim Number:{{$claim}}

    Thank you for using emergency Market

    We are here to help any way we can!

    Thanks

    {{ config('app.name') }} Support Team

    {{ config('app.url') }}
</x-mail::message>
