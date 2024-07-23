@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))

@section('button')
  <a class="py-2 px-4 mt-10 bg-lightgreen rounded-md text-white font-semibold" href="/">Go to home</a>
@endsection