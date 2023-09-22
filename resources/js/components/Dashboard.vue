<template>
  <div class="container-fluid pb-5">
    <div class="row mt-3">
          <div class="col-md-6 col-lg-3 col-xs-12 pt-3 pb-3">
              <div class="card p-3 shadow  rounded bg-primary text-white" @click="getDataByStatus(5)">

                  <div class="card-body ">
                      <h3>
                          <b style="">Total Assets</b>
                      </h3>
                      <h4>{{totalassets}}</h4>
                  </div>
              </div>
          </div>
          <div class="col-md-6 col-lg-3 col-xs-12 pt-3 pb-3">
              <div class="card p-3 shadow  rounded bg-danger text-white" @click="getDataByStatus(0)">

                  <div class="card-body">
                      <h3>
                          <b style="">Active</b>
                      </h3>
                      <h4>{{totalactive}}</h4>
                  </div>
              </div>
          </div>
          <div class="col-md-6 col-lg-3 col-xs-12 pt-3 pb-3">
              <div class="card p-3 shadow  rounded bg-warning" @click="getDataByStatus(1)">

                  <div class="card-body">
                      <h3>
                          <b style="">Conducted</b>
                      </h3>
                      <h4>{{totalconducted}}</h4>
                  </div>
              </div>
          </div>
          <div class="col-md-6 col-lg-3 col-xs-12 pt-3 pb-3">
              <div class="card p-3 shadow  rounded bg-success text-white" @click="getDataByStatus(2)">

                  <div class="card-body">
                      <h3>
                          <b style="">Finished</b>
                      </h3>
                      <h4>{{totalcompleted}}</h4>
                  </div>
              </div>
          </div>
      </div>
<div class="row pt-1 pt-3 pb-3">
      <div class="col-md-8 pt-2">
      <input type="but" placeholder="Search by any column" class="form-control bg-white" v-model="searchValue">

      </div>
      <div class="col-md-4 " style="text-align: right">

        <!-- <a class="btn btn-primary m-1" target="_blank" href="/add-asset">Add</a> -->
        <!-- <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#exampleModal">Add By FAR</button> -->
          
      </div>
  </div>

  <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <far :usertoken="this.usertoken"></far>
       
  </div>
  <div class="row pb-3">
    <!-- <span>search value: </span> -->
    <div class="col-md-4">
      <label for=""><b>Bottler / Company</b></label>
      <Select :options="bottlers"  v-model="bottler" label="text"></Select>
    </div>
    <div class="col-md-4">
      <label for=""><b>Asset's Type</b></label>
      <Select :options="types"   v-model="type" label="text"></Select>
    </div>
    <div class="col-md-4" v-show="this.type.value==1">
    <label for=""><b>City</b></label>

      <Select :options="cities"   v-model:modelValue="city" @update:modelValue="getDistricts($event)" label="text"></Select>

    </div>
    <div class="col-md-4 pt-2" v-show="this.type.value==1">
    <label for=""><b>District</b></label>

      <Select :options="districts"   v-model="district" label="text"></Select>

    </div>
    <div class="col-md-4 pt-2" v-show="this.type.value==1">
    <label for=""><b>Surveyors</b></label>

      <Select :options="surveyors"   v-model="surveyor" label="text"></Select>

    </div>
    <!-- <div class="col-md-4 pt-2" v-show="this.type.value==1">
    <label for=""><b>QC Officers</b></label>

      <Select :options="qcofficers"   v-model="qcofficer" label="text"></Select>

    </div> -->

    <div class="col-md-12 pt-2">
      <button class="btn btn-primary" @click="getData(1)">Search</button>
    </div>  
  </div>
      <EasyDataTable
  :headers="headers"
  :items="items"
  :loading="loading"
  @click-row="showRow"
  :search-field="searchField"
  :search-value="searchValue"
  show-index
  >
<template #loading>
  <img
  src="https://i.pinimg.com/originals/94/fd/2b/94fd2bf50097ade743220761f41693d5.gif"
                  style="width: 250px; height: 250px;margin-top: 10px;"
  />
