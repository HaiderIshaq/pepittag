<template>
     
  <div>
    
      <div class="container-fluid" style="padding-top: 80px;padding-bottom: 80px;">
          <!-- <div class="row" >
              <div class="col-md-12 text-center" >
                  <i class="fa fa-refresh" @click="getSurveys()" style="font-size: 25px; padding-bottom: 15px;"></i>
              </div>
          </div> -->
          <div class="row">
              <!-- {{ userid }} -->
              <div class="col-sm-12 mt-3">
                      <div class="" style="width: 50%;float: left;text-align: start;">
                          <i class="fa fa-user p-2"></i>
                          <b> {{ username }} </b>

                      </div>
                      <div class=""  style="width: 50%;text-align: end;float: left;">
                          <b>{{ userregion }}</b>

                      </div>
              </div>

              <div class="col-sm-12 mt-3">
                      <div class="" style="width: 50%;float: left;padding-left: 7px;text-align: start">
                          <b>Active  <span class="text-danger">{{ active }}</span> </b>

                      </div>
                      <div class=""  style="width: 50%;text-align: end;float: left;">
                          <b>Completed  <span class="text-success">{{ completed }}</span> </b>

                      </div>
              </div>
              <div class="col-md-12 mt-3">
                <Select :options="types" label="text" v-model="type"  placeholder="Asset's Type"></Select>  
              </div>

              <div class="col-md-12 mt-3">
                <Select :options="statuses" label="text" v-model="statusis"  placeholder="Status"></Select>  
              </div>
              <!-- <div class="col-md-12 mt-3" v-show="this.type.value==2"> -->
              <div class="col-md-12 mt-3">

                <Select :options="bottlers" label="text" v-model="bottler"  placeholder="Select Bottler"></Select>  
              </div>
              <div class="col-md-12 mt-3" v-show="this.type.value==1">
                <Select :options="filterregions" disabled label="text" v-model="filterregion" placeholder="Sub Region / Unit Name" ></Select>  
                <!-- <Select :options="filterregions" label="text" v-model="statusis" @update:modelValue="getSurveysByStatus($event)"></Select>   -->
              </div>
              <div class="col-md-12 mt-3">
                  <Select :options="searchBys" label="text" v-model="searchBy"  ></Select>  
              </div>               
              <div class="col-md-12 mt-3">
              <input type="text" v-model="searchValue" placeholder="Search Column" class="form-control bg-white">

              </div>
              <div class="col-md-12 mt-3">
                  <button class="btn btn-primary btn-sm mb-2"  @click="getSurveys()">Get Data</button>
                  <EasyDataTable
                    :headers="headers"
                    :items="items"
                    :loading="loading"
                    @click-row="showRow"
                    show-index
                    >
                  <template #loading>
                    <img
                    src="https://i.pinimg.com/originals/94/fd/2b/94fd2bf50097ade743220761f41693d5.gif"
                                    style="width: 250px; height: 250px;margin-top: 10px;"
                    />
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

                            <!-- <template #item-qc_officer="item">
                            <span  :style="item.status==0?'color:red;font-weight:bold':
                            item.status==2?'color:#04AA6D;font-weight:bold':
                            item.status==1?'color:blue;font-weight:bold':
                            item.status==3?'text-decoration: line-through;':
                            ''">{{ item.qc_officer }}</span>    
                            </template> -->
                            <!-- <template #item-tag_number="item">
                            <span  :style="item.status==0?'color:red;font-weight:bold':
                            item.status==2?'color:green;font-weight:bold':
                            item.status==1?'color:blue;font-weight:bold':
                            item.status==3?'text-decoration: line-through;':
                            ''">{{ item.tag_number }}</span>    
                            </template> -->
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
                            <template #item-city_name="item">
                            <span  :style="item.status==0?'color:red;font-weight:bold':
                            item.status==2?'color:green;font-weight:bold':
                            item.status==1?'color:blue;font-weight:bold':
                            item.status==3?'text-decoration: line-through;':
                            ''">{{ item.city_name }}</span>    
                            </template> 
                            <template #item-sub_city_name="item">
                            <span  :style="item.status==0?'color:red;font-weight:bold':
                            item.status==2?'color:green;font-weight:bold':
                            item.status==1?'color:blue;font-weight:bold':
                            item.status==3?'text-decoration: line-through;':
                            ''">{{ item.sub_city_name }}</span>    
                            </template> 
                            <template #item-shop_name="item">
                            <span  :style="item.status==0?'color:red;font-weight:bold':
                            item.status==2?'color:green;font-weight:bold':
                            item.status==1?'color:blue;font-weight:bold':
                            item.status==3?'text-decoration: line-through;':
                            ''">{{ item.shop_name }}</span>    
                            </template> 
                            <template #item-shopkeeper_name="item">
                            <span  :style="item.status==0?'color:red;font-weight:bold':
                            item.status==2?'color:green;font-weight:bold':
                            item.status==1?'color:blue;font-weight:bold':
                            item.status==3?'text-decoration: line-through;':
                            ''">{{ item.shopkeeper_name }}</span>    
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
                           
                            <template #item-edit="item">
                            <a :href="'editsurvey/'+item.id" style="color:black;text-decoration: none;" target="_blank">
                              <!-- <i class="fa fa-print"></i> -->
                              <i class="fa fa-pen-to-square"></i>
                            </a>    
                            </template> 
                      </EasyDataTable>


                </div>
                  <br><br>
              <!-- <div v-show="loading" style="text-align: center;">
                  <img style="width: 30%;padding-top: 34px;" src="img/loader.gif" alt="">
              </div>

              <div id="col-md-12 mt-3" style="text-align: center;" v-if="this.surveys.length==0">
                  <h3 style="margin-top:20px ;"><b>No Surveys Found</b> </h3>
              </div>
              <div class="" style="padding-bottom: 30px;">

                  <div   v-for="item in filteredItems" @click="nextPage(item.id)" class="col-sm-12 col-xl-3 col-md-3 col-lg-3 col-xl-3 col-xs-12 mt-3 mb-3" style="">
                      <div class="card text-center shadow  rounded" :class="{'bg-success text-white':item.status==1}">
                          <div class="card-header">
                          <b>  {{ item.title }}</b>
                          </div>
                          <div class="card-body">
                              <section v-if="item.asset_id==1">
                                  <h6 class="card-title" style="color: red;font-weight: bold;" :class="{'text-white':item.status==1}">{{item.shop_name}}</h6>
                                  <h6 class="card-title" style="color: blue;font-weight: bold" :class="{'text-white':item.status==1}">{{item.shopkeeper_name}}</h6>

                              </section>
                              <section v-else>
                                      <h6 class="card-title" style="color: red;font-weight: bold">{{item.make}}</h6>

                              </section>
                              <h6><b> {{ item.region }}, {{ item.city_name }}, {{ item.sub_city_name }}</b></h6>
                              <h6  v-if="this.type.value==2">
                                  <b > Reg No#:</b> <span style="color: blue;">{{ item.reg_no }}</span>  <br>
                                  <b > Engine No#:</b> <span style="color: blue;">{{ item.engine_no }}</span>  <br>
                                  <b > Chassis No#:</b> <span style="color: blue;">{{ item.chassis_no }}</span>  <br>
                                  
                                  </h6>
                              <span class="card-text"> <b>Address: </b> {{ item.address }}</span> <br>
                              <span class="card-text"> <b>Contact No: </b> {{ item.contact_no }}</span> <br>

                              year work 
                              <span class="card-text"> <b>Asset Year#: </b> {{ item.age_of_asset }}</span> <br>
                              end 

                          </div>
                          <div class="card-footer" :class="{'text-white':item.status==1}">
                              {{item.assigned_on}}
                          </div>
                      </div>
                  </div>
              </div> -->
       

          </div>
      </div>
  </div>
