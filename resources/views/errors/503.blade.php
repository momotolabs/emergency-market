@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('We are currently undergoing maintenance, the site will be online very soon! We apologize the IT team'))


@section('button')
  <a class="py-2 px-4 mt-10 bg-lightgreen rounded-md text-white font-semibold" href="/">Go to home</a>
@endsection
