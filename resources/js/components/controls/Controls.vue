<template>
      <div class="row pt-1 pt-3 pb-3">
        <div class="col-md-12" style="text-align: right">
            <!-- <add></add> -->
        <a class="btn btn-primary m-1" href="/add-asset">Add</a>

            
        </div>
    </div>
</template>

<script>
import Add from './Add.vue';

    export default {
        mounted() {
            console.log('Component mounted.')
        },
        components:{
            'add':Add
        }
    }
</script>