</template>
         <template #item-asset_type="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:#04AA6D;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.asset_type }}</span>    
          </template>
          <template #item-age_of_asset="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:#04AA6D;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.age_of_asset }}</span>    
          </template>
    
           <template #item-title="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:#04AA6D;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.title }}</span>    
          </template>
          <template #item-surveyor="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:#04AA6D;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.surveyor }}</span>    
          </template>
          <!-- <template #item-qc_officer="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:#04AA6D;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.qc_officer }}</span>    
          </template> -->
          <template #item-tag_number="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:green;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.tag_number }}</span>    
          </template>
          <template #item-make="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:green;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.make }}</span>    
          </template>
          <template #item-region="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:green;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.region }}</span>    
          </template> 
          <template #item-city="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:green;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.city }}</span>    
          </template> 
          <template #item-sub_city="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:green;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.sub_city }}</span>    
          </template> 
          <template #item-address="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:green;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.address }}</span>    
          </template> 
          <template #item-contact_no="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:green;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.contact_no }}</span>    
          </template> 
          <template #item-action="item">
           <a :href="this.url+'/print-report/'+item.id" style="color:black;text-decoration: none;" target="_blank">
            <i class="fa fa-print"></i>
           </a>    
          </template>
          <template #item-edit="item">
           <a :href="this.url+'/edit/'+item.id" style="color:black;text-decoration: none;" target="_blank">
            <!-- <i class="fa fa-print"></i> -->
            <i class="fa fa-pen-to-square"></i>
           </a>    
          </template> 
    </EasyDataTable>
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
import FAR from './FAR.vue';