</template>
<style scoped>
html{
  scroll-behavior: smooth;
}
body::-webkit-scrollbar {
width: 5em;
}

body::-webkit-scrollbar-track {
box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
}

body::-webkit-scrollbar-thumb {
background-color: darkgrey;
outline: 1px solid slategrey;
}
</style>
<script>
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

  export default{
      props:{
    usertoken:String,
    userid:String,
    userregion:String,
    usersubcityid:String,
    usersubcityname:String,
    username:String,
    usercity:String
    
  },
  data(){
      return{
          searchField: [
            
          ],
          searchBys:[
            'None',
            'ID',
            'Shop Name',
            'Address',
            'Contact',
            'Make',
            'Engine',
            'Chassis',
            'RegNo',
            'Shopkeeper',
          ],
          searchBy:'None',
          searchValue: '',
          active:0,
        completed:0,
        headers:[
      
      ],
      items: [
       
      ],
          loading: false,
          surveys:[
      
      ],
      filterregions:[
      
      ],
      type:{text:'Freezer',value:1},
      types:[{text:'Freezer',value:1},{text:'Vehicle',value:2}],
      bottlers:[],
      bottler:'',
      filterregion:'',
      statusis:'',
      statuses:[
          {text:'Active',value:0},
          {text:'Completed',value:1}
      ]


      }
  },
  mounted(){
      this.getBottlers();
      this.filterregion={text:this.usersubcityname,id:this.usersubcityid};
      this.statusis={text:'Active',value:0};
      // this.getSurveys();
      this.getSubRegions();
  },
  components:{
      'Select':vSelect,
      'EasyDataTable': Vue3EasyDataTable

  },
  computed: {
  filteredItems() {
    return this.surveys.filter(item => {
      //  return item.type.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
      if(this.type==1){
            let byId =
            item.id.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            let byRegion =
            item.region.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            let byCity =
            item.city_name.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            let byDescription =
            item.asset_type.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1;
            let byEngine =
            item.engine_no.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1;
            let byChassis =
            item.chassis_no.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1;
            let byRegNo =
            item.reg_no.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1;
            let byContactNo =
            item.contact_no.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1;
            
            let byShopName = 
            item.shop_name.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1;
            let byShopKeeperName = 
            item.shopkeeper_name.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1;
            let byaddress = 
            item.address.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1; 
          
          if (byRegion === true) {
            return byRegion;
          } else if (byDescription === true) {
            return byDescription;
          } else if (byId === true) {
            return byId;
          }
          else if (byCity === true) {
            return byCity;
          }
          else if (byRegNo === true) {
            return byRegNo;
          }
          else if (byChassis === true) {
            return byChassis;
          }
          else if (byEngine === true) {
            return byEngine;
          }
          else if (byContactNo === true) {
            return byContactNo;
          }
        
          else if (byShopName === true) {
            return byShopName;
          }
          else if (byShopKeeperName === true) {
            return byShopKeeperName;
          }
          else if (byaddress === true) {
            return byaddress;
          }
    }
else{

          let byId =
            item.id.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            let byRegion =
            item.region.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            let byCity =
            item.city_name.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            let byDescription =
            item.asset_type.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1;
            let byEngine =
            item.engine_no.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1;
            let byChassis =
            item.chassis_no.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1;
            let byRegNo =
            item.reg_no.toLowerCase().indexOf(this.search.toLowerCase()) >
            -1;
           
          
          if (byRegion === true) {
            return byRegion;
          } else if (byDescription === true) {
            return byDescription;
          } else if (byId === true) {
            return byId;
          }
          else if (byCity === true) {
            return byCity;
          }
          else if (byRegNo === true) {
            return byRegNo;
          }
          else if (byChassis === true) {
            return byChassis;
          }
          else if (byEngine === true) {
            return byEngine;
          }
        

  }

    })
  }
},
  methods:{
      getBottlers(event){
          this.bottlers=[];
          this.bottler='';
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

            res.data.forEach(obj => {
                  this.bottlers.push({
                      text:obj.description,
                      value:obj.id
                  })                    
              });
          });

      },
    
      nextPage(id)
      {
          // alert(id);
          window.open('editsurvey/'+id);
      },  
      getSubRegions(){
          const  headers= {
          'Authorization': 'Bearer ' + this.usertoken,
          'Content-Type': 'application/json'
          };
          const params={
                  city:this.usercity
              };
          this.surveys=[];

          axios.get('/api/getRegionsForListingForApp',{
          headers,
          params
          }).then(res=>{
          // alert('working'); 
                

              res.data.forEach(obj => {
              this.filterregions.push({
              text:obj.name,
              id:obj.id
              });


          });

          });


      },
      getSurveys(){


        this.loading=true;

        this.headers=[];

        if(this.type.value==1)
        {
          this.headers=[
          { text: "Action", value: "edit" },
        // { text: "Asset ID", value: "asset_id" },
          { text: "Age Of Asset", value: "age_of_asset" },
          { text: "Title", value: "title", sortable: true },
          // { text: "Region", value: "region", sortable: true },
          { text: "City Name", value: "city_name", sortable: true },
          { text: "Sub City Name", value: "sub_city_name", sortable: true },
          // { text: "Make", value: "make", sortable: true },
          // { text: "Engine#", value: "engine_no", sortable: true },
          // { text: "Chassis#", value: "chassis_no", sortable: true },
          // { text: "Reg#", value: "reg_no", sortable: true },
          // { text: "Asset Type", value: "asset_type", sortable: true },
          { text: "Shop Name", value: "shop_name", sortable: true },
          { text: "Shopkeeper", value: "shopkeeper_name", sortable: true },
          { text: "Address", value: "address", sortable: true },
          { text: "Contact #", value: "contact_no", sortable: true },
        ];

        }
        else{
          this.headers=[
          { text: "Action", value: "edit" },
        // { text: "Asset ID", value: "asset_id" },
          { text: "Age Of Asset", value: "age_of_asset" },
          { text: "Title", value: "title", sortable: true },
          // { text: "Region", value: "region", sortable: true },
          { text: "City Name", value: "city_name", sortable: true },
          { text: "Sub City Name", value: "sub_city_name", sortable: true },
          { text: "Make", value: "make", sortable: true },
          { text: "Engine#", value: "engine_no", sortable: true },
          { text: "Chassis#", value: "chassis_no", sortable: true },
          { text: "Reg#", value: "reg_no", sortable: true },
          // { text: "Asset Type", value: "asset_type", sortable: true },
          // { text: "Shop Name", value: "shop_name", sortable: true },
          // { text: "Shopkeeper", value: "shopkeeper_name", sortable: true },
          // { text: "Address", value: "address", sortable: true },
          // { text: "Contact #", value: "contact_no", sortable: true },
        ];

        }


        this.items=[];
        // this.searchValue='';


      const  headers= {
          'Authorization': 'Bearer ' + this.usertoken,
          'Content-Type': 'application/json'
          };
          const params={
                  sub_city:this.filterregion.id,
                  type:this.type.value,
                  search_by:this.searchBy,
                  search_value:String(this.searchValue),
                  bottler:this.bottler.value,
                  status:this.statusis.value
              };
        

          axios.get('/api/getSurveys/'+this.userid,{
          headers,
          params
          }).then(res=>{
          // alert('working'); 
                

              res.data.forEach(obj => {
              this.items.push({
              "id":String(obj.job_id),
              // "asset_id":obj.asset_id,
              "age_of_asset":String(obj.age_of_asset),
              // "title":'KGT/'+obj.city_prefix+'/VER/AFF/'+obj.id+'/'+obj.assigned_on_year,
              "title":'KGT/'+obj.city_prefix+'/VER/AFF/'+obj.id+'/'+obj.assigned_on_year,
              "status":obj.status,
              "region":String(obj.region_name),
              "statusis":String(obj.statusis),
              "city_name":String(obj.city_name),
              "sub_city_name":obj.sub_city_name,
              "asset_type":String(obj.asset_type),
              "make":obj.make==null?'':obj.make,
              "engine_no":obj.engine_no==null?'':obj.engine_no,
              "chassis_no":obj.chassis_no==null?'':obj.chassis_no,
              "reg_no":obj.reg_no==null?'':obj.reg_no,
              "shop_name":obj.shop_name,
              "shopkeeper_name":obj.shopkeeper_name,
              "tag_number":obj.tag_number,
              "address":obj.address,
              "contact_no":obj.contact_no==null?'':obj.contact_no,
              "assigned_on":obj.assigned_on
              });


          });
          this.getSurveyStats();
          // }
          this.loading=false;
      console.log(res.data);
          });

          },
          getSurveyStats(){
          // this.loading=true;
          this.active=0;
                  this.completed=0;
      const  headers= {
          'Authorization': 'Bearer ' + this.usertoken,
          'Content-Type': 'application/json'
          };
          const params={
              sub_city:this.filterregion.id,
                  type:this.type.value,
                  bottler:this.bottler.value,
                  status:this.statusis.value
              };

          axios.get('/api/getSurveyStatsForSurveyor',{
          headers,
          params
          }).then(res=>{
          // alert('working'); 
                

              res.data.forEach(obj => {
                  this.active=obj.active;
                  this.completed=obj.completed;
              

          });
          // }
          // this.loading=false;

          });

          }
  }
  }
</script>