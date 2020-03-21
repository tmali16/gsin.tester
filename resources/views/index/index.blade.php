@extends('base')

@section("title")
Index page
@endsection

@section("content")
    <div class="flex-center position-ref full-height" id="user_index_auth">
        <div class="content " > 
            <div class="text-white bg-4">
                <h4 class="display-4  title shadow text-success shadow-1">
                    ГСИН при ПКР
                </h4>
            </div>
            
            <div class="h-100 w-100 d-flex align-items-center justify-content-center ">
                
                <div class="card rounded-0 w-75 border-0 shadow" style="">
                    <div class="card-body">
                        @if($errors->count()> 0)
                            <div class="alert alert-danger rounded-0 w-100  text-center">
                                {{$errors->first()}}
                            </div>
                        @endif
                        <form action="{{route('chckUser')}}" method="get">
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