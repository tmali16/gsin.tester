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
                                    <div class="header mt-2 m2-4">
                                        <span>{{item.question}}</span>
                                    </div>
                                    <hr class="m-1">
                                    <div class="form-check variant" v-for="(answer, ind) in item.answers" :key="ind">
                                        <input class="form-check-input" type="radio" :name="'exampleRadios'+i" :id="'exampleRadios'+answer.id+i" value="1" >
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
                        <button class="btn w-25 btn-success rounded-0">Prinyat</button>
                        <button class="btn w-25 btn-sm btn-secondary rounded-0" @click="moveQuest(1)">Пропустить &rarr;</button>
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
                test: [],
                countQuest: 0,
                index: 0,
                next: 0,
                prev: 0,
                active: 1,
                slides: 0,
            }
        },
        mounted() {            
            this.getQuestion()
            // this.reInit()
        },
        methods: {
            getQuestion: function(){
                axios.get("/api/test/get/1").then((response)=>{
                    this.test = response.data
                    this.countQuest = this.test.question.length
                }).catch((error)=>{
                    toastr.error(error.response)
                    console.log(error)
                })
            },
            sendAnswer(question_id, answer_id){
                axios({
                    method: "POST",
                    url: "/api/test/answer/"+test_id,
                    data:{
                        question_id: question_id,
                        answer_id: answer_id
                    }
                }).then((response)=>{
                    toastr.error(response.error.data.message);
                })
            },
            moveQuest: function (a) {
                let newAct
                const newInd = this.active + a
                if(newInd > this.test.question.length) newAct=1
                if(newInd === 0)newAct = this.test.question.length
                this.active = newAct || newInd                
            }
        },
    }
</script>
