<template>
    <div class="container-fluid pt-5" style="padding-top: 50px;padding-bottom: 50px;margin-top: 40px;">
        <div class="col-sm-12">
            <div class="row" >
                <div class="col-sm-12 text-center" >
                    <a href="/">
                
                    <i class="fa fa-home " style="font-size: 25px; padding-bottom: 15px;margin:15px;color:black;text-decoration: none;"></i>
                    
                    </a>                  
                    <a :href="'/editsurvey/'+this.id">
                
                    <i class="fa fa-edit " style="font-size: 25px; padding-bottom: 15px;margin:15px;color:black;text-decoration: none"></i>
                    
                    </a>                  
                
                </div>
            </div>
              <div class="row">
                <div style="width: 60%;float: left;text-align: start;">
                  <a :href="'/editsurvey/'+this.id">
                    <button class="btn btn-primary" >Back</button>
                  </a>                  
                </div>
                <div style="width: 40%;float: left;text-align: end;">
                    <a :href="'/survey-assetinfo/'+this.id">
                    <button class="btn btn-danger" >Next</button>
                  </a>  

                </div>
              </div>


            </div>
        <div class="row pt-4">
           
            <div class="col-md-12 col-sm-12">
              <h5 class="mt-3">
                <b>Survey General Info #{{ id }}</b>
              </h5>
 
            </div>

        </div>
        <div class="row">
            
            <div class="col-sm-12 m-3 text-center">
                <i class="fa fa-location" @click="getLocation()" style="font-size: 22px;margin-top: 10px;"></i>
            
            </div>
            <div class="col-sm-12 m-3 text-center">
                        <p v-if="errorMessage">{{ errorMessage }}</p>
                        <p v-else-if="location"><b> Current GPS: </b> {{ location.latitude }}, {{ location.longitude }}</p>
                        <p class="text-danger" v-if="mylocation==''"> <b> No Location Found</b></p>
                        <p class="text-success" v-else> <b> {{ mylocation }}</b></p>
                    </div>
                        <div class="col-sm-12" v-show="this.surveytypeis==1">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                            <label  class=" col-form-label" style="font-weight:bold">Shop's Name</label>
                                            <input type="text" name="" class="form-control bg-white" v-model="shopName" id="">                                    
                                    </div>
                                    <div class="form-group col-sm-6">
                                            <label  class=" col-form-label" style="font-weight:bold">Shopkeeper's Name</label>
                                            <input type="text" name="" class="form-control bg-white" id="" v-model="shopKeeperName">                                    
                                    </div>
                                </div>

                            </div>
                    </div>
                    <div class="row">
                            <div class="col-md-12">

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label  class=" col-form-label" style="font-weight:bold">Region</label>
                                    <v-select :options="regions" label="text" @update:modelValue="getCities($event)"  v-model:modelValue="region" class=""></v-select>
                                        
                            </div>
                            <div class="col-sm-4">
                                    <label  class=" col-form-label" style="font-weight:bold">City</label>
                                    <v-select :options="cities" label="text" class="" v-model:modelValue="city" @update:modelValue="getDistricts($event)"></v-select>
                                        
                            </div>
                            <div class="col-sm-4">
                                    <label  class=" col-form-label" style="font-weight:bold">Districts</label>
                                    <v-select :options="districts" label="text" class="" v-model="district"></v-select>
                                        
                            </div>
                            </div>
                        
                        </div>
                    </div>
        <div class="row">

                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-8">
                                    <label  class=" col-form-label" style="font-weight:bold">Address</label>
                                    <textarea name="" class="form-control bg-white" id="" cols="10" rows="10" style="height:20px" v-model="address"></textarea>
                                </div>

                            <div class="col-sm-4">
                                    <label  class=" col-form-label"  style="font-weight:bold">Contact No</label>
                                    <input type="text" v-model="contactNo" class="form-control bg-white">

                            </div>

                            </div>
                        
                        </div>
                        <div class="col-sm-3">
                            <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Site Accessible</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" v-model="isSiteAccessible" type="radio"  id="inlineRadio1" value="Yes">
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" v-model="isSiteAccessible"  id="inlineRadio2" value="No">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Same Location</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"  v-model="isSameLocation" id="inlineRadio1" value="Yes">
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"  id="inlineRadio2" v-model="isSameLocation" value="No">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>
                        <div class="col-sm-8" v-show="this.isSameLocation=='No'">
                            <label  class=" col-form-label" style="font-weight:bold">Another Address</label>
                            <textarea name="" class="form-control bg-white" id="" cols="10" rows="10" style="height:20px" v-model="anotheraddress"></textarea>
                        </div>
                        <div class="col-sm-3">
                            <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Location Verified</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" v-model="isVerified" type="radio"  id="inlineRadio1" value="Yes">
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" v-model="isVerified"  id="inlineRadio2" value="No">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>
                    </div>
        <div class="row mt-3 mb-3">
            <div class="col-sm-12">
                <button  class="btn btn-primary" @click="postData()">Save</button>
                <button  class="btn btn-danger "  style="margin-left: 10px;" @click="updateLocation()"  >Update Location</button>
                <button  class="btn btn-success "  style="margin-left: 10px;" @click="submitSiteSurvey()"  >Submit Site</button>

            </div>
        </div>


    </div>
</template>
<style>

</style>

<script>
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

export default {
  props:{
    usertoken:String,
    id:String,
    userid:String,
    surveytypeis:String
  },
  components:{
        "v-select": vSelect,
    //   EasyDataTable: window['vue3-easy-data-table'],
    },
  data() {
    return {
            types:[
                
                ],
                surveyType:'',
                mylocation: null,
                location: null,
                errorMessage: null,
                qcofficer:'',
                refId:0,
                surveyor:'',
                address:'',
                make:'',
                contactNo:'',
                status:'',
                conducted:'',
                assigned:'',
                anotheraddress:'',
                isSiteAccessible:'',
                filledPercentage:'',
                isSameLocation:'',
                tagNumber:'',
                existance:'',
                isVerified:'',
                reasonNoFunctional:'',
                isFunctional:'',
                submitStatus:'',
                shopName:'',
                shopKeeperName:'',
                isCoolerAccessible:'',
                modelNo:'',
                vehicleOwnership:'',
                users:[],
                surveyors:[],
                regions:[],
                region:'',
                cities:[],
                city:'',
                districts:[],
                district:'',
                engineNo:'',
                regNo:'',
                sharedPepsi:'',
                sharedOthers:'',
                vehicleTypeOther:'',
                freezerTypeOther:'',
                qcofficers:[],
                volumes:[
                    {text:'Up to 25%',value:1},
                    {text:'25% to 50%',value:2},
                    {text:'50% to 70%',value:3},
                    {text:'70% to 100%',value:4}
                ],
                volume:'',
                inventory:'',
                freezerType:'',
                vehicleType:'',
                freezerTypes:[
                    'Chest',
                    'Visicooler'
                    // 'Other'
                ],
                vehicleTypes:[
                    'Bike',
                    'Car',
                    'Van',
                    'Loader',
                    'Truck'
                    // 'Other'
                ],
                regions:[],
            region:'',
            cities:[],
            city:'',
            districts:[],
            district:''
    
    }
  },
  mounted(){
    this.getRegions();
    this.getLocation();
    this.getDatabaseLocation();
    this.getData();
  },
  methods: {
    getRegions(){

      this.region='';
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
      // this.city='';

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
                  id:obj.id
              })                    
          });
      }); 

      },
      getDistricts(event){
      this.districts=[];
      // this.district='';
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
    submitSiteSurvey(){


if(this.mylocation=='')
{
  alert('Location Not Updated Please Update Location');
}
else{

   const response = confirm("Are you sure you?");

    if (response) {
      const  headers= {
        'Authorization': 'Bearer ' + this.usertoken,
        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json'
        };
        const params={
          // gps:this.location.latitude+','+this.location.longitude
        };
        axios.post('/api/submitSiteSurvey/'+this.id,params,{
        headers
        }).then(res=>{

        alert('Site Survey Submitted Successfully');
        // window.location='/';
        }).catch(error=>{
        alert("Something Went Wrong");



                });
            } 

        }

        },
    getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(this.handleSuccess, this.handleError)
      } else {
        this.errorMessage = "Geolocation is not supported by this browser."
      }
    },
    handleSuccess(position) {
      this.location = {
        latitude: position.coords.latitude,
        longitude: position.coords.longitude
      }
    },
    handleError(error) {
      switch(error.code) {
        case error.PERMISSION_DENIED:
          this.errorMessage = "User denied the request for Geolocation."
          break
        case error.POSITION_UNAVAILABLE:
          this.errorMessage = "Location information is unavailable."
          break
        case error.TIMEOUT:
          this.errorMessage = "The request to get user location timed out."
          break
        case error.UNKNOWN_ERROR:
          this.errorMessage = "An unknown error occurred."
          break
      }
    },
    getDatabaseLocation(){
      const  headers= {
              'Authorization': 'Bearer ' + this.usertoken,
              // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Content-Type': 'application/json'
              };
              const params={
                // gps:this.location.latitude+','+this.location.longitude
              };
      axios.get('/getLocationFromDatabase/'+this.id,params,{
        headers
      }).then(res=>{

        this.mylocation=res.data;
        // alert('Survey Submitted Successfully');

      }).catch(error=>{
      // alert("Something Went Wrong");



                });
    },
    updateLocation(){
      const  headers= {
              'Authorization': 'Bearer ' + this.usertoken,
              // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Content-Type': 'application/json'
              };
              const params={
                gps:this.location.latitude+','+this.location.longitude
              };

              if(this.location==null)
              {
                alert('Cordinates not picked up');
              }
              else{
                axios.post('/api/updateGPS/'+this.id,params,{
        headers
      }).then(res=>{

      alert('Location Update Successfully');
    this.getDatabaseLocation();


      }).catch(error=>{
      alert("Something Went Wrong");



                });
              }

    },
    postData(){
            const  headers= {
                        'Authorization': 'Bearer ' + this.usertoken,
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                        };
                const params={
                    // type:this.surveyType.id,
                    // type_name:this.surveyType.text,
                    // type_slug:this.surveyType.slug,
                    // surveyor:this.surveyor.id,
                    address:this.address,
                    is_verified:this.isVerified,
                    another_address:this.anotheraddress,
                    // make:this.make,
                    contact_no:this.contactNo,
                    is_site_accessible:this.isSiteAccessible,
                    // qc_officer:this.qcofficer.id,
                    region:this.region.id,
                    city:this.city.id,
                    district:this.district.id,
                    same_location:this.isSameLocation,
                    // tag_number:this.tagNumber,
                    // existance:this.existance,
                    // vehicle_type:this.vehicleType,
                    // reason_for_no_operational:this.reasonNoFunctional,
                    // vehicle_type_other:this.vehicleTypeOther,
                    // functional:this.isFunctional,
                    // shared_products_name:this.sharedProductedDetails,
                    // is_cooler_accessible:this.isCoolerAccessible,
                    // general_condition:this.generalCondition,
                    // volume:this.volume.text,
                    // utilization:this.inventory,
                    // shared_pepsi:this.sharedPepsi,
                    shop_name:this.shopName,
                    shopkeeper_name:this.shopKeeperName,
                    // shared_others:this.sharedOthers,
                    // reg_no:this.regNo,
                    // engine_no:this.engineNo,
                    // model_number:this.modelNo,
                    // freezer_type:this.freezerType,
                    // freezer_type_other:this.freezerTypeOther,
                    // is_vehicle_distributed:this.vehicleOwnership
                };
                axios.post('/api/updateGeneralInfo/'+this.id,params,{
                    headers
                
                }).then(res=>{
                    // console.log(params);
                    alert('Asset Updated' );
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
            axios.get('/api/getGeneralInfo/'+this.id,{
            headers:headers
        }).then(res=>{
                res.data.data.forEach(obj => {
                    // this.tagNumber=obj.tag_number;  
                    // this.refId='KGT/'+obj.city_prefix+'/VER/AFF/'+this.id+'/'+year;  
                    // this.surveyType={text:obj.asset_type,id:obj.asset_id};                    
                    // this.surveyor={text:obj.surveyor_name,id:obj.surveyor_id};
                    // this.qcofficer={text:obj.qc_officer_name,id:obj.qc_officer_id};
                    this.region={text:obj.region_name,id:obj.region_id};
                    this.city={text:obj.city_name,id:obj.city_id};
                    this.district={text:obj.district_name,id:obj.district_id};
                    this.address=obj.address;
                    this.isVerified=obj.is_verified;
                    this.anotheraddress=obj.another_address;
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
                    this.contactNo=obj.contact_no;
                    // this.assigned=obj.assigned_on;
                    // this.conducted=obj.assigned_on;

                    // save button hide 
                    this.status=obj.status;
                    // end 


                    // this.gps=obj.gps;
                    this.isSiteAccessible=obj.is_site_accessible;
                    this.isSameLocation=obj.same_location;
                    // this.volume={text:obj.volume};
                    // this.inventory=obj.utilization;
                    // this.sharedPepsi=obj.utilization_pepsi;
                    // this.sharedOthers=obj.utilization_shared;
                    // this.sharedProductedDetails=obj.shared_products_name;
                    // this.existance=obj.existance;
                    // this.isFunctional=obj.functional;
                    // this.reasonNoFunctional=obj.reason_for_no_operational;
                    // this.isCoolerAccessible=obj.is_cooler_accessible;
                    // this.generalCondition=obj.general_condition;
                    this.shopName=obj.shop_name;
                    this.shopKeeperName=obj.shopkeeper_name;
                    // this.regNo=obj.reg_no;
                    // this.engineNo=obj.engine_no;
                    // this.modelNo=obj.model_number;
                    // this.vehicleOwnership=obj.is_vehicle_destributed;
                    
                    // this.getCities({id:obj.region_id});
                    // this.getDistricts({id:obj.city_id});
                });

            }); 
 
    }
  }
}
</script>