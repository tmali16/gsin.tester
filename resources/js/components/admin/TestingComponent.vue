<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card rounded-0 border-0 shadow">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="firstname">Фамилия</label>
                            <input type="text" class="form-control rounded-0" id="firstname" placeholder="Фамилия">
                        </div>
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control rounded-0" id="name" placeholder="Имя">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Отчество</label>
                            <input type="text" class="form-control rounded-0" id="lastname" placeholder="Отчество">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Выберите тест</label>
                            <select id="" class="form-control">
                                
                                <option v-for="(item, i) in tests" :key="i" :value="item.id">{{item.name}}</option>
                                
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
            }
        },
        mounted() {
            this.getTest()
        },
        methods: {
            getTest: function () {
                axios.get("/api/admin/test/all").then((response)=>{
                    this.tests = response.data;
                    console.log(this.tests)
                }).catch((error)=>{
                    console.log(error)
                })
            },
            save: function () {

            }
        },
    }
</script>
