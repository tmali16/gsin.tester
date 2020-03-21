<template>        
        <div class="modal-body">   
            {{retStatus.message}}
            <div class="form-group col " v-if="false">
                <label for="ques_test">Тип вопроса</label>
                {{test_id}}
                <select id="ques_test" class="form-control">
                    <option selected>Choose...</option>
                </select>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="ques_test">Суроо</label>
                
                    <textarea id="ques_test" class="form-control" v-model="question_kg">
                    </textarea>
                </div>
                <div class="col-sm-6">
                    <label for="ques_test">Вопрос</label>
                    <textarea id="ques_test" class="form-control" v-model="question_ru">
                    </textarea>
                </div>
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
                <button class="col btn btn-success btn-sm rounded-0" @click="addAnswer()" v-if="answers.length <= 5">
                    +
                </button>
            </div>
            <div class="col">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">закрыть</button>
                <button type="button" class="btn btn-primary" @click="pushAnswer()">Сохранить</button>
            </div>
        </div>
</template>

<script>
    export default {
        props:[
            "test_id"
        ],
        data() {
            return {
                testBaseData: 0,
                question: "Нет текста",
                answers: [1, 2],
                getData: [],
                retStatus: [],
                testCount: 1,
                testDuration: 1,
                question_ru: "",
                question_kg: "",
                selectedTestData: []
            }
        },
        mounted() {

        },
        methods: {
            getCountedTest:function(){
                axios.get("api/admin/getCount").then((Response)=>{
                    this.testBaseData = Response.data;
                }).catch((error)=>{
                    console.log(error)
                })
            },

            pushAnswer: function () {
                axios({
                    url: "/api/admin/question/new",
                    method: "POST",
                    data:{
                        question_kg: this.question_kg,
                        question_ru: this.question_ru,
                        answers: this.getAnswers(),
                        test_id: this.test_id
                    }
                }).then((response)=>{
                    this.retStatus = response.data;
                    toastr.info(response.data.message)                    
                }).catch((error)=>{
                    console.log("!!!!! ERROR !!!! function pushAnswer   message: " + error.response.data.message)
                })
            },
            addAnswer:function(){
                if(this.answers.length <= 5){
                    this.answers.push(this.answers[this.answers.length - 1] +1);
                }
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
