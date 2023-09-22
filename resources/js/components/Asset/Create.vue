<template>
    <div class="row mt-5 mb-4">
        <div class="col-md-12">
            <a class="btn btn-primary mb-3">Back</a>
            <h4>
                <b>Create Asset</b>
            </h4>
            <h6>
                Ref Id# <b>{{'KGT/'+city.prefix+'/VER/AFF/'+refId+'/'+year}}</b>
            </h6>
            <hr>
        </div>
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-sm-4">
                    <label  class=" col-form-label" style="font-weight:bold">Type</label>
                    <v-select :options="types" label="text" v-model="surveyType"  class=""></v-select>
                    <div v-if="v$.surveyType.$error" class="text-danger">Name field has an error.</div>

               </div>
               <div class="col-sm-4">
                    <label  class=" col-form-label" style="font-weight:bold">Surveyor</label>
                    <v-select :options="surveyors" label="text" class=""  v-model="surveyor"></v-select>
                        
               </div>
               <div class="col-sm-4">
                    <label  class=" col-form-label" style="font-weight:bold">QC Officer</label>
                    <v-select :options="qcofficers" label="text" class="" v-model="qcofficer"></v-select>
                        
               </div>
            </div>
           
        </div>
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
        <div class="col-md-12 pt-3">
            <h5>
                <b>Site Details</b>
            </h5> 
        </div>
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-sm-12">
                    <label  class=" col-form-label" style="font-weight:bold">Site</label>
                    <v-select :options="sites" label="text" v-model="site" @update:modelValue="getSiteDetails($event)"  class="bg-white"></v-select>
                    <!-- <div v-if="v$.surveyType.$error" class="text-danger">Name field has an error.</div> -->

               </div>
                <div class="col-sm-8">
                    <label  class=" col-form-label" style="font-weight:bold">Address</label>
                    <textarea name="" class="form-control bg-white" id="" cols="10" rows="10" style="height:20px" v-model="address"></textarea>
                    <div v-if="v$.address.$error" class="text-danger">Name field has an error.</div>
               </div>
               <div class="col-sm-4">
                    <label  class=" col-form-label"  style="font-weight:bold">Contact No</label>
                    <input type="text" v-model="contactNo" class="form-control bg-white">
                    <div v-if="v$.contactNo.$error" class="text-danger">Name field has an error.</div>

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
        <div class="col-sm-12" v-show="this.isSameLocation=='No'">
            <label  class="col-form-label">Different Address</label>
                <textarea class="form-control bg-white" v-model="anotherAddress"  style="height:20px"></textarea>
                    <!-- <div v-if="v$.address.$error" class="text-danger">Name field has an error.</div> -->
        </div>
        <div class="row">
            <div class="col-sm-12" v-show="this.surveyType.id==1">
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
            <div class="row pt-3">
                <h5>
                    <b>{{this.surveyType==''?'Asset ':this.surveyType.text}} Details</b>
                </h5>
                
                <div class="col-sm-12">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label  class=" col-form-label" style="font-weight:bold">Tag Number #</label>
                            <input type="text" name="" class="form-control bg-white" id="" v-model="tagNumber">                                    
                        </div>
                        
                        <div class="col-sm-2">
                                    <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Existance</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"  v-model="existance"  value="Yes">
                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"  id="inlineRadio2" v-model="existance" value="No">
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>

                        </div>
                    
                        <div class="col-sm-3" v-if="this.surveyType.id==2">
                                    <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Vehicle's Ownership</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"  id="inlineRadio1" v-model="vehicleOwnership" value="Owned">
                                        <label class="form-check-label" for="inlineRadio1">Owned</label>
                                        </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"  id="inlineRadio2" value="Distributor" v-model="vehicleOwnership">
                                        <label class="form-check-label" for="inlineRadio2">Distributor</label>
                                    </div>

                        </div>
                        <div class="col-sm-3" v-if="this.surveyType.id==2">
                                    <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Vehicle's Type</label>
                                    <v-select :options="vehicleTypes" v-model="vehicleType" label="text"></v-select>
                                    <input class="form-control bg-white mt-3" v-show="this.vehicleType=='Other'" v-model="vehicleTypeOther">

                        </div>
                        
                        <div class="col-sm-2" v-if="this.surveyType.id==1">
                            <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Cooler Accessible</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"  id="inlineRadio1" value="Yes" v-model="isCoolerAccessible">
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"  id="inlineRadio2" value="No" v-model="isCoolerAccessible">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>
                        <div class="col-sm-5" >
                                    <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">General Condition</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"  id="inlineRadio1" value="Damage" v-model="generalCondition">
                                        <label class="form-check-label" for="inlineRadio1">Damage</label>
                                        </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"  id="inlineRadio2" value="Good" v-model="generalCondition">
                                        <label class="form-check-label" for="inlineRadio2">Good</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"  id="inlineRadio2" value="Excellent" v-model="generalCondition">
                                        <label class="form-check-label" for="inlineRadio2">Excellent</label>
                                    </div>

                        </div>


                    </div>     
                    <div class="col-sm-12">
                            <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Functional / Operational</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"  id="inlineRadio1" v-model="isFunctional" value="Yes">
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"  id="inlineRadio2" value="No" v-model="isFunctional">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                            <input v-show="this.isFunctional=='No'" type="text" class="form-control bg-white mt-1" v-model="reasonNoFunctional" name="" id="">
                    </div>

                </div>  
                <section v-if="this.surveyType.id==2">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-sm-3">
                                    <label  class=" col-form-label" style="font-weight:bold">Make / Model </label>
                                    <input type="text" name="" class="form-control bg-white" id="" v-model="make">                                    
                            </div>
                            <div class="col-sm-3">
                                    <label  class=" col-form-label" style="font-weight:bold">Engine No  </label>
                                    <input type="text" name="" class="form-control bg-white" id="" v-model="engineNo">                                    
                            </div>
                            <div class="col-sm-3">
                                    <label  class=" col-form-label" style="font-weight:bold">Chassis No </label>
                                    <input type="text" name="" class="form-control bg-white" id="" v-model="chassisNo">                                    
                            </div>
                            <div class="col-sm-3">
                                    <label  class=" col-form-label" style="font-weight:bold">Registration No</label>
                                    <input type="text" name="" class="form-control bg-white" id="" v-model="regNo">                                    

                                        
                            </div>

                        </div>
                            
                    </div>
                </section>
                <section v-else-if="this.surveyType.id==1">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                    <label  class=" col-form-label" style="font-weight:bold">Type </label>
                                    <v-select :options="freezerTypes" v-model="freezerType"></v-select>
                                    
                                    <div v-show="this.freezerType=='Other'" class="pt-3">
                                        <input type="text" name="" v-model="freezerTypeOther" class="form-control bg-white" id="">    
                                    </div>
                            </div>
                            <div class="col-sm-6">
                                    <label  class=" col-form-label" style="font-weight:bold">Model No #</label>
                                    <input type="text" name="" class="form-control bg-white" id="" v-model="modelNo">                                    

                                        
                            </div>

                        </div>     
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Filled Percentage %</label>
                                <v-select :options="volumes" v-model="volume" label="text"></v-select>

                            </div>
                            <div class="col-sm-3">
                                    <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Inventory Utiliztion</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" v-model="inventory"  id="inlineRadio1" value="Pepsi">
                                        <label class="form-check-label" for="inlineRadio1">Pepsi</label>
                                        </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" v-model="inventory"  id="inlineRadio2" value="Shared">
                                        <label class="form-check-label" for="inlineRadio2">Shared</label>
                                    </div>

                            </div>
                            <div class="col-sm-3" v-show="this.inventory=='Shared'">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Pepsi {{sharedPepsi}} %</label>
                                        <input type="range" v-model="sharedPepsi" class="form-range" min="0" max="100" id="customRange2">
                                        <span style="display: none;"> {{ sharedPepsivalue }} </span>

                                    </div>  
                                    <div class="col-sm-6">
                                        <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Shared {{sharedOthers}} %</label>
                                        <input type="range" v-model="sharedOthers" class="form-range" min="0" max="100" id="customRange2">
                                        <span style="display: none;">{{sharedOthersvalue}}</span>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2" v-show="this.inventory=='Shared'">
                                <label  class="col-form-label row"  style="font-weight:bold;padding-left: 12px;">Share Product Details</label>
                                <textarea name="" class="form-control bg-white" v-model="sharedProductedDetails" id="" style="height: 80px;" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                    </div>
                </section>
                <div class="col-sm-12 mt-3">
                    <button class="btn btn-primary" @click="storeAsset()">Save</button>
                </div>
            </div >
        
    </div>
</template>
<style scoped></style>
<script>
import vSelect from "vue-select";
import axios from 'axios';
import "vue-select/dist/vue-select.css";
import useVuelidate from "@vuelidate/core";
import { email, required, minLength } from "@vuelidate/validators";

export default{
    props:{
        usertoken:String
    },
    setup: () => ({ v$: useVuelidate() }),
    data(){
        return{
      
            types:[
                
            ],
            sites:[
                
            ],
            site:'',
            surveyType:'',
            qcofficer:'',
            refId:0,
            surveyor:'',
            address:'',
            contactNo:'',
            chassisNo:'',
            isSiteAccessible:'',
            generalCondition:'',
            filledPercentage:'',
            isSameLocation:'',
            tagNumber:'',
            existance:'',
            isFunctional:'',
            submitStatus:'',
            shopName:'',
            shopKeeperName:'',
            reasonNoFunctional:'',
            isCoolerAccessible:'',
            modelNo:'',
            anotherAddress:'',
            sharedProductedDetails:'',
            vehicleOwnership:'',
            users:[],
            surveyors:[],
            regions:[],
            region:'',
            cities:[],
            city:'',
            year:'',
            make:'',
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
                'Visicooler',
                'Water Dispenser'
            ],
            vehicleTypes:[
                'Bike',
                'Car',
                'Van',
                'Loader',
                'Truck'
            ],
        }
    },
    mounted(){
        console.log('component mounted');
        this.getTypes();
        this.getSurveyors();
        this.getQCOfficer();
        this.getRegions();
        this.getRefId();

        const d = new Date();
        let year = d.getFullYear();
        this.year=year;
        
    },
    computed:{
        sharedPepsivalue()
        {
            var calc=100-this.sharedPepsi;
            this.sharedOthers=calc;
            // return calc;
        },
        sharedOthersvalue()
        {
            var calc=100-this.sharedOthers;
            this.sharedPepsi=calc;
            // return calc;
        }  
    },
    created: function() {
  const timer = setInterval(() => {
                    this.getRefId();

  }, 30000);

  
},
    methods:{
        getRefId(){
            this.refId='';
            const  headers= {
                    'Authorization': 'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            axios.get('/api/getRefId',{
            headers:headers
        }).then(res=>{
                this.refId=res.data
            }); 

        return 123;
        },
        getTypes(){
            const  headers= {
                    'Authorization': 'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            axios.get('/api/getTypes',{
            headers:headers
        }).then(res=>{
                res.data.forEach(obj => {
                    this.types.push({
                        text:obj.name,
                        id:obj.id,
                        slug:obj.slug
                    })                    
                });
            }); 
        },
        getSurveyors(){
            this.surveyor='';
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
                res.data.forEach(obj => {
                    this.surveyors.push({
                        text:obj.name +' ('+obj.city_name+'-'+obj.sub_city_name+')',
                        id:obj.id
                    })                    
                });
            }); 
        },
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
        getSiteDetails(event){
            
            const  headers= {
                    'Authorization': 'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            const params={
                site:event.id
            };
            axios.get('/api/getSiteDetails',{
                headers,
                params
            
            }).then(res=>{
                res.data.forEach(obj => {
                    this.address=obj.address;
                    this.contactNo=obj.contact_no;
                    this.isSiteAccessible=obj.is_site_accessible;
                    this.isSameLocation=obj.same_location;
                    this.anotherAddress=obj.other_address;
                    this.shopKeeperName=obj.shopkeeper_name;
                    this.shopName=obj.shop_name;
                    this.region={text:obj.region_name,id:obj.region_id};
                    this.city={text:obj.city_name,id:obj.city_id};
                    this.district={text:obj.district_name,id:obj.district_id};
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


            this.sites=[];
            this.site='';
            
            axios.get('/api/getSites',{
                headers,
                params
            
            }).then(res=>{
                res.data.forEach(obj => {
                    this.sites.push({
                        text:obj.address,
                        id:obj.id
                    })                    
                });
            });
             

        },
        getQCOfficer(){
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
                res.data.forEach(obj => {
                    this.qcofficers.push({
                        text:obj.name +' ('+obj.city_name+'-'+obj.sub_city_name+')',
                        id:obj.id
                    })                    
                });
            }); 
        },
        postData(){
            const  headers= {
                        'Authorization': 'Bearer ' + this.usertoken,
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                        };
                const params={
                    type:this.surveyType.id,
                    type_name:this.surveyType.text,
                    type_slug:this.surveyType.slug,
                    surveyor:this.surveyor.id,
                    address:this.address,
                    other_address:this.anotherAddress,
                    make:this.make,
                    contact_no:this.contactNo,
                    is_site_accessible:this.isSiteAccessible,
                    qc_officer:this.qcofficer.id,
                    region:this.region.id,
                    city:this.city.id,
                    district:this.district.id,
                    same_location:this.isSameLocation,
                    tag_number:this.tagNumber,
                    existance:this.existance,
                    vehicle_type:this.vehicleType,
                    reason_for_no_operational:this.reasonNoFunctional,
                    vehicle_type_other:this.vehicleTypeOther,
                    functional:this.isFunctional,
                    site:this.site.id,
                    shared_products_name:this.sharedProductedDetails,
                    is_cooler_accessible:this.isCoolerAccessible,
                    general_condition:this.generalCondition,
                    volume:this.volume.text,
                    utilization:this.inventory,
                    shared_pepsi:this.sharedPepsi,
                    shop_name:this.shopName,
                    shopkeeper_name:this.shopKeeperName,
                    shared_others:this.sharedOthers,
                    reg_no:this.regNo,
                    engine_no:this.engineNo,
                    chassis_no:this.chassisNo,
                    model_number:this.modelNo,
                    freezer_type:this.freezerType,
                    freezer_type_other:this.freezerTypeOther,
                    is_vehicle_distributed:this.vehicleOwnership
                };
                axios.post('/api/storeAsset',params,{
                    headers
                
                }).then(res=>{
                    // console.log(params);
                    alert('Asset Registerd No# '+res.data );
                    this.getRefId();
                    this.v$.$reset();
                    window.open('edit/'+res.data, '_blank');

                });
        },
        storeAsset(){
            this.v$.address.$touch();
            this.v$.contactNo.$touch();
      if (!this.v$.$validationGroups.firstGroup.$invalid) {
          
          this.postData();
          this.v$.address.$reset();
            this.v$.contactNo.$reset();
      }

    // console.log(this.v$.$validationGroups.firstGroup.$invalid);
  
        },
    },
   validations () {
    return {
        address: {
          required,
        },
        contactNo: {
          required,
        },
        surveyType:{
            required
        },
        $validationGroups: {
        firstGroup: ['address', 'contactNo']
        }

       
    }
},
    components:{
        "v-select": vSelect
    }
}
</script>