@extends('base')

@section("title")
Admin - new test
@endsection
@section('nav')
    @include("nav")
@endsection
@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card rounded-0 mt-5">
                <div class="card-header">
                    <h5 class="display-5">Новый тест</h5>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card rounded-0 mt-5">
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                Тест
                            </a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                Настройки
                            </a>
                        </div>
                      </nav>
                      <form action="{{route("new_test")}}" method="post">
                      <div class="tab-content" id="nav-tabContent">
                        
                            @csrf
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="form-group col pt-3">
                                    <div class="row">
                                        <div class=" col-sm-6">
                                            <label for="name_kg">Тесттин аталышы</label>
                                        </div>
                                        <div class=" col-sm-6">
                                            <label for="name_ru">Название теста</label>
                                        </div>
                                        <div class=" col-sm-6">
                                            <input type="text" id="name_kg" class="form-control rounded-0" name="name_kg" placeholder="Тесттин аталышы" required/>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="name_ru" class="form-control rounded-0" name="name_ru" placeholder="Название теста" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="ques_test">Баяндоо</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="ques_test">Описание</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <textarea id="ques_test" class="form-control rounded-0" name="description_kg" rows="2">
                                            </textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <textarea id="ques_test" class="form-control rounded-0" name="description_ru" rows="2">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="modal-body row">
                                    <div class="form-group col-md-12 ">
                                        <label for="" class="col text-info border_bottom"><b>Количество задаваемых вопросв</b></label>
                                        <div class="form-check form-check-inline col">
                                            <input class="form-check-input" type="radio" name="quest_count" id="testCount1" value="0" checked="checked">
                                            <label class="form-check-label" for="testCount1">Все вопросы</label>
                                        </div>
                                        <div class="form-check form-check-inline col">
                                            <input class="form-check-input" type="radio" name="quest_count" id="testCount2" value="1">
                                            <label class="form-check-label" for="testCount2">
                                                Случайные
                                                <input type="number" class="form-controll form-controll-sm rounded-0" name="quest_count_num" style="width: 50px;" >
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-5 ">
                                        <label for="" class="col text-info"><b>Задавать вопросы</b></label>
                                        <div class="form-check form-check-inline col">
                                            <input class="form-check-input" type="radio" name="quest_random" id="quest_random1" value="1" checked="checked">
                                            <label class="form-check-label" for="quest_random1">В случайном порядке</label>
                                        </div>
                                        <div class="form-check form-check-inline col">
                                            <input class="form-check-input" type="radio" name="quest_random" id="quest_random2" value="0" >
                                            <label class="form-check-label" for="quest_random2">
                                                По порядку
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-5 ">
                                        <label for="" class="col text-info"><strong>Предлогать ответы<strong></label>
                                        <div class="form-check form-check-inline col">
                                            <input class="form-check-input" type="radio" name="answer_random" id="answer_random1" value="1" checked="checked">
                                            <label class="form-check-label" for="answer_random1">В случайном порядке</label>
                                        </div>
                                        <div class="form-check form-check-inline col">
                                            <input class="form-check-input" type="radio" name="answer_random" id="answer_random2" value="0">
                                            <label class="form-check-label" for="answer_random2">
                                                По порядку
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 ">
                                        <label for="" class="col text-info"><b>Время</b></label>
                                        <div class="form-check form-check-inline col">
                                            <input class="form-check-input" type="radio" name="duration" id="test_duration1" value="0"  >
                                            <label class="form-check-label" for="test_duration1">Не ограничивать</label>
                                        </div>
                                        <div class="form-check form-check-inline col">
                                            <input class="form-check-input" type="radio" name="duration" id="test_duration2" value="1" checked="checked">
                                            <label class="form-check-label" for="test_duration2">
                                                Ограничить время на выполнение теста
                                                <input type="number" class="form-controll form-controll-sm rounded-0" name="duration_min" style="width: 50px;" value="30" >
                                                минутами
                                            </label>
                                        </div>
                                    </div>
                                </div>                                  
                            </div>
                            <hr>
                            <button class="btn btn-info text-light" >Сохранить</button>
                        
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection