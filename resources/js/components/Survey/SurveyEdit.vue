<template>
    <div class="container-fluid text-center" style="padding-top: 50px;padding-bottom: 50px;">
        <div class="row pt-4">
            <div class="col-sm-12">
             <h5> <b> Case No# {{ id }} </b></h5>

            </div>
            <div class="col-sm-12">
              <div class="row">
                <div style="width: 60%;float: left;text-align: start;">
                  <a href="/">
                    <button class="btn btn-primary" >Back</button>
                  </a>                  
                </div>
                <div style="width: 40%;float: left;text-align: end;">

                </div>
              </div>


            </div>
            <div class="col-md-12 col-sm-12">
                <div class="row">
                   
                    <div class="col-md-12 col-sm-12 m-2 text-center">
                        <a :href="'/survey-generalinfo/'+this.id" style="margin-left: 25px;">
                            <button :class="[sitestatus==0?'btn btn-primary':'btn btn-success']"  >Site Details</button>
                        </a>
                    </div>
                    <div class="col-md-12 col-sm-12 m-2 text-center">
                        <a :href="'/survey-editinfo/'+this.id"  style="margin-left: 25px;">
                            <button :class="[assetstatus==0?'btn btn-primary':'btn btn-success']"  >Asset's Details</button>
                        </a>
                    </div>
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
    usertoken:String,
    id:String,
    userid:String,
    assetstatus:String,
    sitestatus:String
  },
  data() {
    return {
      mylocation: null,
      location: null,
      errorMessage: null
    }
  },
  mounted(){
    this.getDatabaseLocation();
    this.getLocation();
  },
  methods: {
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
    submitSurvey(){


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
      axios.post('/api/submitSurvey/'+this.id,params,{
        headers
      }).then(res=>{

        alert('Survey Submitted Successfully');
        window.location='/';
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
    }
  }
}
</script>