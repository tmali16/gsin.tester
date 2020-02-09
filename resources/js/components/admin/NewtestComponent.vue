<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="card rounded-0 border-1 shadow-1">
                    <div class="card-body text-center">
                       <div class="col-12">
                           <h4>Тесты</h4>
                           <hr>
                        <div v-for="(item, i) in getData.tests" :key="i">
                            <span class="btn col btn-link" @click="selectTest(i)">
                                {{item.name}}
                            </span>
                            
                        </div>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card rounded-0 border-1 shadow-1">
                    <div class="card-body">
                       <div class="col-12 text-center border-bottom-1">
                            <label for="">Тест {{selectedTest.name}}</label>
                       </div>
                       <hr>
                        <table class="table table-bordered mt-2">
                            <thead class="p-1">
                                <tr >
                                    <th scope="col" class="pt-1 pb-1" width="10">№</th>
                                    <th scope="col" class="pt-1 pb-1">Вопросы</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, i) in getData.question" :key="i">
                                    <th scope="row">{{i++}}</th>
                                    <th>{{item.question}}</th>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                        Добавить Вопрос
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0 modal-dialog-scrollable">
                <div class="modal-header p-2">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Добавить вопрос</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    {{retStatus.message}}
                    <div class="form-group col " v-if="false">
                        <label for="ques_test">Тип вопроса</label>
                        <select id="ques_test" class="form-control">
                            <option selected>Choose...</option>
                        </select>
                    </div>
                    <div class="form-group col">
                        <label for="ques_test">Вопрос</label>
                        <textarea id="ques_test" class="form-control" v-model="question">
                        </textarea>
                    </div>
                    <strong for="" class="col m-2">Варианты ответов:</strong>
                    <div class="answers">
                        <div class="form-group col answer_hover" v-for="(item, index) in answers" :key="index">
                            <input type="text" :id="'ques_test'+item" class="form-control rounded-0"/>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" name="rest" :id="'ques_test_right'+item" :value="'ques_test'+item">
                                <label class="form-check-label" :for="'ques_test_right'+item">
                                    Правильный ответ
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <button class="col btn btn-success btn-sm rounded-0" @click="addAnswer()" v-if="answers.length >= 5">
                            +
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">закрыть</button>
                    <button type="button" class="btn btn-primary" @click="pushAnswer()">Сохранить</button>
                </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                testCount: 0,
                question: "Нет текста",
                answers: [1, 2],
                getData: [],
                selectedTest: [],
                retStatus: []
            }
        },
        mounted() {
            this.gets()
        },
        methods: {
            getCountedTest:function(){
                axios.get("api/admin/getCount").then((Response)=>{
                    this.testCount = Response.data;
                }).catch((error)=>{
                    console.log(error)
                })
            },
            gets: function(){
                axios.get('/api/admin/get').then((response)=>{
                    this.getData = response.data
                    this.selectTest(0)
                }).catch(function(error){
                    re = false;
                    console.log("!!!!! ERROR !!!! function get STATUS CODE=" + error.response.status +';  message: ' + error.response.data.message)
                })
            },
            pushAnswer: function () {
                axios({
                    url: "/api/admin/question/new",
                    method: "POST",
                    data:{
                        question: this.question,
                        answers: this.getAnswers(),
                        test_id: this.selectedTest.id
                    }
                }).then((response)=>{
                    if(response.data.status == 'ok'){
                        this.retStatus = response.data;
                    }
                }).catch((error)=>{
                    console.log("!!!!! ERROR !!!! function store persona STATUS CODE=" + error.response.status +';  message: ' + error.response.data.message)
                })
            },
            addAnswer:function(){
                if(this.answers.length <= 5){
                    this.answers.push(this.answers[this.answers.length - 1] +1);
                }
            },
            selectTest: function (i) {
                this.selectedTest = this.getData.tests[i]
                console.log(this.selectedTest)
            },
            getAnswers: function () {
                let ret = [];
                for(let i = 1; i <= this.answers.length; i++){
                    let answer = $("#ques_test"+i).val();
                    let right = $("input[id=ques_test_right"+i+"]").is(":checked");
                    let rs = {
                        'answer': answer,
                        'right': right
                    }
                    ret.push(rs)
                }
                return ret;
            }

        },

    }
</script>
