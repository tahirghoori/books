@extends('layouts.master')


@section('content')
@include('partials.searchForm')

@if(Input::get('searchQuery'))
    @include('partials.showRecordsPartial')
@endif

    <hr/>
@stop