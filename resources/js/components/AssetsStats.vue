<template>
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card p-3 shadow  rounded bg-primary text-white">

                    <div class="card-body ">
                        <h3>
                            <b style="">Total Assets Added</b>
                        </h3>
                        <h4>{{totalassets}}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow  rounded bg-danger text-white">

                    <div class="card-body">
                        <h3>
                            <b style="">Active Verifications</b>
                        </h3>
                        <h4>{{totalactive}}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="card p-3 shadow  rounded bg-warning">

                    <div class="card-body">
                        <h3>
                            <b style="">Total Conducted</b>
                        </h3>
                        <h4>{{totalconducted}}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow  rounded bg-success text-white">

                    <div class="card-body">
                        <h3>
                            <b style="">Finished Verifications</b>
                        </h3>
                        <h4>{{totalcompleted}}</h4>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return{
                totalassets:0,
                totalactive:0,
                totalconducted:0,
                totalcompleted:0
            }
        },
        props:{
            usertoken:String,
            userid:String
        },
        methods:{

            
            getStats(){

                const  headers= {
                        'Authorization': 'Bearer ' + this.usertoken,
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                        };

                        const params={

                        }
                axios.get('/api/getSurveyStats',{
          headers,
          params
        }).then(res=>{
          res.data.forEach(obj => {


            });         
        });
            }
        }
    }
</script>
