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

                    <div class="row">                        
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            Создать тест
                        </button>
                    </div>
                </div>
						</div>
						<div class="card rounded-0 shadow-sm border-0">
							<div class="card-body">
								<a href="" class="btn-link"></a>
							</div>
						</div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Создать тест</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route("new_test")}}" method="post">
								@csrf
								
                <div class="form-group col">
                    <label for="ques_test">Название теста</label>
                    <input type="text" id="test_name" class="form-control rounded-0" name="name_test" required/>
                </div>
                <div class="form-group col">
                    <label for="ques_test">Описание</label>
                    <textarea id="ques_test" class="form-control rounded-0" name="test_description" rows="5">
                    </textarea>
                </div>
                <a class="btn btn-secondary btn-sm" data-dismiss="modal">Close</a>
                <button href="" class="btn btn-sm btn-success">
                    Создать
                </button>
          		</form>
        </div>
      </div>
    </div>
</div>
@endsection