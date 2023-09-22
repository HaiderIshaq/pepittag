<template>
    <div class="row">
        <div class="col-sm-9 pt-3">
            <div class="row">
                <div class="col-sm-1">
                    File
                </div>
                <div class="col-sm-5">
                    <input type="file"  ref="images"  accept="image/jpeg"  multiple="multiple"  >
                </div>
                <div class="col-sm-2">

                    <input type="button"  @click="addImages()" class="btn btn-primary"  value="Upload">
                </div>
            </div>
        </div>
        <div class="col-sm-3 text-end pt-3">

            <i class="fa fa-refresh" @click="getImages()" style="font-size: 22px;padding-right: 15px;position: relative;top:5px"></i>

                <button @click="downloadImages()" class="btn  btn-primary m-1">Download All</button>
                
        </div>
        <div class="pt-3">
            <EasyDataTable :headers="headers" :items="items">
            <!-- <template #item-team="{ teamName, teamUrl }">
                <a :href="teamUrl">{{ teamName }}</a>
            </template> -->
            <template #item-image="{ image}">
                <!-- {{ item.indicator.weight }} (lbs) -->
                <a :href="image" target="_blank">
                    <img :src="image" style="height:50px;weight:50px">
                </a>
            </template>
            <template  #item-action="{image}">
                <!-- {{ item.indicator.weight }} (lbs) -->
                <a :href="image" target="_blank">
                    <img :src="image" style="height:50px;weight:50px">
                </a>
            </template>
            
            <template  #item-edit="item">
              <!-- <i class="fa fa-print"></i> -->
              <i class="fa fa-trash" @click="deleteAsset(item.id)"></i>
             
            </template>
            <template  #item-seq="item">

              <Select :options="counter" v-model="item.order"  label="text" @update:modelValue="updateOrder(item.id,$event)"></Select>
             
            </template>

            </EasyDataTable> 

        </div>
        
    </div>
</template>
<style>
</style>
<script>
import vSelect from "vue-select";
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import axios from 'axios';
import "vue-select/dist/vue-select.css";
export default{

    props:{
        usertoken:String,
        id:Number
    },
    components:{
      'EasyDataTable': Vue3EasyDataTable,
'Select': vSelect
    },
    mounted(){
        this.getImages();
    },
    methods: {

        updateOrder(id,order){
         let formData={
    rowId:id,
    orderID:order.text
        };
        axios.put('/updateOrder/' + id, formData)
    .then(res => {
        console.log(res.data); // Log the response data
        this.getImages();
    })
    .catch(error => {
        console.error(error);
    });
        },




        deleteAsset(id){

            const  headers= {
                    'Authorization': 'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            const params={
                // type:3
            };
            axios.post('/deleteImage/'+id,{
                headers,
                params
            
            }).then(res=>{

                alert('Asset Removed');
                this.getImages();
            });
        },
        addImages(){

            if(this.$refs.images.files.length==0)
            {
                alert('Please Select Some Files');
            }

            else{



            let formData = new FormData();
            for( var i = 0; i < this.$refs.images.files.length; i++ ){
                let file = this.$refs.images.files[i];
                console.log(file);

                formData.append('files[' + i + ']', file);
            }

            formData.append('jid', this.id);



            axios.post('/uploadimages',formData).then(res=>{

            this.getImages();
            alert('Images Uploaded Successfully');

            }).catch(error=>{
            alert("Something Went Wrong");



            });

            }
        },

        downloadImages() {
  const headers = {
    'Authorization': 'Bearer ' + this.usertoken,
    'Content-Type': 'application/json'
  };

  const params = {};

  axios
    .get('/downloadImages/' + this.id, {
      headers,
      params,
      responseType: 'blob', // Set the response type to 'blob' to handle binary data
    })
    .then((response) => {
      if (response.status === 200) {
        // Create a Blob object from the response data
        const blob = new Blob([response.data], { type: 'application/zip' });

        // Create a temporary URL for the Blob object
        const url = window.URL.createObjectURL(blob);

        // Create a link element to trigger the download
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'images.zip');
        document.body.appendChild(link);

        // Simulate a click on the link to trigger the download
        link.click();

        // Clean up resources
        window.URL.revokeObjectURL(url);
      } else {
        console.error('Unexpected status code:', response.status);
      }
    })
    .catch((error) => {
      console.error('Error downloading ZIP file:', error);
    });
},
    
            
          
          getImages(){
            // items: [
            //     { "id": 1,"image": "https://bafkreih3oswhrhrvxwhebuqqnlqtklnth5pbc2q3iv6446icpltt6tymvy.ipfs.dweb.link/?filename=Stephen.png",'title':'Photo1','uploaded_by':'Usama','uploaded_on':'12-May-2023 1:10 PM'}

            //     ]
            this.items=[];

            const  headers= {
                    'Authorization': 'Bearer ' + this.usertoken,
                    'Content-Type': 'application/json'
                    };
            const params={
                // type:3
            };
            axios.get('/api/getImages/'+this.id,{
                headers,
                params
            
            }).then(res=>{
                res.data.forEach(obj => {
                    this.items.push({
                        id:obj.id,
                        title:obj.title,
                        image:obj.path,
                        uploaded_on:obj.uploaded_on,
                        uploaded_by:obj.uploaded_by,
                        order:obj.order_path,
                    });   
                   
                })
                console.log(res.data);
                this.counter=[];
                    for(var i=1; i<=this.items.length; i++)
                    {
                        this.counter.push({
                            text:i
                        })
                    }
               
            }).catch(error=>{
                alert(error);
            });
            
          }  
        },
    data(){

        return{
            sharedProductedDetails:'',
            searchValue:'',
        serverItemsLength:5,
        counter:[],
        order:'',
        items:[],
        headers:[
        { text: "#", value: "id" },
        { text: "Action", value: "edit" },
        { text: "Sequence", value: "seq" },
        { text: "Image", value: "image" },
        { text: "Title", value: "title"},
        { text: "Uploaded By", value: "uploaded_by"},
        { text: "Uploaded On", value: "uploaded_on"}
        ]

        }
    }
}
</script>
