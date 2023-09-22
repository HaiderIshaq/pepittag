<template>
  <div class="container-fluid">
   
<div class="row pt-1 pt-3 pb-3">
      <div class="col-md-12 pt-2">
      <p>{{ this.userRole }}</p>
        <input type="but" placeholder="Search by any column" class="form-control bg-white" v-model="searchValue">

      </div>
      <div class="col-md-12 pt-2 ">
         <Select :options="bottlers" label="text" v-model="bottler" placeholder="Select Bottler"></Select> 
      </div>
      <div class="col-md-12 pt-2 ">
         <Select :options="types" label="text" v-model="type"></Select> 
      </div>



      
      <!-- <div class="col-md-4 " style="text-align: right">

        <a class="btn btn-primary m-1" target="_blank" >Add</a>
          
      </div> -->

      <div class="modal fade modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> <b > {{listingTitle}} </b></h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <!-- {{ statusis }} -->
              <div class="pb-3">
                <Select :options="filterregions"  @update:modelValue="getListingBySubCity($event)" placeholder="Select District"  v-model:modelValue="filterregion" label="text" class="bg-white "></Select>
              <input type="but" placeholder="Search by any column" class="form-control bg-white mt-2" v-model="searchValuelist">
                <!-- <Select :options="filterregions" label="text" v-model="type"></Select> -->

              </div>
              
              <EasyDataTable
            :headers="listheader"
            :items="listitems"
            :loading="loading1"
            :search-value="searchValuelist"
            show-index
            >
              <template #loading>
                <img
                  src="https://i.pinimg.com/originals/94/fd/2b/94fd2bf50097ade743220761f41693d5.gif"
                  style="width: 250px; height: 250px;margin-top: 10px;"
                />
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
          <template #item-conducted_on="item">
           <span   style="font-weight: 800;color:blue;cursor: alias;">{{ item.conducted_on }}</span>    
          </template>
          <template #item-completed_on="item">
           <span   style="font-weight: 800;color:green;cursor: alias;">{{ item.completed_on }}</span>    
          </template>

          </EasyDataTable>
            
            </div>
          
          </div>
        </div>
      </div>
  </div>
      <div class="col-md-12 pb-3">
        <!-- <input class="btn btn-primary m-1"  type="button" value="All" @click="getDataAll()" > -->
        <!-- <input class="btn btn-primary m-1" type="button" @click="getSites()" value="Sites"> -->
        <input class="btn btn-primary m-1" type="button" @click="getAssets()" value="Assets">
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

           <!-- <template #item-title="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:#04AA6D;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.title }}</span>    
          </template> -->
         <template #item-total_shop_in_city="item">
           <span @click="getListing(item.city_id,4,0)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;cursor: alias;">{{ item.total_shop_in_city }}</span>    
          </template>
         <template #item-active_sites="item">
           <span @click="getListing(item.city_id,0,0)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;color:red;cursor: alias;">{{ item.active_sites }}</span>    
          </template>
         <template #item-sites_conducted="item">
           <span @click="getListing(item.city_id,1,0)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;color:blue;cursor: alias;">{{ item.sites_conducted }}</span>    
          </template>
         <template #item-sites_finished="item">
           <span @click="getListing(item.city_id,2,0)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;color:green;cursor: alias;">{{ item.sites_finished }}</span>    
          </template>

          <template #item-total_assets_in_city="item">
           <span @click="getListing(item.city_id,4,1)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;cursor: alias;">{{ item.total_assets_in_city }}</span>    
          </template>

         <template #item-assets_active="item">
           <span @click="getListing(item.city_id,0,1)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;color:red;cursor: alias;">{{ item.assets_active }}</span>    
          </template>
         <template #item-assets_conducted="item">
           <span data-bs-toggle="modal" @click="getListing(item.city_id,1,1)" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;color:blue;cursor: alias;">{{ item.assets_conducted }}</span>    
          </template>
         <template #item-assets_finished="item">
           <span data-bs-toggle="modal" data-bs-target="#exampleModal" @click="getListing(item.city_id,2,1)"   style="font-weight: 800;font-size:14px;color:green;cursor: alias;">{{ item.assets_finished }}</span>    
          </template>
          <template #item-conducted_on="item">
           <span   style="font-weight: 800;color:blue;cursor: alias;">{{ item.conducted_on }}</span>    
          </template>
          <template #item-completed_on="item">
           <span   style="font-weight: 800;color:green;cursor: alias;">{{ item.completed_on }}</span>    
          </template>
           
</EasyDataTable>


<EasyDataTable
v-if="this.bottler==2"
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

           <!-- <template #item-title="item">
           <span  :style="item.status==0?'color:red;font-weight:bold':
           item.status==2?'color:#04AA6D;font-weight:bold':
           item.status==1?'color:blue;font-weight:bold':
           item.status==3?'text-decoration: line-through;':
           ''">{{ item.title }}</span>    
          </template> -->
         <template #item-total_shop_in_city="item">
           <span @click="getListing(item.city_id,4,0)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;cursor: alias;">{{ item.total_shop_in_city }}</span>    
          </template>
         <template #item-active_sites="item">
           <span @click="getListing(item.city_id,0,0)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;color:red;cursor: alias;">{{ item.active_sites }}</span>    
          </template>
         <template #item-sites_conducted="item">
           <span @click="getListing(item.city_id,1,0)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;color:blue;cursor: alias;">{{ item.sites_conducted }}</span>    
          </template>
         <template #item-sites_finished="item">
           <span @click="getListing(item.city_id,2,0)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;color:green;cursor: alias;">{{ item.sites_finished }}</span>    
          </template>

          <template #item-total_assets_in_city="item">
           <span @click="getListing(item.city_id,4,1)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;cursor: alias;">{{ item.total_assets_in_city }}</span>    
          </template>

         <template #item-assets_active="item">
           <span @click="getListing(item.city_id,0,1)" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;color:red;cursor: alias;">{{ item.assets_active }}</span>    
          </template>
         <template #item-assets_conducted="item">
           <span data-bs-toggle="modal" @click="getListing(item.city_id,1,1)" data-bs-target="#exampleModal"  style="font-weight: 800;font-size:14px;color:blue;cursor: alias;">{{ item.assets_conducted }}</span>    
          </template>
         <template #item-assets_finished="item">
           <span data-bs-toggle="modal" data-bs-target="#exampleModal" @click="getListing(item.city_id,2,1)"   style="font-weight: 800;font-size:14px;color:green;cursor: alias;">{{ item.assets_finished }}</span>    
          </template>
          <template #item-conducted_on="item">
           <span   style="font-weight: 800;color:blue;cursor: alias;">{{ item.conducted_on }}</span>    
          </template>
          <template #item-completed_on="item">
           <span   style="font-weight: 800;color:green;cursor: alias;">{{ item.completed_on }}</span>    
          </template>
</EasyDataTable>

  </div>
</template>

