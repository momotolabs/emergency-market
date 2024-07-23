@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))

@section('button')
  <a class="py-2 px-4 mt-10 bg-lightgreen rounded-md text-white font-semibold" href="{{ Auth::user()->type === 'provider' ? route('dashboard.contracts.open') : '/admin' }}">Go to {{Auth::user()->type === 'provider' ? 'Dashboard' : 'Admin'}}</a> </div>
@endsection
