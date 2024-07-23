@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))

@section('button')
  <a class="py-2 px-4 mt-10 bg-lightgreen rounded-md text-white font-semibold" href="/">Go to home</a>
@endsection
