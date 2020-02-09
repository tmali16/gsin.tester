<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="card rounded-0 border-1">
                    <div class="card-header bg-info  text-light pt-1 pb-1">Всего тестов</div>

                    <div class="card-body text-center">
                       <span class=""> {{testCount}}</span>
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
                testCount: 0
            }
        },
        mounted() {
            this.getCountedTest()
        },
        methods: {
            getCountedTest:function(){
                axios.get("api/admin/getCount").then((Response)=>{
                    this.testCount = Response.data;
                }).catch((error)=>{
                    console.log(error)
                })
            }
        },

    }
</script>
