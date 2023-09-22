<template>
    <div class="container-fluid" style="padding-bottom:50px">
        <div class="row pt-3">
            <div class="col-md-9">
                <a href="/">
                    <button class="btn btn-primary">Back</button>
                </a>   
            </div>
            <div class="col-md-3 text-end">
                <a href="/user-create">
                    <button class="btn btn-primary">Add</button>
                </a>   
            </div>
        </div>
        <div class="row pt-3">

            <EasyDataTable
            :headers="headers"
            :items="items"
            show-index
            :loading="loading"    
            :server-items-length="serverItemsLength"
            @click-row="showRow"
            :search-field="searchField"
            :search-value="searchValue">
                <template #loading>
                    <img
                    src="https://i.pinimg.com/originals/94/fd/2b/94fd2bf50097ade743220761f41693d5.gif"
                    style="width: 250px; height: 250px;margin-top: 10px;"
                    />
                </template>
            
                <template #item-edit="item">
                <a :href="this.url+'/edituser/'+item.id" style="color:black;text-decoration: none;" target="_blank">
                <!-- <i class="fa fa-print"></i> -->
                <i class="fa fa-pen-to-square"></i>
                </a>    
                </template> 
            </EasyDataTable>
        </div>

    </div>
</template>

<style scoped>
.fail-row  {
  --easy-table-body-row-background-color: #f56c6c;
  --easy-table-body-row-font-color: #fff;
}
.pass-row  {
  --easy-table-body-row-background-color: #67c23a;
  --easy-table-body-row-font-color: #fff;
}

.customize-table {
  --easy-table-border: 1px solid #445269;
  --easy-table-row-border: 1px solid #445269;

  --easy-table-header-font-size: 14px;
  --easy-table-header-height: 50px;
  --easy-table-header-font-color: #c1cad4;
  --easy-table-header-background-color: #2d3a4f;

  --easy-table-header-item-padding: 10px 15px;

  --easy-table-body-even-row-font-color: #fff;
  --easy-table-body-even-row-background-color: #4c5d7a;

  --easy-table-body-row-font-color: #c0c7d2;
  --easy-table-body-row-background-color: #2d3a4f;
  --easy-table-body-row-height: 50px;
  --easy-table-body-row-font-size: 14px;

  --easy-table-body-row-hover-font-color: #2d3a4f;
  --easy-table-body-row-hover-background-color: #eee;

  --easy-table-body-item-padding: 10px 15px;

  --easy-table-footer-background-color: #2d3a4f;
  --easy-table-footer-font-color: #c0c7d2;
  --easy-table-footer-font-size: 14px;
  --easy-table-footer-padding: 0px 10px;
  --easy-table-footer-height: 50px;

  --easy-table-rows-per-page-selector-width: 70px;
  --easy-table-rows-per-page-selector-option-padding: 10px;
  --easy-table-rows-per-page-selector-z-index: 1;


  --easy-table-scrollbar-track-color: #2d3a4f;
  --easy-table-scrollbar-color: #2d3a4f;
  --easy-table-scrollbar-thumb-color: #4c5d7a;;
  --easy-table-scrollbar-corner-color: #2d3a4f;

  --easy-table-loading-mask-background-color: #2d3a4f;
}
</style>

<script>
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import "vue-select/dist/vue-select.css";
import vSelect from "vue-select";

// import type { Header, Item } from "vue3-easy-data-table";
    export default{
        components: {
    //   EasyDataTable: window['vue3-easy-data-table'],
      'EasyDataTable': Vue3EasyDataTable,
      'Select': vSelect,
    },
    props:{
      usertoken:String,
      url:String
        },
    data () {
      return {
        searchValue:'',
        loading:false,
        totalassets:0,
        statusis:'',
                totalactive:0,
                totalconducted:0,
                totalcompleted:0,
        serverItemsLength:5,
        headers:[
          
        ],
        items: [
         
        ],
        regions:[],
        surveyors:[],
        surveyor:'',
        qcofficers:[],
        qcofficer:'',
        region:'',
        cities:[],
        city:'',
        districts:[],
        district:'',
        type:{text:'All',value:0},
        types:[{text:'All',value:0},{text:'Freezer',value:1},{text:'Vehicle',value:2}]
      }
    },
    mounted(){
      this.getData();
    //   this.getCities();
    //   this.getDistricts();
    //   this.getQCOfficer();
    //   this.getSurveyors();
    },
    methods:{
      
      showRow(item){
        // console.log(item.age);
        // window.open('edit/'+item.id, '_blank');
      },
      getData(){
        this.headers=[];
        this.headers=[
        { text: "Action", value: "edit" },
        { text: "Name", value: "name", sortable: true },
          { text: "Email", value: "email", sortable: true },
          { text: "Role", value: "role", sortable: true },
          { text: "Region", value: "region", sortable: true },
          { text: "City", value: "city", sortable: true },
          { text: "District", value: "district", sortable: true },
        ];

        const  headers= {
                    'Authorization': 'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
          const params={
                // type:type,
                // region:this.region.value,
                // city:this.city.value,
                // district:this.district.value,
                // status_is:this.statusis,
                // surveyor:this.surveyor.id,
                // qcofficer:this.qcofficer.id
            };
        this.items=[];
        this.searchValue='';

        axios.get('/api/getUsersListing',{
          headers,
          params
        }).then(res=>{
          // alert('working'); 
          res.data.forEach(obj => {
            this.items.push({
              "id":obj.id,
              "name":obj.name,
              "email":obj.email,
              "role":obj.role,
              "region":obj.region_name,
              "city":obj.city_name,
              "district":obj.sub_city_name

            });
            this.loading=false;

          });         
        });

      }
    }
     
    }
</script>

