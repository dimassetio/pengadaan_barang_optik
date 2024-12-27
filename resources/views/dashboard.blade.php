@extends('layouts.dashboard')

@section('title')
  Dashboard
@endsection



@section('content')
  <div class="page-inner">
    <div class="d-flex align-items-center justify-content-center" style="height: 70vh;">
      <div class="text-center">
        <img src="{{ asset('assets/img/logo-vert.svg') }}" alt="Logo" class="mb-3" style="width:90vw; max-width: 300px;"
          class="rounded">
      </div>
    </div>
  </div>
@endsection
