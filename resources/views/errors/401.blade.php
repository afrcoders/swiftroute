@extends('errors.layout')

@section('code', '401')
@section('icon')
<i class="bi bi-lock"></i>
@endsection
@section('title', 'Unauthorized')
@section('message', 'You need to be authenticated to access this page. Please log in and try again.')
