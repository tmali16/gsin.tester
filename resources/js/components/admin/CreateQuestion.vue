<template>
    <div class="row mt-2">
        <div class="col-md-12">
        
        </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
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
                        <button class="col btn btn-success btn-sm rounded-0" @click="addAnswer()" v-if="answers.length <= 5">
                            +
                        </button>
                    </div>
                    <div class="col">
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
                testBaseData: 0,
                question: "Нет текста",
                answers: [1, 2],
                getData: [],
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
