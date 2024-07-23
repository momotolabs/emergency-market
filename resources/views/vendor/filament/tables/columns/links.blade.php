<div>
    @if($getState()!="")
    <a href="tel:{{ $getState() }}">({{ substr($getState(),0,3) }}) {{ substr($getState(),3,3) }}-{{ substr($getState(),6,4) }}</a>
    @endif
</div>