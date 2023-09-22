<template>
    <div class="container-fluid " style="padding-top:50px ;padding-bottom:50px">
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
            <a :href="'/survey-generalinfo/'+this.id">
            <button class="btn btn-primary" >Back</button>
            </a>                  
        </div>
        <div style="width: 40%;float: left;text-align: end;">
            <a :href="'/survey-images/'+this.id">
            <button class="btn btn-danger" >Next</button>
            </a>  

        </div>
        </div>
        <div class="row">
                        <div class="col-sm-4">
                            <label  class=" col-form-label" style="font-weight:bold">Type</label>
                            <v-select :options="types" label="text" v-model="surveyType"  disabled class=""></v-select>
                            <!-- <div v-if="v$.surveyType.$error" class="text-danger">Name field has an error.</div> -->
                        </div>

                    </div>    
                    <div class="row pt-3">
                                <h5>
                                    <b>{{this.surveyType==''?'Asset ':this.surveyType.text}} Details</b>
                                </h5>
                                
                                
                                
                                
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                    
                                        <div class="col-sm-3">
                                            <label  class=" col-form-label" style="font-weight:bold">Enter Your Name</label>
                                            <input type="text" name="" class="form-control bg-white" id="" v-model="surveyor_names">                                    
                                        </div>
                                        <div class="col-sm-3">
                                            <label  class=" col-form-label" style="font-weight:bold">Tag Number #</label>
                                            <input type="text" name="" class="form-control bg-white" id="" v-model="tagNumber">                                    
                                        </div>
                                        <div v-show="this.existance=='Yes'"  class="col-sm-3">
                                            <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Tag Number Visibility</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"  v-model="tagNumberVisible"  value="Yes">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                        </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"  id="inlineRadio2" v-model="tagNumberVisible" value="No">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                
                                        </div>
                                        
                                        <div class="col-sm-2">
                                                    <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Existance</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"  v-model="existance"  value="Yes">
                                                        <label class="form-check-label" >Yes</label>
                                                        </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"   v-model="existance" value="No">
                                                        <label class="form-check-label" >No</label>
                                                    </div>

                                        </div>
                                    
                                        <div class="col-sm-2" v-if="this.surveyType.id==2">
                                                    <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Vehicle's Ownership</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"   v-model="vehicleOwnership" value="Owned">
                                                        <label class="form-check-label" >Owned</label>
                                                        </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"   value="Leased" v-model="vehicleOwnership">
                                                        <label class="form-check-label" >Leased</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"   value="Distributor" v-model="vehicleOwnership">
                                                        <label class="form-check-label" >Distributor</label>
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
                                                <input class="form-check-input" type="radio"   value="Yes" v-model="isCoolerAccessible">
                                                <label class="form-check-label" >Yes</label>
                                                </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"   value="No" v-model="isCoolerAccessible">
                                                <label class="form-check-label" >No</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" v-show="this.isCoolerAccessible == 'Yes'"  v-if="this.surveyType.id==1">
                                                    <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">General Condition</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"   value="Damage" v-model="generalCondition">
                                                        <label class="form-check-label" >Damage</label>
                                                        </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"   value="Good" v-model="generalCondition">
                                                        <label class="form-check-label" >Good</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"   value="Average" v-model="generalCondition">
                                                        <label class="form-check-label" >Average</label>
                                                    </div>

                                        </div>
                                        <div v-show="this.isCoolerAccessible == 'Yes'" class="col-sm-12">
                                                <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Functional / Operational</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"   v-model="isFunctional" value="Yes">
                                                    <label class="form-check-label" >Yes</label>
                                                    </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"   value="No" v-model="isFunctional">
                                                    <label class="form-check-label" >No</label>
                                                </div>
                                                <input v-show="this.isFunctional=='No'" type="text" class="form-control bg-white mt-1" v-model="reasonNoFunctional" name="" id="">
                                        </div>


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
                                                    <label  class=" col-form-label" style="font-weight:bold">Engine No / Chassis No </label>
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
                                <section v-show="this.isCoolerAccessible == 'Yes'" v-else-if="this.surveyType.id==1">
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
                                    <div v-show="this.isCoolerAccessible == 'Yes'" class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Filled Percentage %</label>
                                                <v-select :options="volumes" v-model="volume" label="text"></v-select>

                                            </div>
                                            <div class="col-sm-3">
                                                    <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Inventory Utiliztion</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" v-model="inventory"   value="Pepsi">
                                                        <label class="form-check-label" >Pepsi</label>

                                                        </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" v-model="inventory"   value="Shared">
                                                        <label class="form-check-label" >Shared</label>

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
 
                    </div >
        <div class="row mt-3 mb-3">
            <div class="col-sm-12">
                  <button  class="btn btn-primary" @click="postData()">Save</button>
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

  },
  data() {
    return {
            types:[
                
                ],
                surveyor_names:'',
                surveyType:'',
                qcofficer:'',
                refId:0,
                surveyor:'',
                address:'',
                make:'',
                contactNo:'',
                status:'',
                conducted:'',
                assigned:'',
                chassisNo:'',
                isSiteAccessible:'',
                filledPercentage:'',
                isSameLocation:'',
                tagNumber:'',
                existance:'',
                reasonNoFunctional:'',
                isFunctional:'',
                submitStatus:'',
                shopName:'',
                shopKeeperName:'',
                isCoolerAccessible:'No',
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
                generalCondition:'',
                tagNumberVisible:'',
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
                ],
                vehicleTypes:[
                    'Bike',
                    'Car',
                    'Van',
                    'Loader',
                    'Truck',
                ],
    
    }
  },
  mounted(){
    this.getTypes();

    this.getData();
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
  methods: {
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
    postData(){
        if(this.surveyor_names=="")
        {

alert('Please Enter your Name')

        }
            else{
                const  headers= {
                        'Authorization': 'Bearer ' + this.usertoken,
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                        };
                const params={
                    surveyor_names:this.surveyor_names,
                    type:this.surveyType.id,
                    type_name:this.surveyType.text,
                    type_slug:this.surveyType.slug,
                    make:this.make,
                    tag_number:this.tagNumber,
                    tag_number_visible:this.tagNumberVisible,
                    existance:this.existance,
                    vehicle_type:this.vehicleType,
                    reason_for_no_operational:this.reasonNoFunctional,
                    vehicle_type_other:this.vehicleTypeOther,
                    functional:this.isFunctional,
                    shared_products_name:this.sharedProductedDetails,
                    is_cooler_accessible:this.isCoolerAccessible,
                    general_condition:this.generalCondition,
                    volume:this.volume.text,
                    utilization:this.inventory,
                    shared_pepsi:this.sharedPepsi,
                    shared_others:this.sharedOthers,
                    reg_no:this.regNo,
                    engine_no:this.engineNo,
                    chassis_no:this.chassisNo,
                    model_number:this.modelNo,
                    freezer_type:this.freezerType,
                    freezer_type_other:this.freezerTypeOther,
                    is_vehicle_destributed:this.vehicleOwnership
                };
                axios.post('/api/updateVehicleSurveyInfo/'+this.id,params,{
                    headers
                
                }).then(res=>{
                    // console.log(params);
                    alert('Asset Updated' );
                    this.getData();
                    // this.v$.$reset();
                    // window.open('edit/'+res.data, '_blank');

                });
            }
        },
    getData(){
      const d = new Date();
              let year = d.getFullYear();
       
            const  headers= {
                    'Authorization':
                     'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            axios.get('/api/getVehicleSurveyInfo/'+this.id,{
            headers:headers
        }).then(res=>{
                res.data.data.forEach(obj => {
                    this.tagNumber=obj.tag_number;  
                    // this.refId='KGT/'+obj.city_prefix+'/VER/AFF/'+this.id+'/'+year;  
                    this.surveyType={text:obj.asset_type,id:obj.asset_id};                    
                    this.surveyor={text:obj.surveyor_name,id:obj.surveyor_id};
                    this.qcofficer={text:obj.qc_officer_name,id:obj.qc_officer_id};
                    this.region={text:obj.region_name,id:obj.region_id};
                    this.city={text:obj.city_name,id:obj.city_id};
                    this.district={text:obj.district_name,id:obj.district_id};
                    if(obj.asset_id==1)
                    {
                        this.freezerType=obj.type;
                        this.freezerTypeOther=obj.type_other;
                    }
                    else{
                        this.vehicleType=obj.type;
                        this.vehicleTypeOther=obj.type_other;
                    }
                    this.make=obj.make;
                    this.assigned=obj.assigned_on;
                    this.tagNumberVisible=obj.tag_number_visible;
                    this.conducted=obj.assigned_on;
                    this.chassisNo=obj.chassis_no;
                    this.status=obj.status;
                    this.gps=obj.gps;
                    this.volume={text:obj.volume};
                    this.inventory=obj.utilization;
                    this.sharedPepsi=obj.utilization_pepsi;
                    this.sharedOthers=obj.utilization_shared;
                    this.sharedProductedDetails=obj.shared_products_name;
                    this.existance=obj.existance;
                    this.isFunctional=obj.functional;
                    this.reasonNoFunctional=obj.reason_for_no_operational;
                    this.isCoolerAccessible=obj.is_cooler_accessible;
                    this.generalCondition=obj.general_condition;
                    this.regNo=obj.reg_no;
                    this.engineNo=obj.engine_no;
                    this.modelNo=obj.model_number;
                    this.vehicleOwnership=obj.is_vehicle_destributed;
                    
                    // this.getCities({id:obj.region_id});
                    // this.getDistricts({id:obj.city_id});
                });

            }); 
 
    }
  }
}
</script>