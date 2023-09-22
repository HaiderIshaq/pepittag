<template>
     <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Assets By FAR</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div v-show="loading">
                    <h4>
                        <b>
                            Uploading....
                        </b>
                    </h4>
                </div>
                <div>
                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Bottler / Company</label>
                        <div class="col-sm-9">
                            <Select :options="bottlers" label="text" v-model="bottler"></Select>
                            <!-- <input type="email" class="form-control form-control-sm" id="colFormLabelSm" placeholder="col-form-label-sm"> -->
                            <div v-if="v$.bottler.$error" class="text-danger">Name field has an error.</div>
                        
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Vehicle</label>
                        <div class="col-sm-9">

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" v-model="type" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="1">
                                <label class="form-check-label" for="inlineRadio2">Cooler / Freezer</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" v-model="type" name="inlineRadioOptions" id="inlineRadio1" value="2">
                                <label class="form-check-label" for="inlineRadio1">Vehicle</label>
                            </div>
                            <div v-if="v$.type.$error" class="text-danger">Name field has an error.</div>
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">File</label>
                        <div class="col-sm-9">
                            <input type="file" ref="myfile">
                        
                        </div>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" @click="saveData()" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>

          
   
</template>

<style scoped>

</style>
<script>
import vSelect from "vue-select";
import useVuelidate from "@vuelidate/core";
import { email, required, minLength } from "@vuelidate/validators";

export default{
    data(){
        return{
            bottlers:[],
            bottler:'',
            type:'',
            file:'',
            loading:false

        }
    },
    setup: () => ({ v$: useVuelidate() }),
    props:{
        usertoken:String

    },
    components:{
      'Select': vSelect,

    },
    mounted(){
        this.getBottlers();
    
    
    },
    
    methods:{
        saveData(){
            // alert('working');

            this.v$.bottler.$touch();
            this.v$.type.$touch();
            if (!this.v$.$validationGroups.firstGroup.$invalid) {
                
                this.postData();
                this.v$.bottler.$reset();
                    this.v$.type.$reset();
            }
        },  
        postData()
        {
            this.loading=true;
            const  headers= {
                        'Authorization': 'Bearer ' + this.usertoken,
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'multipart/form-data'
                        };
                        let file = this.$refs.myfile.files[0];
                        // console.log(file);

                        let formData = new FormData();
                        formData.append('myfile',file);
                        formData.append('bottler', this.bottler.id);
                        formData.append('type', this.type);

                const params={
                    // type:this.surveyType.id,
                    // type_name:this.surveyType.text,
                    // type_slug:this.surveyType.slug,
                    // surveyor:this.surveyor.id,
                    // address:this.address,
                    // other_address:this.anotherAddress,
                    // make:this.make,
                    // contact_no:this.contactNo,
                    // is_site_accessible:this.isSiteAccessible,
                    // qc_officer:this.qcofficer.id,
                    // region:this.region.id,
                    // city:this.city.id,
                    // district:this.district.id,
                    // same_location:this.isSameLocation,
                    // tag_number:this.tagNumber,
                    // existance:this.existance,
                    // vehicle_type:this.vehicleType,
                    // reason_for_no_operational:this.reasonNoFunctional,
                    // vehicle_type_other:this.vehicleTypeOther,
                    // functional:this.isFunctional,
                    // site:this.site.id,
                    // shared_products_name:this.sharedProductedDetails,
                    // is_cooler_accessible:this.isCoolerAccessible,
                    // general_condition:this.generalCondition,
                    // volume:this.volume.text,
                    // utilization:this.inventory,
                    // shared_pepsi:this.sharedPepsi,
                    // shop_name:this.shopName,
                    // shopkeeper_name:this.shopKeeperName,
                    // shared_others:this.sharedOthers,
                    // reg_no:this.regNo,
                    // engine_no:this.engineNo,
                    // chassis_no:this.chassisNo,
                    // model_number:this.modelNo,
                    // freezer_type:this.freezerType,
                    // freezer_type_other:this.freezerTypeOther,
                    // is_vehicle_distributed:this.vehicleOwnership
                };
                axios.post('/storeAssetsByFar',formData,{
                    headers
                
                }).then(res=>{
                    this.type='';
                    this.$refs.myfile.value = null;
                    this.bottler='';
                    this.v$.$reset();

                    this.loading=false;
                    alert('Data uploaded Successfully');

                    // this.getRefId();
                    // window.open('edit/'+res.data, '_blank');

                });
        },
        getBottlers(){
            const  headers= {
                    'Authorization': 'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            const params={
                type:3
            };
            axios.get('/api/getBottlers',{
                headers,
                params
            
            }).then(res=>{

                res.data.forEach(obj => {
                    this.bottlers.push({
                        text:obj.description,
                        id:obj.id
                    })                    
                });
            }); 
   
        }
    },
    validations () {
    return {
        bottler: {
          required,
        },
        type: {
          required,
        },
        $validationGroups: {
        firstGroup: ['bottler','type']
        }

       
    }
},
}
</script>