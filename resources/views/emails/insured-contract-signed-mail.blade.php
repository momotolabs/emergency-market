<x-mail::message>

    **This is your confirmation. We have now (e-mailed) (and texted) your contract to the tree service.**

    Also, their direct number is {{$phone}}

    Also if you would like to download this contract, you can do so by click in the button below
<x-mail::button :url="$url">
    Download pdf
</x-mail::button>

    however we have also emailed it to you as well.

    Thanks,

    {{ config('app.name') }} Team
</x-mail::message>
