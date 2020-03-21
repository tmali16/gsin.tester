@extends('base')

@section("title")
Index page
@endsection

@section("content")

<index-component test_id="{{$test_id}}" user_id="{{$user_id}}" ></index-component>
@endsection