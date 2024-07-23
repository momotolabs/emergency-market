@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))

@section('button')
  <a class="py-2 px-4 mt-10 bg-lightgreen rounded-md text-white font-semibold" href="/">Go to home</a>
@endsection