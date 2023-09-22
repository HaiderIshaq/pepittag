<template>
    <div class="container-fluid">
        <div class="row pt-4 pb-2">
            <h3 >
              <b>Add User</b>
            </h3>
        </div>
        <div class="row pt-2 pb-2">
            <div class="col-md-3 col-sm-12">
              <label for="pb-1">
                <b>Profile Name</b>
              </label>
              <input type="text" v-model="profilename" class="mt-1 form-control bg-white" placeholder="Profile Name" id="">
              <div v-if="v$.profilename.$error" class="text-danger">Required</div>

            </div>
        </div>
        <div class="row pt-2 pb-2">
            <div class="col-md-3 col-sm-12">
              <label for="pb-1">
                <b>Role</b>
              </label>
              <Select :options="roles" v-model="role" label="text"></Select>
              <div v-if="v$.role.$error" class="text-danger">Required</div>

            </div>
        </div>
        <div class="row pt-2 pb-2">
            <div class="col-md-3 col-sm-12">
              <label for="pb-1">
                <b>Regions</b>
              </label>
              <Select :options="regions"  @update:modelValue="getCities($event)"  v-model:modelValue="region" label="text"></Select>
            </div>
        </div>
        <div class="row pt-2 pb-2">
            <div class="col-md-3 col-sm-12">
              <label for="pb-1">
                <b>City</b>
              </label>
              <Select :options="cities" v-model:modelValue="city" @update:modelValue="getDistricts($event)" label="text"></Select>
              <div v-if="v$.city.$error" class="text-danger">Required</div>
         
            </div>
        </div>
        <div class="row pt-2 pb-2">
            <div class="col-md-3 col-sm-12">
              <label for="pb-1">
                <b>District</b>
              </label>
              <Select :options="districts" v-model="district" label="text"></Select>
              <div v-if="v$.district.$error" class="text-danger">Required</div>
            
            </div>
        </div>
        <div class="row pt-2 pb-2">
            <div class="col-md-3 col-sm-12">
              <label for="pb-1">
                <b>User Name</b>
              </label>
              <input type="email" v-model="username" name="" class="mt-1 form-control bg-white" placeholder="Username" id="">
              
              <div v-if="v$.username.$error"  class="text-danger">
                  Email type and this field is Required
              </div>
            
            </div>
        </div>
        <div class="row pt-2 pb-2">
            <div class="col-md-3 col-sm-12">
              <label for="pb-1">
                <b>Password</b>
              </label>
              <input type="text" v-model="password" name="" class="mt-1 form-control bg-white" placeholder="Password" id="">
              <div v-if="v$.password.$error" class="text-danger">Required</div>
            
            </div>
        </div>
        <div class="row pt-2 pb-2">
            <div class="col-md-3 col-sm-12">
                <button @click="addUser()" class="btn btn-primary">Save</button>
            </div>
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
import useVuelidate from "@vuelidate/core";
import { email, required, minLength } from "@vuelidate/validators";

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
    setup: () => ({ v$: useVuelidate() }),
    data () {
      return {
        searchValue:'',
        loading:false,
        totalassets:0,
        statusis:'',
        profilename:'',
        username:'',
        password:'',
        serverItemsLength:5,
        headers:[
          
        ],
        items: [
         
        ],
        regions:[],
        roles:[],
        surveyors:[],
        surveyor:'',
        role:'',
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
      this.getRegions();
      this.getRoles();
    //   this.getDistricts();
    //   this.getQCOfficer();
    //   this.getSurveyors();
    },
    methods:{
      postData(){

        const  headers= {
                        'Authorization': 'Bearer ' + this.usertoken,
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                        };
                const params={
                    profile_name:this.profilename,
                    username:this.username,
                    password:this.password,
                    role:this.role.id,
                    city:this.city.id,
                    sub_city:this.district.id
                 };
                axios.post('/api/addUser',params,{
                    headers
                
                }).then(res=>{
                    // console.log(params);
                    alert('User Register' );
                    // this.getRefId();
                    // this.v$.$reset();
                    window.open('/users');

                });


      },
      addUser(){
        // profile_name:this.profilename,
        //             username:this.username,
        //             password:this.password,
        //             role:this.role.id,
        //             city:this.city.id,
        //             sub_city:this.district.id
            this.v$.profilename.$touch();
            this.v$.username.$touch();
            this.v$.password.$touch();
            this.v$.role.$touch();
            this.v$.city.$touch();
            this.v$.district.$touch();

      if (!this.v$.$validationGroups.firstGroup.$invalid) {
          
          this.postData();
          this.v$.profilename.$reset();
            this.v$.username.$reset();
            this.v$.password.$reset();
            this.v$.role.$reset();
            this.v$.city.$reset();
            this.v$.district.$reset();
      }
                },
      getRoles(){
            const  headers= {
                    'Authorization': 'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            const params={
            };
            axios.get('/api/getRoles',{
                headers,
                params
            
            }).then(res=>{

                res.data.forEach(obj => {
                    this.roles.push({
                        text:obj.name,
                        id:obj.id
                    })                    
                });
            }); 
        },
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
           
              res.data.forEach(obj => {
                  this.regions.push({
                      text:obj.name,
                      id:obj.id
                  })                    
              });
          }); 
      },
      getCities(event){
            this.cities=[];
            this.city='';

            const  headers= {
                    'Authorization': 'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            const params={
                city:event.id
            };
            axios.get('/api/getCity',{
                headers,
                params
            
            }).then(res=>{
                res.data.forEach(obj => {
                    this.cities.push({
                        text:obj.name,
                        id:obj.id,
                        prefix:obj.prefix
                    })                    
                });
            }); 

        },
        getDistricts(event){
            this.districts=[];
            this.district='';
            const  headers= {
                    'Authorization': 'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            const params={
                city:event.id
            };
            axios.get('/api/getDistricts',{
                headers,
                params
            
            }).then(res=>{
                res.data.forEach(obj => {
                    this.districts.push({
                        text:obj.name,
                        id:obj.id
                    })                    
                });
            }); 

        },
      showRow(item){
        // console.log(item.age);
        // window.open('edit/'+item.id, '_blank');
      },
      getDataAll(type){
        this.headers=[];
        this.headers=[
        { text: "Action", value: "edit" },
        { text: "Action", value: "action" },
        { text: "Asset Type", value: "asset_type" },
          { text: "Title", value: "title", sortable: true },
          { text: "Tag Number #", value: "tag_number", sortable: true },
          { text: "Surveyor", value: "surveyor", sortable: true },
          { text: "QC Officer", value: "qc_officer", sortable: true },
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
                region:this.region.value,
                city:this.city.value,
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
            this.loading=false;

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
        });
      },
      getDataVehicle(type){
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
          { text: "QC Officer", value: "qc_officer", sortable: true },
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
                region:this.region.value,
                city:this.city.value,
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
          this.loading=false;

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
        });
      },
      getDataCooler(type){
        this.headers=[];
        this.headers=[
          { text: "Action", value: "edit" },
        { text: "Action", value: "action" },
        { text: "Asset Type", value: "asset_type" },
          { text: "Title", value: "title", sortable: true },
          { text: "Tag Number #", value: "tag_number", sortable: true },
          { text: "Shop Name", value: "shop_name", sortable: true },
          { text: "Shopkeeper Name", value: "shopkeeper_name", sortable: true },
          { text: "Surveyor", value: "surveyor", sortable: true },
          { text: "QC Officer", value: "qc_officer", sortable: true },
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
                region:this.region.value,
                city:this.city.value,
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
          this.loading=false;

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
        });
      },
      getData(){
       
        this.loading=true;
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
    },
    validations () {
    return {
        profilename: {
          required
        },
        role: {
          required,
        },
        city:{
            required
        },
        district:{
            required
        },
        username:{
            required,
            email

        },
        password:{
            required
        },
        $validationGroups: {
        firstGroup: [
          'profilename',
          'role',
          'city',
          'district',
          'username',
          'password'
        ]
        }

       
    }
  },
     
    }
</script>

