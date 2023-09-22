<template>
    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <div class="row">
                    <div class="col-sm-8">
                        <a class="btn btn-primary mb-3" href="/">Back</a>
                        
                    </div>
                    <div class="col-sm-4 text-end">
                       <i class="fa fa-refresh" @click="getData()" style="font-size: 22px;position: relative;top:5px"></i>

                    </div>
                </div>
            <h4>
                <b>Edit Asset</b>
            </h4>
            <h6>
                Ref Id# <b>{{refId}}</b>
            </h6>
            <hr>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12 mt-2 mb-2 text-end">
                    <!-- <button class="btn btn-success m-1" v-show="this.status==1" @click="completedJob()">Finalize</button> -->
                    <button class="btn btn-success m-1" @click="completedJob()">Finalize</button>
                    <!-- <button class="btn btn-danger m-1" @click="cancelJob()">Cancel</button> -->
                   <a :href="'/print-report/'+this.id" target="_blank">
                    <button class="btn btn-primary m-1">Print Report</button>
                   </a> 
                </div>
                
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Asset's Details</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Site's Detail</button>
                    <button class="nav-link" id="nav-site-tab" data-bs-toggle="tab" data-bs-target="#nav-site" type="button" role="tab" aria-controls="nav-site" aria-selected="false">Survey's Details</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Images</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    <div class="row mt-3">
                        <div class="col-sm-9">
                            <label for="inputEmail3" class="col-form-label"><b>
                                    Assigned On : <span class="text-danger">{{assigned}}</span>
                                </b>
                                </label>

                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <label for="inputEmail3" class=" col-form-label"><b>
                                    Conducted On : <span class="text-success">{{conducted}}</span>
                                </b>
                                </label>

                                
                            </div>
                        </div>
                        <div class="col-sm-3 text-end">
                            <b>
                                Survey Status &nbsp; 
                                <span class="badge text-bg-danger" v-if="this.status==0">Active</span>
                                <span class="badge text-bg-info" v-if="this.status==1">Attended</span>
                                <span class="badge text-bg-success" v-if="this.status==2">Completed</span>
                                <span class="badge text-bg-danger" v-if="this.status==3">Cancelled</span>
                            </b>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label  class=" col-form-label" style="font-weight:bold">Type</label>
                            <v-select :options="types" label="text" v-model="surveyType"  class=""></v-select>
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
                                            <label   class=" col-form-label" style="font-weight:bold">Tag Number # (<span :class="[tagNumberProvided==null?'redcolor':'greencolor']"> {{ tagNumberProvided==null?'Not Provided':tagNumberProvided }})</span></label>
                                            <input type="text" name=""  class="form-control bg-white" id="" v-model="tagNumber"> 
                                         

                                        </div>
                                        <div class="col-sm-2">
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
                                                        <input class="form-check-input" type="radio"  id="inlineRadio2" value="Leased" v-model="vehicleOwnership">
                                                        <label class="form-check-label" for="inlineRadio2">Leased</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"  id="inlineRadio2" value="Distributor" v-model="vehicleOwnership">
                                                        <label class="form-check-label" for="inlineRadio2">Distributor</label>
                                                    </div>

                                        </div>
                                        <div class="col-sm-3" v-if="this.surveyType.id==2">
                                                    <label  class="col-form-label" style="font-weight:bold;">Vehicle's Type (<span :class="[typeProvided==null?'redcolor':'greencolor']"> {{ typeProvided==null?'Not Provided':typeProvided }}) </span></label>
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
                                        <div class="col-sm-6">
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
                                                        <input class="form-check-input" type="radio"  id="inlineRadio2" value="Average" v-model="generalCondition">
                                                        <label class="form-check-label" for="inlineRadio2">Average</label>
                                                    </div>

                                        </div>
                                        <div class="col-sm-6">
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
                                </div>  
                                <section v-if="this.surveyType.id==2">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                    <label  class=" col-form-label" style="font-weight:bold">Make / Model (<span :class="[makeProvided==null?'redcolor':'greencolor']"> {{ makeProvided==null?'Not Provided':makeProvided }}) </span></label>
                                                    <input type="text" name="" class="form-control bg-white" id="" v-model="make">                                    
                                            </div>
                                            <div class="col-sm-3">
                                                    <label  class=" col-form-label" style="font-weight:bold">Engine No (<span :class="[engineProvided==null?'redcolor':'greencolor']"> {{ engineProvided==null?'Not Provided':engineProvided }}) </span></label>
                                                    <input type="text" name="" class="form-control bg-white" id="" v-model="engineNo">                                    
                                            </div>
                                            <div class="col-sm-3">
                                                    <label  class=" col-form-label" style="font-weight:bold">Chassis No (<span :class="[chassisProvided==null?'redcolor':'greencolor']"> {{ chassisProvided==null?'Not Provided':chassisProvided }})</span></label>
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
                                                    <label  class="col-form-label" style="font-weight:bold">Type (<span :class="[typeProvided==null?'redcolor':'greencolor']"> {{ typeProvided==null?'Not Provided':typeProvided }}) </span></label>
                                                    <v-select :options="freezerTypes" v-model="freezerType"></v-select>
                                                    
                                                    <div v-show="this.freezerType=='Other'" class="pt-3">
                                                        <input type="text" name="" v-model="freezerTypeOther" class="form-control bg-white" id="">    
                                                    </div>
                                            </div>
                                            <div class="col-sm-6">
                                                    <label  class=" col-form-label" style="font-weight:bold">Model No # <span :class="[modelNoProvided==null?'redcolor':'greencolor']"> {{ modelNoProvided==null?'Not Provided':modelNoProvided }} </span></label>
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
 
                    </div >
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                    <div class="row mt-3">
                        <div class="col-sm-9">
                            <label for="inputEmail3" class="col-form-label"><b>
                                    Assigned On : <span class="text-danger">{{siteassigned}}</span>
                                </b>
                                </label>

                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <label for="inputEmail3" class=" col-form-label"><b>
                                    Conducted On : <span class="text-success">{{siteconducted}}</span>
                                </b>
                                </label>

                                
                            </div>
                        </div>
                        <div class="col-sm-3 text-end">
                            <b>
                                Survey Status &nbsp; 
                                <span class="badge text-bg-danger" v-if="this.sitestatus==0">Active</span>
                                <span class="badge text-bg-info" v-if="this.sitestatus==1">Attended</span>
                                <span class="badge text-bg-success" v-if="this.sitestatus==2">Completed</span>
                                <span class="badge text-bg-danger" v-if="this.sitestatus==3">Cancelled</span>
                            </b>
                        </div>
                        <div class="row">
                                <label for="inputEmail3" class=" col-form-label"><b>
                                    GPS Cordinates : <span class="">{{gps}}</span>
                                </b>
                                </label>

                                
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
                            <label  class=" col-form-label" style="font-weight:bold">Another Address</label>
                            <textarea name="" class="form-control bg-white" id="" cols="10" rows="10" style="height:20px" v-model="otheraddress"></textarea>
                        </div>
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
                    <div class="col-sm-3">
                            <label  class="col-form-label row" style="font-weight:bold;padding-left: 12px;">Location Verified</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"  v-model="isVerified" id="inlineRadio1" value="Yes">
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"  id="inlineRadio2" v-model="isVerified" value="No">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="nav-site" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                    
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <!-- <label  class=" col-form-label" style="font-weight:bold">Surveyor</label>
                            <v-select :options="surveyors" label="text" class=""  v-model="surveyor"></v-select> -->
                           
                            <label  class=" col-form-label" style="font-weight:bold">Surveyor</label>
                            <!-- <v-select :options="surveyors" label="text" class=""  v-model="surveyor"></v-select> -->
                            <input class="form-control" type="text"  id="" v-model="surveyorName" >
                            
                            
                        </div>
                        <div class="col-sm-6">
                                <label  class=" col-form-label" style="font-weight:bold">QC Officer</label>
                                <v-select :options="qcofficers" label="text" class="" v-model="qcofficer"></v-select>           
                        </div>
                    </div>
                  

                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                  
                    <images :id="this.id" :usertoken="this.usertoken"></images>
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-sm-12 mt-3">
                <button class="btn btn-primary" v-show="this.status==1" @click="postData()">Save</button>
            </div>
        </div>
       
        
    </div>
