@extends('base')

@section("content")
<div class="flex-center position-ref full-height" id="">
    <div class="content">
        <div class="title m-b-sm display-5" style="font-size: 46px;">
            Добро пожаловать!
        </div>

        <div class="links">
            <h3 class="display-5">
                {{$name}}
            </h3>            
        </div>
        <div class="card">
            <div class="card-body">
                <span class="display-5 w-100">У Вас {{$testing->test->Settings->quest_count}} вопросов / {{$testing->test->Settings->duration}} минут</span>
                <hr class="mt-2 mb-2">
                <form action="{{url("/start", $testing->_id)}}">
                    <button class="btn btn-info text-white">Начать тест</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection