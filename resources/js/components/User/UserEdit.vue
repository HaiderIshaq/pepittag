<template>
    <div class="container-fluid">
        <div class="row pt-4 pb-2">
            <h3 >
              <b>Edit User #{{ jobid }}</b>
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
                <button @click="postData()" class="btn btn-primary m-1">Save</button>
                <button @click="changePassword()" class="btn btn-danger m-1">Change Password</button>
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
      jobid:Number,
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
      this.getData();
    //   this.getDistricts();
    //   this.getQCOfficer();
    //   this.getSurveyors();

    // alert(this.jobid);
    },
    methods:{
      postData(){
            const  headers= {
                        'Authorization': 'Bearer ' + this.usertoken,
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                        };
                const params={
                  profilename:this.profilename,
                  username:this.username,
                  password:this.password
                    
                };
                axios.post('/api/updateUser/'+this.jobid,params,{
                    headers
                
                }).then(res=>{
                    // console.log(params);
                    alert('User Updated' );
                    this.getData();
                    // this.v$.$reset();
                    // window.open('edit/'+res.data, '_blank');

                });
        },
        changePassword(){
            const  headers= {
                        'Authorization': 'Bearer ' + this.usertoken,
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                        };
                const params={
                  password:this.password
                    
                };
                axios.post('/api/updatePassword/'+this.jobid,params,{
                    headers
                
                }).then(res=>{
                    // console.log(params);
                    alert('Password Changed');
                    this.getData();
                    // this.v$.$reset();
                    // window.open('edit/'+res.data, '_blank');

                });
        },
        getData(){
            const d = new Date();
              let year = d.getFullYear();
       
            const  headers= {
                    'Authorization':
                     'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            axios.get('/api/getDataforuser/'+this.jobid,{
            headers:headers
        }).then(res=>{
                res.data.forEach(obj => {
                    this.profilename=obj.name;  
                    // this.isVerified=obj.is_verified;  
                    // this.tagNumberProvided=obj.tag_number_by_client;  
                    // this.typeProvided=obj.type_by_client;  
                    // this.tagNumberVisible=obj.tag_number_visible;  
                    // this.engineProvided=obj.engine_no_by_client;  
                    // this.makeProvided=obj.make_by_client;  
                    // this.chassisProvided=obj.chassis_no_by_client;  
                    // this.refId='KGT/'+obj.city_prefix+'/VER/AFF/'+this.id+'/'+obj.created_at;  
                    // this.surveyType={text:obj.asset_type,id:obj.asset_id};                    
                    // this.surveyor={text:obj.surveyor_name,id:obj.surveyor_id};
                    // this.qcofficer={text:obj.qc_officer_name,id:obj.qc_officer_id};
                    this.role={text:obj.role_name,id:obj.role};
                    this.region={text:obj.region_name,id:obj.region};
                    this.city={text:obj.city_name,id:obj.city};
                    this.district={text:obj.sub_city_name,id:obj.sub_city};
                    this.username=obj.email;
                    // this.password=obj.password;
                    // if(obj.asset_id==1)
                    // {
                    //     this.freezerType=obj.type;
                    //     this.freezerTypeOther=obj.type_other;
                    // }
                    // else{
                    //     this.vehicleType=obj.type;
                    //     this.vehicleTypeOther=obj.type_other;
                    // }
                    // this.make=obj.make;
                    // this.contactNo=obj.contact_no;
                    // this.assigned=obj.assigned_on;
                    // this.siteassigned=obj.site_assigned_on;
                    // this.siteconducted=obj.site_conducted_on;
                    // this.conducted=obj.conducted_on;
                    // this.sitestatus=obj.site_status;
                    // this.status=obj.status;
                    // this.gps=obj.gps;
                    // this.siteid=obj.site_id;
                    // this.isSiteAccessible=obj.is_site_accessible;
                    // this.isSameLocation=obj.same_location;
                    // this.volume={text:obj.volume};
                    // this.inventory=obj.utilization;
                    // this.otheraddress=obj.other_address;
                    // this.sharedPepsi=obj.utilization_pepsi;
                    // this.modelNoProvided=obj.model_no_by_client;
                    // this.sharedOthers=obj.utilization_shared;
                    // this.sharedProductedDetails=obj.shared_products_name;
                    // this.existance=obj.existance;
                    // this.isFunctional=obj.functional;
                    // this.reasonNoFunctional=obj.reason_for_no_operational;
                    // this.isCoolerAccessible=obj.is_cooler_accessible;
                    // this.generalCondition=obj.general_condition;
                    // this.shopName=obj.shop_name;
                    // this.shopKeeperName=obj.shopkeeper_name;
                    // this.regNo=obj.reg_no;
                    // this.engineNo=obj.engine_no;
                    // this.chassisNo=obj.chassis_no;
                    // this.modelNo=obj.model_number;
                    // this.vehicleOwnership=obj.is_vehicle_destributed;
                    
                    // this.getCities({id:obj.region_id});
                    // this.getDistricts({id:obj.city_id});
                });

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

