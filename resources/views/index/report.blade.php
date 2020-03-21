@extends('base')

@section("title")
Report
@endsection
@section("content")

<div class="container-fluid p-0 h-100 bg-dark">
    <div class="row h-100 justify-content-center ">
        <div class="col-md-8 d-flex align-items-center ">
            <div class="card rounded-0 w-100  h-50">
                <div class="card-body">
                    <div  class="questions">                            
                        <div  class="question">
                            <div class="question" >                            
                                <div class="jumbotron jumbotron-fluid">
                                    <div class="container">
                                        <h4 class="display-4">Тест окончен</h4>
                                        <p class="lead">{{$data->right}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button class="btn w-25 btn-success rounded-0" >Prinyat</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection