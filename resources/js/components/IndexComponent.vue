<template>
    <div class="container-fluid p-0 h-100 bg-dark">
        <div class="row h-100 justify-content-center ">
            <div class="col-md-8 d-flex align-items-center ">
                <div class="card rounded-0 w-100  h-75">
                    <div class="card-body">
                        <div class="w-100 mt-1 mb-3 text-center " style="border-bottom: 1px solid">
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
            'user_id',
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
                settings: []
            }
        },
        mounted() {
            this.getQuestion()
        },
        methods: {
            getQuestion: function(){
                axios.get("/api/admin/test/get/"+this.user_id
                ).then((response)=>{
                    this.test = response.data.test
                    this.settings = response.data.settings
                    this.countQuest = this.test.question.length
                    this.currentTest(this.active)
                }).catch((error)=>{
                    toastr.error(error.response)
                })
            },
            otvet: function (question_id) {
                this.currentTest(this.active)
                this.questAnswer()
                if(this.answers.length < this.settings.quest_count ){
                    this.answers.push({
                        'question_id': question_id, 
                        'answer_id': this.answerID
                    })
                }else{
                    this.sendAnswer(this.answers, this.test.id);
                }
            },
            sendAnswer(data, test_id){
                axios({
                    method: "POST",
                    url: "/api/test/answer/"+this.user_id,
                    data:{
                        data: data,
                        test_id: test_id
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
                this.currQuest = this.test.question[this.active-1]
            },

            questAnswer: function () {
                this.answerID = $("input[name=AnswerRadios"+(this.currQuest.id)+"]:checked").val()
            }
        },
    }
</script>
