@extends('errors.layout')

@section('code', '419')
@section('icon')
<i class="bi bi-clock-history"></i>
@endsection
@section('title', 'Page Expired')
@section('message', 'Your session has expired. Please go back and try again — this usually happens if the page was open too long.')
@section('extra')
<p class="small text-muted mb-4">Try refreshing the page or submitting the form again.</p>
@endsection
