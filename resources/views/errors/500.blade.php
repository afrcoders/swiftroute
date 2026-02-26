@extends('errors.layout')

@section('code', '500')
@section('icon')
<i class="bi bi-exclamation-triangle"></i>
@endsection
@section('title', 'Server Error')
@section('message', 'Something went wrong on our end. We're working to fix it. Please try again shortly or give us a call.')
