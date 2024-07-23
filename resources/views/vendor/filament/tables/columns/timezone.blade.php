<div>
    {{ \Carbon\Carbon::parse($getState())->setTimezone('EST')->format('M j, Y H:i:s') }}
</div>