<style scoped>
.modal-xl {
  --bs-modal-width: 100%;
}
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
    url:String,
    userregion:String,
    usercity:String
      },
  data () {
    return {
      userRole:'',
      searchValue:'',
      searchValuelist:'',
      listingTitle:'Listing',
      loading1:false,
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
      listheader:[
        
      ],
      filterregion:'',
      filterregions:[],
      listitems: [
       
      ],
      regions:[],
      serverOptions:[{
        page: 2,
        // rowsPerPage: 5
      }],
      surveyors:[],
      surveyor:'',
      qcofficers:[],
      bottlers:[],
      qcofficer:'',
      bottler:'',
      region:'',
      cityis:'',
      typeis:'',
      cities:[],
      city:'',
      districts:[],
      district:{text:'All',value:0},
      type:{text:'Freezer',value:1},
      types:[{text:'Freezer',value:1},{text:'Vehicle',value:2}]
    }
  },
  mounted(){
    this.getUserRole();
    // this.getRegions();
    // this.getCities();
    // // this.getDistricts();
    // this.getQCOfficer();
    this.getBottlers();

    // this.getDataAll();


  },
  methods:{
    
    getListingBySubCity(event){
      // alert(city);


      if(this.typeis==0)
      {
        this.getListingBySites(event.id);
      }
      else if(this.typeis==1)
      {
        this.getListingByAssets(event.id);
      }
   
    },
    getUserRole(){
      
      const  headers= {
                'Authorization': 'Bearer ' + this.usertoken,
                'Content-Type': 'application/json'
                };
        const params={
            // type:4
        };
        axios.get('/getUserRole',{
            headers,
            params

        }).then(res=>{
          this.userRole = response.data.role;
        });       

    },
    getListingBySites(id){

      this.loading1=true;
      this.searchValuelist='';
      // this.filterregion={};
      this.listitems=[];

      this.listheader=[];
      this.listheader=[

      { text: "Region", value: "region", sortable: true },
        { text: "City", value: "city", sortable: true },
        { text: "District", value: "district", sortable: true },
        { text: "Address", value: "address", sortable: true },
        { text: "Conducted", value: "conducted_on", sortable: true },
        { text: "Completed", value: "completed_on", sortable: true },
        { text: "Contact ", value: "contact_no", sortable: true },
        { text: "Shop Name", value: "shop_name", sortable: true },
        { text: "Shop Keeper", value: "shopkeeper_name", sortable: true },

      ];

      const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
        const params={
              sub_city:id,
              status:this.statusis,
              bottler:this.bottler.value
              // district:this.district.value,
              // status_is:this.statusis,
              // surveyor:this.surveyor.id,
              // qcofficer:this.qcofficer.id
          };
      this.listitems=[];
      this.searchValue='';

      axios.get('/api/getListingForSites',{
        headers,
        params
      }).then(res=>{
        // alert('working'); 
        res.data.forEach(obj => {
          this.listitems.push({
            "region":obj.region,
            "city":obj.city,
            "conducted_on":obj.conducted_on,
            "completed_on":obj.completed_on,
            "district":obj.district,
            "address":obj.address,
            "shop_name":obj.shop_name,
            "shopkeeper_name":obj.shopkeeper_name,
            "contact_no":obj.contact_no
          });

        });         
        this.loading1=false;

      });


    },
    getListingByAssets(id){


      if(this.type.value==1)
      {
        this.loading1=true;
      this.filterregion='';
      this.searchValuelist='';
      this.listitems=[];
      this.listheader=[];
      this.listheader=[

      { text: "Action", value: "edit" },
      { text: "Action", value: "action" },
      { text: "Asset Type", value: "asset_type" },
      { text: "Asset Year#", value: "age_of_asset" },
        { text: "Title", value: "title", sortable: true },
        { text: "Shops", value: "shop_name", sortable: true },//start
        { text: "ShopKeeper", value: "shopkeeper_name", sortable: true },
        { text: "Contact_No", value: "contact_no", sortable: true },//end
        { text: "Assigned", value: "assigned_on_date", sortable: true },
        { text: "Conducted", value: "conducted_on", sortable: true },
        { text: "Completed", value: "completed_on", sortable: true },
        { text: "City", value: "city", sortable: true },
        { text: "Unit / Sub City", value: "sub_city", sortable: true },
        { text: "Address", value: "address", sortable: true },
        { text: "Tag Number #", value: "tag_number", sortable: true }

      ];

      const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
        const params={
              city:id,
              status:this.statusis,
              type:this.type.value,
              bottler:this.bottler.value

             
          };
      this.listitems=[];
      this.searchValue='';

      axios.get('/api/getListingForAssets',{
        headers,
        params
      }).then(res=>{
        // alert('working'); 
        res.data.forEach(obj => {
          this.listitems.push({
            "id":obj.id,
            "asset_type":obj.asset_type,
            "age_of_asset":obj.age_of_asset,
            // "title":obj.title,
            "title":'KGT/'+obj.city_prefix+'/VER/AFF/'+obj.id+'/'+obj.assigned_on,
            "assigned_on_date":obj.assigned_on_date,
             "shop_name":obj.shop_name,//start
            "shopkeeper_name":obj.shopkeeper_name,
            "contact_no":obj.contact_no,//end
            "conducted_on":obj.conducted_on,
            "completed_on":obj.completed_on,
            "tag_number":obj.tag_number,
            // "surveyor":obj.surveyor,
            // "qc_officer":obj.qc_officer,
            // "region":obj.region,
            "city":obj.city,
            // "status":obj.status,
            "sub_city":obj.district,
            // "location":obj.location_title,
            "address":obj.address,
            // "contact_no":obj.contact_no
          });

        });         
        this.loading1=false;

      });
      }
      else{
        this.loading1=true;
      this.filterregion='';
      this.searchValuelist='';
      this.listitems=[];
      this.listheader=[];
      this.listheader=[

      { text: "Action", value: "edit" },
      { text: "Action", value: "action" },
      { text: "Asset Type", value: "asset_type" },
        { text: "Title", value: "title", sortable: true },
        { text: "Assigned", value: "assigned_on_date", sortable: true },
        { text: "Conducted", value: "conducted_on", sortable: true },
        { text: "Completed", value: "completed_on", sortable: true },
        { text: "City", value: "city", sortable: true },
        { text: "Unit / Sub City", value: "sub_city", sortable: true },
        { text: "Address", value: "address", sortable: true },
        { text: "Tag Number #", value: "tag_number", sortable: true },
        { text: "Make", value: "make", sortable: true },
        { text: "Reg No #", value: "reg_no", sortable: true },
        { text: "Chassis No #", value: "chassis_no", sortable: true },
        { text: "Engine No #", value: "engine_no", sortable: true }

      ];

      const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
        const params={
              city:id,
              status:this.statusis,
              type:this.type.value
             
          };
      this.listitems=[];
      this.searchValue='';

      axios.get('/api/getListingForAssets',{
        headers,
        params
      }).then(res=>{
        // alert('working'); 
        res.data.forEach(obj => {
          this.listitems.push({
            "id":obj.id,
            "asset_type":obj.asset_type,
            // "title":obj.title,
            "title":'KGT/'+obj.city_prefix+'/VER/AFF/'+obj.id+'/'+obj.assigned_on,
            "assigned_on_date":obj.assigned_on_date,
            "conducted_on":obj.conducted_on,
            "completed_on":obj.completed_on,
            "tag_number":obj.tag_number,
            "city":obj.city,
            "sub_city":obj.district,
            "make":obj.make,
            "reg_no":obj.reg_no,
            "chassis_no":obj.chassis_no,
            "engine_no":obj.engine_no,
            "address":obj.address,
          });

        });         
        this.loading1=false;

      });
      }


    },

    getListing(city,status,type){
      this.searchValuelist='';
      this.statusis=status;
      this.cityis=city;
      this.typeis=type;

      if(this.type.value==1)
      {
                    // alert(city);

      
      if(status==4)
      {
        this.listingTitle='Total';
      }else if(status==1){
        this.listingTitle='Conducted';
        
      }
      else if(status==2){
        
        this.listingTitle='Finished';
      }
      else if(status==0){
        this.listingTitle='Active';

      }

              const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
        const params={
              city:city,
              status:status
              // city:this.city.value,
              // district:this.district.value,
              // status_is:this.statusis,
              // surveyor:this.surveyor.id,
              // qcofficer:this.qcofficer.id
          };

          this.filterregions=[];
          this.filterregion='';

      axios.get('/api/getRegionsForListing',{
        headers,
        params
      }).then(res=>{
        // alert('working'); 
        res.data.forEach(obj => {
          this.filterregions.push({
            // "region":obj.region,
            text:obj.name==null?'Empty/Un-Assigned':obj.name,
            id:obj.id
          });

        });         

      });

      this.listitems=[]
      }
      else{
        // alert(type);

        // this.filterregion=[];
          this.getListingByAssets(city);
      }


    },  
    // getListingAssets(city,status){
    //   // alert(city);

    //   this.statusis=status;
    //   this.cityis=city;
    //   this.typeis=1;

    //   if(status==4)
    //   {
    //     this.listingTitle='Total Assets';

    //   }else if(status==3){
    //     this.listingTitle='Assets Finished';

    //   }
    //   else if(status==2){
    //     this.listingTitle='Assets Conducted';

    //   }
    //   else if(status==0){
    //     this.listingTitle='Assets Active';

    //   }



    //   this.filterregion='';
    //   this.filterregions=[];

    //   axios.get('/api/getRegionsForListing',{
    //     headers,
    //     params
    //   }).then(res=>{
    //     // alert('working'); 
    //     res.data.forEach(obj => {
    //       this.filterregions.push({
    //         // "region":obj.region,
    //         text:obj.name,
    //         id:obj.id
    //       });

    //     });         

    //   });

    // },  
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
    showRow(item){
      // console.log(item.age);
      // window.open('edit/'+item.id, '_blank');
    },
    getBottlers(event){
          this.bottlers=[];
          this.bottler='';
          // this.bottler={text:'All',value:0};
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
            // this.bottlers.push({
            //           text:'All',
            //           value:0
            //       });  
            res.data.forEach(obj => {
                  this.bottlers.push({
                      text:obj.description,
                      value:obj.id
                  })                    
              });
          });

      },
    getDataAll(){
      this.loading=true;
      this.headers=[];
      this.headers=[

      { text: "Region", value: "region", sortable: true },
        { text: "City", value: "city", sortable: true },
        { text: "Total Sites", value: "total_shop_in_city", sortable: true },
        { text: "Active", value: "active_sites", sortable: true },
        { text: "Conducted", value: "sites_conducted", sortable: true },
        { text: "Finished", value: "sites_finished", sortable: true },
        { text: "Total Assets", value: "total_assets_in_city", sortable: true },
        { text: "Active", value: "assets_active", sortable: true },
        { text: "Conducted", value: "assets_conducted", sortable: true },
        { text: "Finished", value: "assets_finished", sortable: true }
      ];

      const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
        const params={
              type:this.type.value,
              bottler:this.bottler.value,
              // city:this.city.value,
              // district:this.district.value,
              // status_is:this.statusis,
              // surveyor:this.surveyor.id,
              // qcofficer:this.qcofficer.id
          };
      this.items=[];
      this.searchValue='';

      axios.get('/api/getstatsforadmin',{
        headers,
        params
      }).then(res=>{
        // alert('working'); 
        res.data.forEach(obj => {
          this.items.push({
            "region":obj.region,
            "city":obj.city,
            "city_id":obj.city_id,
            "total_shop_in_city":obj.total_shop_in_city,
            "active_sites":obj.active_sites,
            "sites_conducted":obj.sites_conducted,
            "sites_finished":obj.sites_finished,
            "total_assets_in_city":obj.total_assets_in_city,
            "assets_active":obj.assets_active,
            "assets_conducted":obj.assets_conducted,
            "assets_finished":obj.assets_finished
          });
          this.statusis='';

        });         
        this.loading=false;

      });

    },
    getSites(){
      this.loading=true;

      this.headers=[];
      this.headers=[

      { text: "Region", value: "region", sortable: true },
        { text: "City", value: "city", sortable: true },
        { text: "Total Sites", value: "total_shop_in_city", sortable: true },
        { text: "Active", value: "active_sites", sortable: true },
        { text: "Conducted", value: "sites_conducted", sortable: true },
        { text: "Finished", value: "sites_finished", sortable: true },
      ];

      const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
        const params={
              // type:type,
              type:this.type.value,
              // region:this.userregion,
              // city:this.city.value,
              // district:this.district.value,
              // status_is:this.statusis,
              // surveyor:this.surveyor.id,
              // qcofficer:this.qcofficer.id
          };
      this.items=[];
      this.searchValue='';

      axios.get('/api/getsitesforadmin',{
        headers,
        params
      }).then(res=>{
        // alert('working'); 
        res.data.forEach(obj => {
          this.items.push({
            "region":obj.region==null?'Empty/Un-Assigned':obj.region,
            "city":obj.city==null?'Empty/Un-Assigned':obj.city,
            "city_id":obj.city_id,
            "total_shop_in_city":obj.total_shop_in_city,
            "active_sites":obj.active_sites,
            "sites_conducted":obj.sites_conducted,
            "sites_finished":obj.sites_finished
          
          });
          this.statusis='';

        });         
        this.loading=false;

      });

    },
    getAssetsCooler(){

      this.loading=true;

      this.headers=[];
      this.headers=[

      { text: "Region", value: "region", sortable: true },
      { text: "Bottler", value: "bottler", sortable: true },
        { text: "City", value: "city", sortable: true },
        { text: "Total Assets", value: "total_assets_in_city", sortable: true },
        { text: "Active", value: "assets_active", sortable: true },
        { text: "Conducted", value: "assets_conducted", sortable: true },
        { text: "Finished", value: "assets_finished", sortable: true }
      ];

      const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
        const params={
          type:this.type.value,
          bottler:this.bottler.value
          };
      this.items=[];
      this.searchValue='';

      axios.get('/api/getassetsforadmin',{
        headers,
        params
      }).then(res=>{
        // alert('working'); 
        res.data.forEach(obj => {
          this.items.push({
            "region":obj.region==null?'Empty/Un-Assigned':obj.region,
            "bottler":obj.bottler,
            "city":obj.city,
            "city_id":obj.city_id,
            "total_assets_in_city":obj.total_assets_in_city,
            "assets_active":obj.assets_active,
            "assets_conducted":obj.assets_conducted,
            "assets_finished":obj.assets_finished
          });
          this.statusis='';

        });         
        this.loading=false;

      });


    },
    getAssetsVehicle(){

      this.loading=true;

      this.headers=[];
      this.headers=[

      { text: "Bottler", value: "bottler", sortable: true },
        { text: "Total Assets", value: "total_assets_in_city", sortable: true },
        { text: "Active", value: "assets_active", sortable: true },
        { text: "Conducted", value: "assets_conducted", sortable: true },
        { text: "Finished", value: "assets_finished", sortable: true }
      ];

      const  headers= {
                  'Authorization': 'Bearer ' + this.usertoken,
                  'Content-Type': 'application/json'
                  };
        const params={
          type:this.type.value,
          bottler:this.bottler.value
          };
      this.items=[];
      this.searchValue='';

      axios.get('/api/getassetsforadmin',{
        headers,
        params
      }).then(res=>{
        // alert('working'); 
        res.data.forEach(obj => {
          this.items.push({
            // "region":obj.region,
            "bottler":obj.bottler,
            // "city":obj.city,
            "city_id":obj.bottler_id,
            "total_assets_in_city":obj.total_assets_in_city,
            "assets_active":obj.assets_active,
            "assets_conducted":obj.assets_conducted,
            "assets_finished":obj.assets_finished
          });
          this.statusis='';

        });         
        this.loading=false;

      });


      },
    getAssets(){
      if(this.type.value==1)
      {
        this.getAssetsCooler();
      }
      else{
        this.getAssetsVehicle();
      }
    },
   
    
  }
   
  }
</script>

