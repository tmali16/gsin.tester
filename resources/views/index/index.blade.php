@extends('base')

@section("title")
Index page
@endsection

@section("content")
    <div class="container h-100">
        <div class="row h-100 d-flex align-items-center justify-content-center " style="vertical-align: middle"> 
            <h1 class="display-4  ">Добро пожаловать!</h1>
            <div class="h-100 w-100 d-flex align-items-center justify-content-center ">
                
                <div class="card rounded-0 w-75" style="max-height: 400px; min-height: 200px; min-width: 300px; max-width: 500px">
                    <div class="card-body">
                        @if($errors->count()> 0)
                            <div class="alert alert-danger rounded-0 w-100  text-center">
                                {{$errors->first()}}
                            </div>
                        @endif
                        <form action="{{route("chckUser")}}" method="get">
                            @csrf
                            <label for="id">Введите Ваш код:</label>
                            <div class="form-group">
                                <input type="text" class="form-controll rounded-0" name="id" id="id">
                                <button class="btn rounded-0 btn-success btn-sm">Войти</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection