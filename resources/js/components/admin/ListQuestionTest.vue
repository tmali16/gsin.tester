<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="card rounded-0 border-1 shadow-1">
                    <div class="card-body ">
                       <div class="col-12 text-center">
                           <h4>Тесты</h4>
                           <hr>
                        <div v-for="(item, i) in getData.tests" :key="i" class="col-12">
                            <span class="btn btn-link text-left col-8 p-0 mb-3" @click="selectTest(item.id)">
                                {{item.name_ru}}
                            </span>
                            <a class="btn btn-sm rounded-0 btn-success col-3 p-0 mb-3" :href="'/admin/test/edit/'+item.id"> <img src="/images/settings.png" alt="" style="width: 16px;"> </a>
                        </div>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card rounded-0 border-1 shadow-1">
                    <div class="card-body">
                       <div class="col-12 text-center border-bottom-1">
                            <label for="" >Тест {{selectedTestData.name_ru}}</label><br>
                            <span class="col-md-9" style="white-spice: nowrap; overflow: hidden; text-overflow: ellipsis;">{{selectedTestData.description_ru}}</span>
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
                                    <th class="m-0">{{item.question_ru}}<hr> {{item.question_kg}}</th>
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
        <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        Добавить вопрос
                    </div>
                    <question></question>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import question from './CreateQuestion.vue';
    export default {
        components:{
            question
        },
        data() {
            return {
                testBaseData: 0,
                getData: [],
                selectedTestData: [],
                retStatus: [],
                testCount: 1,

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
 
            selectTest: function (i) {
                let url = "/api/admin/test/get/"+i;
                axios.get(url).then((response)=>{
                    this.selectedTestData = response.data[0]
                }).catch((error)=>{
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
