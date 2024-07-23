@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized'))

@section('button')
  <a class="py-2 px-4 mt-10 bg-lightgreen rounded-md text-white font-semibold" href="/">Go to home</a>
@endsection