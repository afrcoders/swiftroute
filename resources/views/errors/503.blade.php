@extends('errors.layout')

@section('code', '503')
@section('icon')
<i class="bi bi-tools"></i>
@endsection
@section('title', 'Under Maintenance')
@section('message', 'We're currently performing scheduled maintenance to improve our services. We'll be back shortly!')
@section('extra')
<p class="small text-muted mb-4">If you need immediate assistance, please call us directly.</p>
@endsection
