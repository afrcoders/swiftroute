@extends('errors.layout')

@section('code', '429')
@section('icon')
<i class="bi bi-shield-exclamation"></i>
@endsection
@section('title', 'Too Many Requests')
@section('message', 'You've made too many requests in a short time. Please wait a moment and try again.')
