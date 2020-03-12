@extends('base')

@section("title")
Index page
@endsection

@section("content")
<index-component user_id="{{$user_id}}"></index-component>
@endsection