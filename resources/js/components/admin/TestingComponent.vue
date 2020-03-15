<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card rounded-0 border-0 shadow">
                    <div class="card-body">
                        <div class="res w-100 h-100" v-if="ret.status == 'ok'">
                            <span class="d-flex">
                                <div class="jumbotron w-100">
                                    <h5 class="display-4">Ураа...!</h5>
                                    <p class="lead">Новый тестируемый добавлен успешно. </p>                                      
                                    <hr class="my-4">
                                    <h3 class="display-3">{{ret.kod}}</h3>
                                    <p class="lead">Данный код преднозначен для прохождения теста</p>
                                </div>
                            </span>
                        </div>
                        <div class="addData" v-else>
                            <div class="form-group">
                                <label for="firstname">Фамилия</label>
                                <input type="text"  v-bind:class="'form-control rounded-0 '+(errors.fname != undefined || errors.fname > 0 ? 'is-invalid' : '')" id="firstname" placeholder="Фамилия" v-model="fname">
                                <div class="invalid-feedback" v-if="errors.fname != undefined && errors.fname.length > 0">
                                    {{errors.fname}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Имя</label>
                                <input type="text" v-bind:class="'form-control rounded-0 '+(errors.mname != undefined || errors.mname > 0 ? 'is-invalid' : '')" id="name" placeholder="Имя" v-model="mname">
                                <div class="invalid-feedback" v-if="errors.mname != undefined && errors.mname.length > 0">
                                    {{errors.mname}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Отчество</label>
                                <input type="text" class="form-control rounded-0" id="lastname" placeholder="Отчество" v-model="lname">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Выберите тест</label>
                                <select id="" class="form-control" v-model="test_id">                                
                                    <option v-for="(item, i) in tests" :key="i" :value="item.id">{{item.name_ru}}</option>                                
                                </select>
                            </div>
                            <div class="card-footer">
                                <div class="col">
                                    <button class="btn btn-info text-white rounded-0 float-right" @click="save">
                                        Добавить
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="spinner-grow text-primary" role="status" id="Spinner" style="display: hidden">
                        <span class="sr-only" style="">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
    
    export default {

        props:[
            
        ],
        data() {
            return {
                resCode: 0,
                tests: [],
                fname: "",
                mname: "",
                lname: "",
                test_id: 0,
                errors: [],
                ret: [],
            }
        },
        mounted() {
            $("#Spinner").hide()
            this.getTest()
        },
        methods: {
            getTest: function () {
                $("#Spinner").show()
                axios.get("/api/admin/test/all").then((response)=>{
                    this.tests = response.data;
                    $("#Spinner").hide()
                }).catch((error)=>{
                    console.log(error)
                })
            },
            save: function () {
                $("#Spinner").hide()
                axios({
                    method: "POST",
                    url: "/api/admin/test/add/user",
                    data: {
                        fname: this.fname,
                        mname: this.mname,
                        lname: this.lname,
                        test_id: this.test_id,
                    }
                }).then((response)=>{
                    if(response.data.status == "ok"){
                        this.ret = response.data;
                        toastr.info("Сообщение", response.data.message)
                    }
                    if(response.data.status == "error"){
                        this.errors = response.data
                        toastr.error( "Ошибка заполнения полей", "Ошибка")
                    }
                    $("#Spinner").hide()
                }).catch((error)=>{
                    console.log(error.response)
                })
            }
        },
    }
</script>
