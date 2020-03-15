@extends('base')

@section("title")
Admin - Test list
@endsection
@section('nav')
    @include("nav")
@endsection
@section("content")
    <list-tests-component></list-tests-component>
@endsection