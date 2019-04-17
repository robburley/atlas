@extends('customers.layout')

@section('title')
    Journey Team Survey &middot; {{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    Journey Team Survey
@endsection

@section('subcontent')
    <journey-team-survey customer="{{ $customer->id }}" survey="{!! isset($survey) ? $survey->id : '' !!}" user="{{ auth()->user()->id }}"></journey-team-survey>
@endsection
