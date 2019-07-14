<template>
    <div>
        
        <div class="container-fluid" style="background:linear-gradient(270deg, rgb(1, 63, 120), rgb(0, 101, 183), rgb(0, 113, 205));color:white">
            <div class="container" style="padding:15px;display:flex;flex-direction:row;padding-bottom:0px;padding-bottom:10px;">

              <div class="row" style="display:flex;flex-direction:row;width:100%">
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                <div style="width:100%;padding:10px;">LOGO</div>
                </div>


                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                <div style="width:100%;padding:10px;">
                    <div style="margin-bottom:5px">Support Payment Channels :</div>
                    <div style="display:flex;flex-wrap:wrap">
                          <div style="padding:2px"><img style="width:45px;height:20px" src="https://ponimu-public.s3-ap-southeast-1.amazonaws.com/1532493169459"></div>
                          <div style="padding:2px"><img style="width:65px;height:20px" src="https://ponimu-public.s3-ap-southeast-1.amazonaws.com/1532493185464"></div>
                          <div style="padding:2px"><img style="width:50px;height:20px" src="https://ponimu-public.s3-ap-southeast-1.amazonaws.com/1532493200966"></div>
                    </div>
                     <div style="display:flex">
                          <div style="padding:2px"><img style="width:65px;height:20px" src="https://ponimu-public.s3-ap-southeast-1.amazonaws.com/1533629010603"></div>
                         
                    </div>
                </div>
                </div>

                
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                <div style="width:100%;padding:10px;">
                   <div style="margin-bottom:3px">Support :</div>
                   <div>
                      <ul style="list-style-type:none">
                         <li style="padding:3px">FAQ</li>
                         <li style="padding:3px">Contact-Us</li>
                      </ul>
                   </div>
                </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                <div style="width:100%;padding:10px;">
                  <div style="margin-bottom:3px">General Info :</div>
                   <div>
                      <ul style="list-style-type:none">
                         <li style="padding:3px">About</li>
                         <li style="padding:3px">Terms of Use</li>
                         <li style="padding:3px">Privacy Policy</li>
                      </ul>
                   </div>
                </div>
            </div>
        </div>
        </div>

        </div>

        <div class="container-fluid" style="background-color:#00203f">
            <div class="container" style="padding:0px;padding-top:10px;padding-bottom:10px;color:white">
                <div>
                  <b>Copyright © 2019.</b> Penerjemah.id adalah website untuk mencari jasa penerjemahan.
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.halamanIndex {
  font-size: 12px;
}

.hidden {
  display: none;
}

#sloganHeader {
  padding: 50px;
}

@media screen and (max-width: 987px) {
  #selengkapnya1 {
    display: "flex";
  }
}

@media screen and (max-width: 1200px) and (min-width: 987px) {
  #selengkapnya1 {
    display: none;
  }
}

@media screen and (max-width: 1100px) {
  #menuNavigasi {
    display: none;
  }
  #drawerToggle {
    display: flex;
  }

  #gambarHeader {
    display: none;
  }

  #sloganHeader {
    padding-left: 10px;
  }
}

@media screen and (max-width: 575px) {
  #sloganHeader {
    padding-left: 30px;
  }
}
</style>