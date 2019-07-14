<template>
    <div class="headerComponent">
                <div class="container-fluid" id="headerAtas" style="padding:10px;border-bottom:1px solid #00000033">
        <div class="container">
            <div class="row" style="display:flex;justify-content:space-between">
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                  <div class="row" style="display:flex;flex-direction:row;padding:5px">
                        <div id="nomorTelepon" style="padding-right:5px;border-right:1px solid #00203f"><font-awesome-icon style="height:10px;width:10px;margin-bottom:1px;margin-left:4px;margin-right:5px" icon="phone" />08996189345</div>
                        <div id="alamatEmail" style="padding-left:5px"><font-awesome-icon style="height:10px;width:10px;margin-bottom:1px;margin-left:4px;margin-right:4px" icon="envelope" />admin@penerjemah.id</div>
                  </div>
              </div>
              <div id="profilLength">
                  <div v-show="this.$store.state.isLogged===true" style="display:flex;flex-direction:row">
                     <div v-if="this.$store.state.notifikasi.length>0" class="ballonNotification" style="position:absolute;background-color:red;flex:1;text-align:center;border-radius:5px;margin-right:10;color:white;padding-right:2px;padding-left:2px;font-size:0.75rem">{{this.$store.state.notifikasi.length}}</div>
                      <div v-on:click="profilHandler()" style="margin-right:5px;padding:5px;cursor:pointer"><font-awesome-icon style="height:10px;width:10px;margin-bottom:1px;margin-left:4px;margin-right:4px" icon="user" />{{this.$store.state.login.username}}</div>
                     
                      <div  v-show="this.menuhover===true" class="menuhover" style="z-index:99;display:flex;position:absolute;background-color:#f2f2f2;border-radius:2px;border:solid 1px;width:300px;margin-top:30px;padding:10px">
                          <div style="width:100%;display:flex;flex-direction:column">
                              <div style="display:flex;flex-direction:row">
                              <div style="border:solid 1px;width:90px;height:80px;margin-left:3px"><img style="width:100%;height:100%" :src="`https://penerjemah.web.id/assets/avatar/`+this.$store.state.login.avatar"></div>
                              <div style="width:100%">
                                    <div style="padding-left:12px;font-size:11px">{{this.$store.state.login.namalengkap}}</div>
                                    <div style="padding-left:12px" v-html="ratingHandler(this.$store.state.login.rating)"></div>
                                    <div style="padding-left:8px;margin-top:6px"><font-awesome-icon style="height:12px;color:#828282;width:12px;margin-bottom:1px;margin-left:4px;margin-right:4px" icon="coins"/>{{this.emoney}}</div>
                                    <div style="padding-left:12px;display:flex;flex-direction:row;margin-top:2px">
                                    <div v-on:click="moveHandler(`/detail/user/${$store.state.login.username}`)" style="margin-right:5px;padding-left:2px;padding-right:2px;background-color:#888888;cursor:pointer;border-radius:3px"><font-awesome-icon style="height:10px;width:10px;margin-bottom:1px;margin-left:4px;margin-right:4px;color:white" icon="wrench" /></div>
                                    <div style="padding-left:5px;padding-right:5px;background-color:#d2d2d2;border-radius:3px;cursor:pointer">top-up</div>
                                    <div v-on:click="signOutHandler()" style="padding-left:6px;padding-right:5px;background-color:#8e1515;color:white;cursor:pointer;border-radius:3px;margin-left:4px">keluar</div>
                              
                                    </div>
                                    
                                 
                                   
                              </div>
                              </div>
                                 <div v-if="this.$store.state.notifikasi.length===0" style="margin-top:10px;border-top:solid 1px;padding:5px;height:100px;display:flex;justify-content:center;align-items:center">
                                    <div>Tidak ada notifikasi.</div>
                                 </div>

                                  <div v-if="this.$store.state.notifikasi.length>0" style="margin-top:10px;border-top:solid 1px;padding:5px;display:flex;flex-direction:column">
                                      <div class="notif" v-for="(val,i) in this.$store.state.notifikasi" :key="i" style="padding:2px;color:white;margin-bottom:8px;text-align:center">{{val.keterangan}}</div>
                                    
                                 </div>
                          
                          </div>
                            

                      </div>
                      
                  </div>
                  
              </div>

               <div v-show="this.$store.state.isLogged===false">
                  <div style="display:flex;flex-direction:row">
                      <div v-on:click="moveHandler(`/masuk`)" class="underline" style="margin-right:5px;padding:5px"><font-awesome-icon style="height:10px;width:10px;margin-bottom:1px;margin-left:4px;margin-right:4px" icon="sign-in-alt" />Login</div>
                      <div class="underline" style="margin-left:5px;margin-right:5px;padding:5px;"><font-awesome-icon style="height:10px;width:10px;margin-bottom:1px;margin-right:4px" icon="question" />Lupa Password!</div>
                      <div v-on:click="moveHandler(`/pendaftaran`)" class="underline" style="margin-left:5px;margin-right:5px;;padding:5px;display:flex"><font-awesome-icon style="height:10px;width:10px;margin-bottom:1px;margin-right:4px;margin-top:3px" icon="users" />Daftar<div style="margin-bottom:5px;background-color:red;border-radius:3px;font-size:10px;margin-bottom:5px;margin-left:5px;    background-color: #888888;    padding-right: 2px;    padding-left: 2px;color:white">Gratis!</div></div>
                  </div>
                  
              </div>

            </div>         
        </div>
    </div> 

      <div class="container-fluid" id="headerPlaceholder" style="display:none;background:linear-gradient(270deg,#013f78,#0065b7,#0071cd);color:white;padding:10px;z-index:100">
        <div class="container" style="padding:0px">
            <div style="display:flex;flex-direction:row;justify-content:space-between">
              <div v-on:click="moveHandler(`/`)" style="padding:10px;cursor:pointer">LOGO</div>
              <div class="hidden" style="display:none" id="drawerToggle">BUKA</div>
              <div style="padding:5px" id="menuNavigasi">
                  <ul style="list-style-type:none;margin:0px;padding:0px;display:flex">
                    <li style="padding:5px;padding-right:15px;padding-left:10px;font-size:15px">
                       Cara Kerja
                    </li>
                    <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Projects
                    </li>
                    <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Services
                    </li>
                    <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Products
                    </li>
                    <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Affiliate
                    </li>
                     <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Community
                    </li>
                     <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Blog
                    </li>
                  </ul>
              </div>
            </div>
        </div>
     </div>


     <div class="container-fluid" id="headerDynamic" style="background:linear-gradient(270deg,#013f78,#0065b7,#0071cd);color:white;padding:10px;z-index:100">
        <div class="container" style="padding:0px">
            <div style="display:flex;flex-direction:row;justify-content:space-between">
              <div v-on:click="moveHandler(`/`)" style="padding:10px;cursor:pointer">LOGO</div>
              <div class="hidden" style="display:none" id="drawerToggle">BUKA</div>
              <div style="padding:5px" id="menuNavigasi">
                  <ul style="list-style-type:none;margin:0px;padding:0px;display:flex">
                    <li style="padding:5px;padding-right:15px;padding-left:10px;font-size:15px">
                       Cara Kerja
                    </li>
                    <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Projects
                    </li>
                    <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Services
                    </li>
                    <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Products
                    </li>
                    <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Affiliate
                    </li>
                     <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Community
                    </li>
                     <li style="padding:5px;padding-right:15px;padding-left:15px;font-size:15px">
                       Blog
                    </li>
                  </ul>
              </div>
            </div>
        </div>
     </div>
    </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      emoney: null,
      notifikasi: [],
      menuhover: false,
      offsetHeight: 0
    };
  },

  methods: {
    signOutHandler: function() {
      this.$cookie.delete("auth");
      document.location.reload();
    },
    profilHandler: function() {
      if (this.menuhover === true) {
        this.menuhover = false;
      } else {
        if (this.emoney === null) {
          axios({
            method: "POST",
            url: "https://penerjemah.web.id/api/logic.php",
            data: `params=${JSON.stringify({
              aksi: "cekUangDigital",
              data: this.$store.state.login
            })}`,
            headers: { "content-type": "application/x-www-form-urlencoded" }
          }).then(res => {
            console.log(res);
            if (res.data.status === "success") {
              this.emoney = res.data.jumlah;
              this.menuhover = true;
              this.$store.commit("setNotifikasiSudahDilihat", true);
            } else {
              alert("Unauthorized");
            }
          });
        } else {
          this.$store.commit("setNotifikasiSudahDilihat", true);
          this.menuhover = true;
        }
      }

      axios({
        method: "POST",
        url: "https://penerjemah.web.id/api/transaction.php",
        data: `params=${JSON.stringify({
          aksi: "notifikasiSudahDilihat",
          credentials: this.$store.state.login,
          notifikasi: this.$store.state.notifikasi
        })}`,
        headers: { "content-type": "application/x-www-form-urlencoded" }
      }).then(res => {
        console.log(res);
      });
    },
    ratingHandler: function(rating) {
      if (rating < 20) {
        return `<img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">`;
      } else if (rating >= 20 && rating < 35) {
        return `<img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">`;
      } else if (rating >= 35 && rating < 50) {
        return `<img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">`;
      } else if (rating >= 50 && rating < 75) {
        return `<img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">`;
      } else if (rating >= 75 && rating < 90) {
        return `<img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-off.png">`;
      } else if (rating >= 90 && rating <= 100) {
        return `<img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">
                <img src="https://cdn.projects.co.id/assets/metronic/global/plugins/jquery-raty/img/star-on.png">`;
      }
    },
    moveHandler(path) {
      this.$router.push({ path: path });
    }
  },
  beforeMount() {},
  mounted() {
    ///notification
    //alert(this.$store.state.notifikasiSudahDilihat);
    if (
      (this.$store.state.notifikasi.length === 0 &&
        this.$store.state.isLogged === true) ||
      this.$store.state.notifikasiSudahDilihat === true
    ) {
      axios({
        method: "POST",
        url: "https://penerjemah.web.id/api/transaction.php",
        data: `params=${JSON.stringify({
          aksi: "lihatJumlahNotifikasi",
          credentials: this.$store.state.login
        })}`,
        headers: { "content-type": "application/x-www-form-urlencoded" }
      }).then(res => {
        this.$store.commit("setNotifikasi", res.data);
        this.$store.commit("setNotifikasiSudahDilihat", false);
      });
    }

    ///

    let offsetHeight = document.querySelectorAll("#headerDynamic")[0].offsetTop;

    if (window.innerWidth <= 575) {
      document.querySelector(".menuhover").style.marginLeft = ``;
    } else {
      let profilelementwidth = 298;
      let namaelwidth = document.querySelector("#profilLength").clientWidth;
      var le = Math.floor(profilelementwidth) - namaelwidth + 11;

      document.querySelector(".menuhover").style.marginLeft = `-${le}px`;
    }

    function WidthListener(x) {
      if (x.matches) {
        // If media query matches
        document.querySelector(".menuhover").style.marginLeft = ``;
      } else {
        document.querySelector(".menuhover").style.marginLeft = `-${le}px`;
      }
    }

    var matchWidth = window.matchMedia("(max-width: 575px)");
    WidthListener(matchWidth); // Call listener function at run time
    matchWidth.addListener(WidthListener); // Attach listener function on state changes

    window.addEventListener("beforeunload", function(e) {
      window.scrollTo(0, 0);
    });

    window.addEventListener("scroll", function(e) {
      if (window.scrollY >= offsetHeight) {
        document.querySelectorAll("#headerDynamic")[0].style.position = "fixed";
        document.querySelectorAll("#headerDynamic")[0].style.top = "0px";

        document.querySelectorAll("#headerPlaceholder")[0].style.display = "";
      } else {
        document.querySelectorAll("#headerDynamic")[0].style.position = "";
        document.querySelectorAll("#headerDynamic")[0].style.marginTop = "";
        document.querySelectorAll("#headerPlaceholder")[0].style.display =
          "none";
      }
    });
  }
};
</script>
<style>
.menuhover {
  margin-left: 0px;
}

.notif {
  background-color: #00203f61;
  cursor: pointer;
}

.notif:hover {
  background-color: rgba(0, 32, 63, 0.8);
}

.underline:hover {
  cursor: pointer;
  text-decoration: underline;
}

* {
  font-family: "Roboto", sans-serif;
  font-weight: 300;
}

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
  .ballonNotification {
    margin-left: 9px;
    margin-top: 4px;
  }

  #sloganHeader {
    padding-left: 30px;
  }

  .menuhover {
    margin-left: 7px;
  }
}
</style>