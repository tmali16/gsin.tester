<template>
    <div class="container-fluid p-0 h-100 bg-dark">
        <div class="row h-100 justify-content-center ">
            <div class="col-md-8 d-flex align-items-center ">
                <div class="card rounded-0 w-100  h-75">
                    <div class="card-body">
                        <div class="container">
                            <div class="ml-5 mr-5">
                                <div class="header mt-3 mb-4">
                                    <span>Test</span>
                                </div>
                                <hr>
                                <div class="form-check" v-for="(item, i) in questions.question[index].answers" :key="i">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        {{item.question}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn w-25 pl-3 pr-3 btn-sm btn-secondary rounded-0" @click="prevQuest()">&larr; вернуться</button>
                        <button class="btn w-25 btn-success rounded-0">Prinyat</button>
                        <button class="btn w-25 btn-sm btn-secondary rounded-0" @click="nextQuest()">Пропустить &rarr;</button>
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
                questions: [],
                index: 0,
                next: 0,
                prev: 0
            }
        },
        mounted() {
            this.getQuestion()
        },
        methods: {
            getQuestion: function(){
                axios.get("/api/test/get/1").then((response)=>{
                    this.questions = response.data
                    console.log(this.questions)
                }).catch((error)=>{
                    toastr.error(error.response.status)
                })
            },
            nextQuest: function () {
                if(this.question.length > this.index){
                    this.index+1
                }
                
            },
            prevQuest: function () {
                if(this.index >=1){
                    this.index-1
                }
            }
        },
    }
</script>
