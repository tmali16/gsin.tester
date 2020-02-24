@extends('base')

@section("title")
Admin - NEW Testing User
@endsection
@section('nav')
    @include("nav")
@endsection
@section("content")
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<create-testing-component>
</create-testing-component>
@endsection