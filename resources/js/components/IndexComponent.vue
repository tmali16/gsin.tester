<template>
    <div class="container-fluid p-0 h-100 bg-dark">
        <div class="row h-100 justify-content-center ">
            <div class="col-md-8 d-flex align-items-center ">
                <div class="card rounded-0 w-100  h-50">
                    <div class="card-body">
                        <div class="w-100 d-flex justify-content-start " style="border-bottom: 1px solid">
                            <label for="" class="col h3">{{test.name_ru}}</label>
                            <span class=" badge budge-success">{{active +" / "+ countQuest}}</span>
                        </div>
                        <div  class="questions">                            
                            <div  class="question">
                                <div class="question" v-for="(item, i) in test.question" v-show="active==(i+1)" :key="i">
                                    <div class="header mt-1">
                                        <span>{{item.question_ru}}</span>
                                    </div>
                                    <hr class="m-1">
                                    <div class="form-check variant" v-for="(answer, ind) in item.answers" :key="ind">
                                        <input class="form-check-input" type="radio" :name="'AnswerRadios'+item.id" :id="'exampleRadios'+answer.id+i" :value="answer.id" @change="currentTest(ind)">
                                        <label class="form-check-label col" :for="'exampleRadios'+answer.id+i">
                                            {{answer.answer}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn w-25 pl-3 pr-3 btn-sm btn-secondary rounded-0" @click="moveQuest(-1)">&larr; вернуться</button>
                        <button class="btn w-25 btn-success rounded-0" @click="otvet(currQuest.id)">Prinyat</button>
                        <button class="btn w-25 btn-sm btn-secondary rounded-0" @click="moveQuest(1)">Пропустить &rarr;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>    
    
    export default {
        props:[
            'test_id',
            'user_id'
        ],

        data() {
            return {
                test: [],
                countQuest: 0,
                index: 0,
                active: 1,
                currQuest: [],
                answerID: null,
                answers: [],
                settings: [],
                options: {
                    autostart: true,
                 }
            }
        },
        mounted() {
            this.getQuestion()
        },
        methods: {
            getQuestion: function(){
                axios.get("/api/admin/test/get/"+this.test_id
                ).then((response)=>{
                    this.test = response.data.test
                    this.settings = response.data.settings
                    this.countQuest = this.test.question.length
                    this.currentTest(this.active)
                    
                }).catch((error)=>{
                    toastr.error("Error get Question from server message :"+error)
                })
            },
            otvet: function (question_id) {
                let check = 1;
                this.currentTest(this.active)
                this.questAnswer()
                if(!check || this.answers.length == (this.test.question.length-1)){
                    this.answers.push({
                        'question_id': question_id, 
                        'answer_id': this.answerID
                    })
                    if(this.answers.length < (this.settings.quest_count-1) || this.answers.length >= this.test.question.length ){
                        check = 1;
                    }
                    console.log("== with settings ==");
                    console.log(this.answers);
                    console.log(this.answers.length + " == End settings == "+this.settings.quest_count);
                }else if(this.settings.quest_count == null && this.answers.length < this.test.question.length){
                    this.answers.push({
                        'question_id': question_id, 
                        'answer_id': this.answerID
                    })
                    console.log("== push if null ==");
                }else{
                    this.sendAnswer(this.answers, this.test_id);
                }
                this.countQuest = this.test.question.length
                this.test.question.splice((this.active-1), 1)
            },
            sendAnswer(dats, tst_id){
                axios({
                    method: "POST",
                    url: "/api/test/answer/"+this.user_id,
                    data:{
                        answer: dats
                    }
                }).then((response)=>{
                    this.test.question.splice((this.active-1), 1)
                    this.currentTest(this.active)
                    this.countQuest = this.test.question.length
                })
            },
            moveQuest: function (a) {
                let newAct
                const newInd = this.active + a
                if(newInd > this.test.question.length) newAct=1
                if(newInd === 0)newAct = this.test.question.length
                this.active = newAct || newInd
            },
            currentTest: function (id) {
                if(this.currQuest.length != 0){
                    this.currQuest = this.test.question[this.active-1]
                }
            },
            timerStart: function () {
              this.$timer.start('log')  
            },
            questAnswer: function () {
                if(this.currQuest.length != 0){
                    this.answerID = $("input[name=AnswerRadios"+(this.currQuest.id)+"]:checked").val()
                }
            }
        },
    }
</script>
