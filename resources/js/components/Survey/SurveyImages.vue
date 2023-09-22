<template>
    <div class="container-fluid  mt-5 pb-4">
      <div class="row pt-3" >
                <div class="col-md-12 text-center" >
                    <i class="fa fa-refresh" @click="getImages()" style="font-size: 25px; padding-bottom: 15px;"></i>
                </div>
            </div>
        <div class="row pt-5">
          <div class="col-sm-12">
            <h5> <b> Image Edit # {{ id }} </b></h5>

          </div>
          <div class="col-md-12">
            <div style="width: 60%;float: left;">
              <a :href="'/survey-assetinfo/'+this.id">
                <button class="btn btn-primary" >Back</button>
              </a>
            </div>
            <div style="width: 40%;float: left;text-align: end;">
              <a :href="'/editsurvey/'+this.id">
                    <button class="btn btn-danger" >Next</button>
                  </a> 
            </div>


          </div>
 
            <div class="col-md-12 col-sm-12">
              <h5 class="mt-2">
                <b>Survey Images</b>
              </h5>
              <input type="file" class="form-control" ref="images"  accept="image/jpeg"  multiple="multiple" name="" id="">
              <input type="button"  @click="addImages()" class="btn btn-primary mt-3"  value="Upload">

 
            </div>
            <div class="col-md-12 col-sm-12 pt-4 pb-4" >
              <div v-show="loading" style="text-align: center;">
                    <img style="width: 30%;padding-top: 34px;" :src="this.url+'/img/loader.gif'" alt="">
                </div>
              <div v-for="img in items"  style="float: left;text-align: center;padding: 10px 50px 10px 50px;">
                <a :href="img.image" target="_blank">
                  <img :src="img.image" alt="" style="height: 200px; width: 250px;">

                </a>
              </div>

            </div>
            

        </div>

    </div>
</template>
<style>

</style>

<script>
export default {
  props:{
    url:String,
    usertoken:String,
    id:String,
    userid:String
  },
  data() {
    return {
      items:[],
      loading:false
    }
  },
  mounted(){
    this.getImages();
  },
  methods: {
    addImages(){
      this.loading=true;
if(this.$refs.images.files.length==0)
{
    alert('Please Select Some Files');
    this.loading=false;

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
  this.loading=false;

  alert('Images Uploaded Successfully');
  this.getImages();
  this.$refs.images.value = null;

}).catch(error=>{
alert("Image Limit full");

this.getImages();
this.$refs.images.value = null;
});

}
},
getImages(){
// items: [
//     { "id": 1,"image": "https://bafkreih3oswhrhrvxwhebuqqnlqtklnth5pbc2q3iv6446icpltt6tymvy.ipfs.dweb.link/?filename=Stephen.png",'title':'Photo1','uploaded_by':'Usama','uploaded_on':'12-May-2023 1:10 PM'}

//     ]
this.loading=true;
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
            uploaded_by:obj.uploaded_by
        })                    
    });
this.loading=false;

});
}  
  }
}
</script>