// import type { Header, Item } from "vue3-easy-data-table";
  export default{
      components: {
  //   EasyDataTable: window['vue3-easy-data-table'],
    'EasyDataTable': Vue3EasyDataTable,
    'Select': vSelect,
    'far':FAR
  },
  props:{
    usertoken:String,
    url:String,
    userregion:String,
    usercity:String,
    usercityname:String,
    usersubcityid:String,
    usersubcityname:String,
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
      serverItemsLength:0,
      headers:[
        
      ],
      items: [
       
      ],
      regions:[],
      serverOptions:[{
        page: 2,
        // rowsPerPage: 5
      }],
      surveyors:[],
      bottlers:[],
      bottler:'',
      surveyor:'',
      qcofficers:[],
      qcofficer:'',
      region:'',
      cities:[],
      city:'',
      districts:[],
      district:{text:'All',value:0},
      type:{text:'Freezer',value:1},
      types:[{text:'Freezer',value:1},{text:'Vehicle',value:2}]
    }
  },
  mounted(){
    this.getRegions();
    this.getCities();
    // this.getDistricts();
    this.getQCOfficer();
    this.getBottlers();
    this.getSurveyors();
    this.district={text:this.usersubcityname,value:this.usersubcityid};
    this.city={text:this.usercityname,value:this.usercity};

  },
  methods:{
    getQCOfficer(){
        this.qcofficer={text:'All',id:0};
          const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
          const params={
              type:3
          };
          axios.get('/api/getUsers',{
              headers,
              params
          
          }).then(res=>{
            this.qcofficers.push({
                      text:'All',
                      id:0
                  })      
              res.data.forEach(obj => {
                  this.qcofficers.push({
                      text:obj.name +' ('+obj.city_name+'-'+obj.sub_city_name+')',
                      id:obj.id
                  })                    
              });
          }); 
      },
      getSurveyors(){
        this.surveyor={text:'All',id:0};
          const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
          const params={
              type:4
          };
          axios.get('/api/getUsers',{
              headers,
              params
          
          }).then(res=>{
            this.surveyors.push({
                      text:'All',
                      id:0
                  })      
              res.data.forEach(obj => {
                  this.surveyors.push({
                      text:obj.name +' ('+obj.city_name+'-'+obj.sub_city_name+')',
                      id:obj.id
                  })                    
              });
          }); 
      },
    getDataByStatus(status){
      if(status==5)
      {
        this.statusis='';

      }
      else{
        this.statusis=status;
        
      }
      this.getData();

    },
    getRegions(){

      this.region={text:'All',value:0};
        const  headers= {
                'Authorization': 'Bearer ' + this.usertoken,
                'Content-Type': 'application/json'
                };
        const params={
            // type:4
        };
        axios.get('/api/getRegions',{
            headers,
            params

        }).then(res=>{
          this.regions.push({
            text:'All',
            value:0
          });
            res.data.forEach(obj => {
                this.regions.push({
                    text:obj.name,
                    value:obj.id
                })                    
            });
        }); 
    },
    getCities(){

      this.city={text:'All',value:0};
        const  headers= {
                'Authorization': 'Bearer ' + this.usertoken,
                'Content-Type': 'application/json'
                };
        const params={
          city:this.userregion

        };
        axios.get('/api/getCity',{
            headers,
            params

        }).then(res=>{
          this.cities.push({
            text:'All',
            value:0
          });
            res.data.forEach(obj => {
                this.cities.push({
                    text:obj.name,
                    value:obj.id
                })                    
            });
        }); 
      },
      getDistricts(event){
          this.districts=[];
          this.district='';
          this.district={text:'All',value:0};
          const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
          const params={
              city:event.value
          };
          axios.get('/api/getDistricts',{
              headers,
              params
          
          }).then(res=>{
            this.districts.push({
                      text:'All',
                      value:0
                  });  
            res.data.forEach(obj => {
                  this.districts.push({
                      text:obj.name,
                      value:obj.id
                  })                    
              });
          });


          // this.sites=[];
          // this.site='';
          
          // axios.get('/api/getSites',{
          //     headers,
          //     params
          
          // }).then(res=>{
          //     res.data.forEach(obj => {
          //         this.sites.push({
          //             text:obj.address,
          //             id:obj.id
          //         })                    
          //     });
          // });
           

      },
      getBottlers(event){
          this.bottlers=[];
          this.bottler='';
          this.bottler={text:'All',value:0};
          const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
          const params={
              // bottler:event.value
          };
          axios.get('/api/getBottlers',{
              headers,
              params
          
          }).then(res=>{
            this.bottlers.push({
                      text:'All',
                      value:0
                  });  
            res.data.forEach(obj => {
                  this.bottlers.push({
                      text:obj.description,
                      value:obj.id
                  })                    
              });
          });

      },
    showRow(item){
      // console.log(item.age);
      // window.open('edit/'+item.id, '_blank');
    },
    getDataAll(type){
      this.loading=true;

      this.headers=[];
      this.headers=[
      { text: "Action", value: "edit" },
      { text: "Action", value: "action" },
      { text: "Asset Type", value: "asset_type" },
      { text: "Asset Year#", value: "age_of_asset" },
        { text: "Title", value: "title", sortable: true },
        { text: "Tag Number #", value: "tag_number", sortable: true },
        { text: "Surveyor", value: "surveyor", sortable: true },
        // { text: "QC Officer", value: "qc_officer", sortable: true },
        { text: "Region", value: "region", sortable: true },
        { text: "City", value: "city", sortable: true },
        { text: "Sub City", value: "sub_city", sortable: true },
        { text: "Address", value: "address", sortable: true },
        { text: "Contact #", value: "contact_no", sortable: true },
      ];

      const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
        const params={
              type:type,
              region:this.userregion,
              city:this.city.value,
              district:this.district.value,
              status_is:this.statusis,
              bottler:this.bottler.value,
              surveyor:this.surveyor.id,
              qcofficer:this.qcofficer.id
          };

      this.items=[];
      this.searchValue='';

      axios.get('/api/getData',{
        headers,
        params
      }).then(res=>{
        // alert('working'); 
        res.data.forEach(obj => {
          this.items.push({
            "id":obj.id,
            "asset_type":obj.asset_type,
            "age_of_asset":obj.age_of_asset,
            // "title":obj.title,
            "title":'KGT/'+obj.city_prefix+'/VER/AFF/'+obj.id+'/'+obj.assigned_on,
            "tag_number":obj.tag_number,
            "surveyor":obj.surveyor,
            "qc_officer":obj.qc_officer,
            "region":obj.region,
            "city":obj.city,
            "status":obj.status,
            "sub_city":obj.district,
            "location":obj.location_title,
            "address":obj.address,
            "contact_no":obj.contact_no,
          });
          this.statusis='';

        });         
      

      });

      axios.get('/api/getSurveyStats',{
        headers,
        params
      }).then(res=>{
        res.data.forEach(obj => {

          this.totalassets=obj.total_assets;
          this.totalactive=obj.total_active;
          this.totalconducted=obj.total_conducted;
          this.totalcompleted=obj.total_completed;

          });  
          
      this.loading=false;
        
      });
    },
    getDataVehicle(type){

      this.loading=true;

      this.headers=[];
      this.headers=[
      { text: "Action", value: "edit" },
      { text: "Action", value: "action" },
      { text: "Asset Type", value: "asset_type" },
        { text: "Title", value: "title", sortable: true },
        { text: "Tag Number #", value: "tag_number", sortable: true },
        { text: "Make", value: "make", sortable: true },
        { text: "Reg No #", value: "reg_no", sortable: true },
        { text: "Engine No #", value: "engine_no", sortable: true },
        { text: "Surveyor", value: "surveyor", sortable: true },
        // { text: "QC Officer", value: "qc_officer", sortable: true },
        { text: "Region", value: "region", sortable: true },
        { text: "City", value: "city", sortable: true },
        { text: "Sub City", value: "sub_city", sortable: true },
        { text: "Address", value: "address", sortable: true },
        { text: "Contact #", value: "contact_no", sortable: true }
      ];

      const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
        const params={
          type:type,
              region:this.userregion,
              city:this.city.value,
              bottler:this.bottler.value,
              district:this.district.value,
              status_is:this.statusis,
              surveyor:this.surveyor.id,
              qcofficer:this.qcofficer.id

          };
      this.items=[];
      this.searchValue='';

      axios.get('/api/getData',{
        headers,
        params
      }).then(res=>{
        // alert('working'); 
        res.data.forEach(obj => {
          this.items.push({
            "id":obj.id,
            "asset_type":obj.asset_type,
            // "title":obj.title,
            "title":'KGT/'+obj.city_prefix+'/VER/AFF/'+obj.id+'/'+obj.assigned_on,
            "tag_number":obj.tag_number,
            "make":obj.make,
            "reg_no":obj.reg_no,
            "engine_no":obj.engine_no,
            "surveyor":obj.surveyor,
            "qc_officer":obj.qc_officer,
            "region":obj.region,
            "city":obj.city,
            "status":obj.status,
            "sub_city":obj.district,
            "location":obj.location_title,
            "address":obj.address,
            "contact_no":obj.contact_no,
          });
          
        });
        this.statusis='';

      });

      axios.get('/api/getSurveyStats',{
        headers,
        params
      }).then(res=>{
        res.data.forEach(obj => {

          this.totalassets=obj.total_assets;
          this.totalactive=obj.total_active;
          this.totalconducted=obj.total_conducted;
          this.totalcompleted=obj.total_completed;

          });         
      this.loading=false;

      });

    },
    getDataCooler(type){
      this.loading=true;

      this.headers=[];
      this.headers=[
        { text: "Action", value: "edit" },
      { text: "Action", value: "action" },
      { text: "Asset Type", value: "asset_type" },
      { text: "Asset Year#", value: "age_of_asset" },
        { text: "Title", value: "title", sortable: true },
        { text: "Tag Number #", value: "tag_number", sortable: true },
        { text: "Shop Name", value: "shop_name", sortable: true },
        { text: "Shopkeeper Name", value: "shopkeeper_name", sortable: true },
        { text: "Surveyor", value: "surveyor", sortable: true },
        // { text: "QC Officer", value: "qc_officer", sortable: true },
        { text: "Region", value: "region", sortable: true },
        { text: "City", value: "city", sortable: true },
        { text: "Sub City", value: "sub_city", sortable: true },
        { text: "Address", value: "address", sortable: true },
        { text: "Contact #", value: "contact_no", sortable: true }
      ];

      const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
        const params={
          type:type,
              region:this.userregion,
              city:this.city.value,
              district:this.district.value,
              status_is:this.statusis,
              surveyor:this.surveyor.id,
              bottler:this.bottler.value,
              qcofficer:this.qcofficer.id

          };
      this.items=[];
      this.searchValue='';

      axios.get('/api/getData',{
        headers,
        params
      }).then(res=>{
        // alert('working'); 
        res.data.forEach(obj => {
          this.items.push({
            "id":obj.id,
            "asset_type":obj.asset_type,
            "age_of_asset":obj.age_of_asset,
            "title":'KGT/'+obj.city_prefix+'/VER/AFF/'+obj.id+'/'+obj.assigned_on,
            "tag_number":obj.tag_number,
            "reg_no":obj.reg_no,
            "shop_name":obj.shop_name,
            "shopkeeper_name":obj.shopkeeper_name,
            "engine_no":obj.engine_no,
            "surveyor":obj.surveyor,
            "qc_officer":obj.qc_officer,
            "region":obj.region,
            "city":obj.city,
            "status":obj.status,
            "sub_city":obj.district,
            "location":obj.location_title,
            "address":obj.address,
            "contact_no":obj.contact_no,
          });
        }); 
        this.statusis='';

      });

      axios.get('/api/getSurveyStats',{
        headers,
        params
      }).then(res=>{
        res.data.forEach(obj => {

          this.totalassets=obj.total_assets;
          this.totalactive=obj.total_active;
          this.totalconducted=obj.total_conducted;
          this.totalcompleted=obj.total_completed;

          });         
          this.loading=false;

        });


    },
    getData(){
     
      if(this.type.value==1)
      {
        this.getDataCooler(1);
      }
      else if(this.type.value==2)
      {
        this.getDataVehicle(2);
      }
      else{
        this.getDataAll(0);

      }

    }
  }
   
  }
</script>