</template>
<style scoped>

.redcolor{
    color:red
}

.greencolor{
    color:green
}
</style>
<script>
import vSelect from "vue-select";
import Images from './Images.vue'
import axios from 'axios';
import "vue-select/dist/vue-select.css";
import useVuelidate from "@vuelidate/core";
import { email, required, minLength } from "@vuelidate/validators";

export default{
    props:{
        usertoken:String,
        id:Number
    },
    setup: () => ({ v$: useVuelidate() }),
    data(){
        return{
            types:[
                
            ],
            surveyType:'',
            qcofficer:'',
            refId:0,
            siteid:'',
            surveyor:'',
            // work 
            surveyorName:'',
            // end 
            address:'',
            otheraddress:'',
            make:'',
            contactNo:'',
            status:'',
            conducted:'',
            siteconducted:'',
            siteassigned:'',
            assigned:'',
            chassisNo:'',
            sitestatus:0,
            generalCondition:'',
            isSiteAccessible:'',
            filledPercentage:'',
            tagNumberProvided:'',
            typeProvided:'',
            makeProvided:'',
            engineProvided:'',
            chassisProvided:'',
            modelNoProvided:'',
            isSameLocation:'',
            tagNumber:'',
            tagNumberMatch:'',
            tagNumberVisible:'',
            existance:'',
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
            isVerified:'',
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
    mounted(){
        console.log('component mounted');
        this.getTypes();
        this.getSurveyors();
        this.getSurveyorsName();
        this.getQCOfficer();    
        this.getRegions();
        this.getData();
    },
    methods:{
        // get surveyor_name 
        getSurveyorsName(){

            const  headers= {
                    'Authorization': 'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            const params={
                // type:4
            };
            axios.get('/api/getSurveyorsName/'+this.id,{
                headers,
                params
            
            }).then(response=>{
                this.surveyorName =response.data;
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
                    surveyor_name:this.surveyorName,
                    site_id:this.siteid,
                    is_verified:this.isVerified,
                    other_address:this.otheraddress,
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
                    tag_number_visible:this.tagNumberVisible,
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
                    is_vehicle_destributed:this.vehicleOwnership
                };
                axios.post('/api/updateAsset/'+this.id,params,{
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
            axios.get('/api/getDataForUpdate/'+this.id,{
            headers:headers
        }).then(res=>{
                res.data.forEach(obj => {
                    this.tagNumber=obj.tag_number;  
                    this.isVerified=obj.is_verified;  
                    this.tagNumberProvided=obj.tag_number_by_client;  
                    this.typeProvided=obj.type_by_client;  
                    this.tagNumberVisible=obj.tag_number_visible;  
                    this.engineProvided=obj.engine_no_by_client;  
                    this.makeProvided=obj.make_by_client;  
                    this.chassisProvided=obj.chassis_no_by_client;  
                    this.refId='KGT/'+obj.city_prefix+'/VER/AFF/'+this.id+'/'+obj.created_at;  
                    this.surveyType={text:obj.asset_type,id:obj.asset_id};                    
                    this.surveyor={text:obj.surveyor_name,id:obj.surveyor_id};
                    this.qcofficer={text:obj.qc_officer_name,id:obj.qc_officer_id};
                    this.region={text:obj.region_name,id:obj.region_id};
                    this.city={text:obj.city_name,id:obj.city_id};
                    this.district={text:obj.district_name,id:obj.district_id};
                    this.address=obj.address;
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
                    this.contactNo=obj.contact_no;
                    this.assigned=obj.assigned_on;
                    this.siteassigned=obj.site_assigned_on;
                    this.siteconducted=obj.site_conducted_on;
                    this.conducted=obj.conducted_on;
                    this.sitestatus=obj.site_status;
                    this.status=obj.status;
                    this.gps=obj.gps;
                    this.siteid=obj.site_id;
                    this.isSiteAccessible=obj.is_site_accessible;
                    this.isSameLocation=obj.same_location;
                    this.volume={text:obj.volume};
                    this.inventory=obj.utilization;
                    this.otheraddress=obj.other_address;
                    this.sharedPepsi=obj.utilization_pepsi;
                    this.modelNoProvided=obj.model_no_by_client;
                    this.sharedOthers=obj.utilization_shared;
                    this.sharedProductedDetails=obj.shared_products_name;
                    this.existance=obj.existance;
                    this.isFunctional=obj.functional;
                    this.reasonNoFunctional=obj.reason_for_no_operational;
                    this.isCoolerAccessible=obj.is_cooler_accessible;
                    this.generalCondition=obj.general_condition;
                    this.shopName=obj.shop_name;
                    this.shopKeeperName=obj.shopkeeper_name;
                    this.regNo=obj.reg_no;
                    this.engineNo=obj.engine_no;
                    this.chassisNo=obj.chassis_no;
                    this.modelNo=obj.model_number;
                    this.vehicleOwnership=obj.is_vehicle_destributed;
                    
                    this.getCities({id:obj.region_id});
                    this.getDistricts({id:obj.city_id});
                });

            }); 
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
        completedJob(){
            const  headers= {
                        'Authorization': 'Bearer ' + this.usertoken,
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                        };
            axios.post('/completedJob/'+this.id,headers).then(res=>{
                // res.data.forEach(obj => {
                //     this.surveyors.push({
                //         text:obj.name,
                //         id:obj.id
                //     })                    
                // });
                alert(res.data);
            }); 
        },
        cancelJob(){
            const  headers= {
                        'Authorization': 'Bearer ' + this.usertoken,
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                        };
            axios.post('/cancelledJob/'+this.id,headers).then(res=>{
                // res.data.forEach(obj => {
                //     this.surveyors.push({
                //         text:obj.name,
                //         id:obj.id
                //     })                    
                // });
                alert('Case Cancelled Successfully');
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
                        // text:obj.name,
                        text:obj.name +' ('+obj.city_name+'-'+obj.sub_city_name+')',
                        id:obj.id
                    })                    
                });
            }); 
        },
        storeAsset(){
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
                qc_officer:this.qcofficer.id,
                region:this.region.id,
                city:this.city.id,
                district:this.district.id
            };
            axios.post('/api/storeAsset',params,{
                headers
            
            }).then(res=>{
                alert('working');
            }); 
        },
    },
    components:{
        "v-select": vSelect,
        'images':Images
    //   EasyDataTable: window['vue3-easy-data-table'],
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
}
</script>