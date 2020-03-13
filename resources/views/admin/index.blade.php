@extends('base')

@section("title")
Administrator
@endsection
@section('nav')
    @include("nav")
@endsection
@section("content")
<div class="container mt-5" id="admin_">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card rounded-0 shadow-sm border-0">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <dashboard-component></dashboard-component>

                    <div class="col">                        
                        <!-- Button trigger modal -->
                        <a href="{{route("create_test")}}" class="btn btn-primary rounded-0">
                            Создать тест
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection