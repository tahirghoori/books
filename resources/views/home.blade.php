@extends('layouts.master')

@section('content')
    @include('partials.addOrEditPartial')
    <hr/>
    To perform a search please click <a href="search">here</a>
    <hr/>

    @include('partials.showRecordsPartial')

    <hr/>
    <hr/>
    @include("partials.uploadCSVFilePartial")



@stop