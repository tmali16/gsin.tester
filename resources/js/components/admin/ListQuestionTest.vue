<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card rounded-0 border-1 shadow-1">
                    <div class="card-body ">
                       <div class="col-12 text-center">
                           <h4>Тесты</h4>
                           <hr>
                        <div v-for="(item, i) in getData.tests" :key="i" class="col-12">
                            <span class="btn btn-link text-left col-8 p-0 mb-3" @click="selectTest(item.id)">
                                {{item.name}}
                            </span>
                            <button class="btn btn-sm rounded-0 btn-success col-3 p-0 mb-3" @click="showSettings(item.id)"> <img src="/images/settings.png" alt="" style="width: 16px;"> </button>
                        </div>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card rounded-0 border-1 shadow-1">
                    <div class="card-body">
                       <div class="col-12 text-center border-bottom-1">
                            <label for="">Тест {{selectedTestData.name}}</label>
                       </div>
                       <hr>
                        <table class="table table-bordered mt-2">
                            <thead class="p-1">
                                <tr >
                                    <th scope="col" class="pt-1 pb-1" width="10">№</th>
                                    <th scope="col" class="pt-1 pb-1">Вопросы</th>
                                    <th scope="col" class="pt-1 pb-1">ответы</th>
                                    <th scope="col" class="pt-1 pb-1">действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, i) in selectedTestData.question" :key="i" class="">
                                    <th scope="row" class="m-0">{{i+1}}</th>
                                    <th class="m-0">{{item.question}}</th>
                                    <th>
                                        <ul class="m-0">
                                            <li v-for="(it, i) in item.answers" :key="i">{{it.answer}} <span v-if="it.right == 1">*</span> </li>
                                        </ul>
                                    </th>
                                    <th width="180" class="text-center m-0">
                                        <button class="btn btn-sm rounded-0 btn-info">Изменить</button>
                                        <button class="btn btn-sm rounded-0 btn-danger">Улалить</button>
                                    </th>
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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                testBaseData: 0,
                question: "Нет текста",
                answers: [1, 2],
                getData: [],
                selectedTestData: [],
                retStatus: [],
                testCount: 1,
                testSettings: [],
                quest_count: 0,
                quest_random: 0,
                answer_random: 0,
                test_duration: 0,
                testDuration: 1,
            }
        },
        mounted() {
            this.gets()
        },
        methods: {
            getCountedTest:function(){
                axios.get("api/admin/getCount").then((Response)=>{
                    this.testBaseData = Response.data;
                }).catch((error)=>{
                    console.log(error)
                })
            },
            gets: function(){
                axios.get('/api/admin/get').then((response)=>{
                    this.getData = response.data
                    this.selectTest(1)
                }).catch(function(error){
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
                        test_id: this.selectedTestData.id
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
                let url = "/api/admin/test/get/"+i;
                axios.get(url).then((response)=>{
                    this.selectedTestData = response.data[0]
                    console.log(this.selectedTestData)
                }).catch((error)=>{
                    console.log(url)
                    console.log("!!!!! ERROR !!!! function store persona STATUS CODE=" + error.response.status +';  message: ' + error.response.data.message)
                })
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
            },
            getSettings: function (i) {
              axios.get("/api/admin/test/settings/get/"+i).then((response)=>{
                  this.testSettings = response.data.settings
                  this.quest_count = this.testSettings.quest_count
                  this.quest_random = this.testSettings.quest_random
                  this.answer_random = this.testSettings.answer_random
                  this.test_duration = this.testSettings.duration
                  this.testCount = (this.quest_count == 0 ? 1 : 0)
                  this.testDuration = (this.test_duration == 0 ? 1 : 0)
                  toastr.success("Загружено", 'Настройки')
                  toastr.options.progressBar = true;
                  toastr.options.hideMethod = 'slideUp';
              }).catch((error)=>{
                  toastr.error(error.response.status)
              })  
            },
            showSettings: function (i) {
                $("#settingsTest").modal("show")
                this.getSettings(i)
            },
            saveSettings: function (i) {
              axios({
                url: "/api/admin/test/settings/save/"+i,
                method: "POST",
                data:{
                    quest_count: this.quest_count,
                    quest_random: this.quest_random,
                    answer_random: this.answer_random,
                    duration: this.test_duration,
                    test_id: i,
                    id: this.testSettings.id
                }
              }).then((response)=>{
                if(response.data.status == "ok"){
                    this.quest_count = 0
                    this.quest_random = 0
                    this.answer_random = 0
                    this.test_duration = 0
                    this.testDuration = 1
                    this.testCount = 1
                    this.retStatus = response.data
                    toastr.info(this.retStatus.message, "Сообшение");
                    $("#settingsTest").modal("hide")
                }
              }).catch((error)=>{
                  toastr.error(error.response.status, 'Inconceivable!')
              })
            },
            chBox: function (i) {
                if(i == "quest_count"){
                    this.testCount = $("input[name="+i+"]:checked").val();
                }
                if(i == "test_duration"){
                    this.testDuration = $("input[name="+i+"]:checked").val();
                }
            }

        },

    }
</script>
