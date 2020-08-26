<template>
  <div class="halamanDaftar" style="background-color:#f2f2f2;overflow-x:hidden">
      <Header/>
        <div class="container-fluid" style="padding:0px;margin-top:10px;margin-bottom:10px;">
              <div class="container" style="padding-left:5px">
                    <div class="row" style="padding:10px;padding-right:13px">


                        <sideNav/>

                                     <div v-show="!this.prosespendaftaran" class="col-lg-8 col-md-12 col-md-12" style="padding-right:2px;">
                          <div style="font-size:28px;padding:10px;border-bottom:solid 1px;padding-left:0px;padding-bottom:5px;">Halaman Masuk</div>
                          <div class="row" style="display:flex;flex-direction:row">
                              
                                         <div class="col-lg-4">
                              <div style="padding:10px;">
                                  <img src="https://cdn.projects.co.id/assets/cartoon200/10926307_xxl.png">
                              </div>
                              </div>


                          <div class="col-lg-8">
                              <div style="width:100%;padding:15px;padding-top:35px">
                                  <div style="background-color:white;border:1px solid rgb(171, 170, 170);padding:20px;">
                                      <div>Jaga baik-baik identitas masuk kalian, ya! Jangan sampai dicolong hekel~ hekel~ macam bernama aziz yang itu, lo ....</div>
                                  </div>
                              </div>
                          </div>
                          </div>



                            <div style="padding:2px">
                               

                                <div style="display:flex;flex-direction:row;padding:12px;">
                                    <div style="width:80px">Username: <span style="color:red;font-weight:bold">*</span></div>
                                    <div style="width:100%"><input style="width:100%;padding-left:5px" v-model="value.username" v-on:change="usernameHandler($event)" type="text">
                                     <div v-show="this.peringatan.username" style="margin:0px;padding:0px;color:red;padding-top:5px">(Tdiak ditemukan username tsb ....)</div>
                                    </div>
                                   
                                </div>

                                 <div style="display:flex;flex-direction:row;padding:12px;">
                                    <div style="width:80px">Password: <span style="color:red;font-weight:bold">*</span></div>
                                    <div style="width:100%"><input style="width:100%;padding-left:5px" v-model="value.password" type="password"></div>
                                </div>

                                <div style="display:flex;flex-direction:row;padding:12px;">
                                    <div style="width:70px">Captcha: <span style="color:red;font-weight:bold">*</span></div>
                                    <div>
                                        <div style="border:solid 1px #a9a9a9;padding:2px;width:120px;height:40px"><img style="width:100%;height:100%" :src="`/captcha/${this.currentCaptcha.gambar}`"></div>
                                        <div style="width:120px;margin-top:15px"><input style="width:100%" v-model="value.captcha" type="text"></div>
                                    </div>
                                </div>

                                <div style="padding:12px">
                                    <div style="background-color:#e0dddd;padding:66px;">
                                        <div style="width:120px;" class="fadeEffect"><button v-on:click="submitHandler($event)" style="width:100%;color:white;background-color:#006bc2;padding:2px;outline:none;border:0px;">Masuk</button></div>
                                    </div>
                                </div>

                            </div>
                        </div>


     

                

                    </div>
              </div>
        </div>
      <Footer/>
      <ContainerChat :chatpayload="this.chatpayload"/>
  </div>
</template>

<script>
import ContainerChat from "@/components/ContainerChat";
import Header from "@/components/Header";
import Footer from "@/components/Footer";
import sideNav from "@/components/sideNav";
import axios from "axios";

export default {
  components: {
    ContainerChat,
    Header,
    Footer,
    sideNav
  },
  asyncData(context) {
    if (context.store.state.isLogged === true) {
      context.redirect(302, "/");
    }
    return axios({
      method: "POST",
      url: "http://localhost/penerjemah.id/server/api/global.php",
      data: `params={"aksi":"loaddatacaptcha"}`,
      headers: { "content-type": "application/x-www-form-urlencoded" }
    }).then(res => {
      return {
        //debug: context.store.state.isLogged,
        currentCaptcha: res.data
      };
    });
  },
  data() {
    return {
      chatpayload: [],
      debug: "",
      prosespendaftaran: false,
      currentCaptcha: {
        id_captcha: null,
        gambar: ""
      },
      peringatan: {
        username: false
      },
      value: {
        username: "",
        password: "",
        captcha: ""
      },
      proses: {
        username: false,
        email: false,
        captcha: false
      }
    };
  },
  beforeCreate() {
    if (this.$store.state.isLogged === true) {
      this.$router.push({ path: "/" });
    }
  },
  beforeMount() {},
  methods: {
    usernameHandler: function(e) {
      let username = encodeURI(this.value.username);
      axios({
        url: "http://localhost/penerjemah.id/server/api/global.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params={"aksi":"cekusername","id":"${username}"}`
      }).then(res => {
        let r = res.data;
        if (r.status === "success") {
          this.peringatan.username = false;
          e.target.style.border = "";
          this.proses.username = true;
        } else {
          e.target.style.border = "solid 1px red";
          this.peringatan.username = true;
          this.proses.username = false;
        }
      });
    },
    submitHandler: function(e) {
      if (this.value.password.length > 0) {
        this.proses.password = true;
      }

      if (this.value.captcha.length > 0) {
        this.proses.captcha = true;
      }

      if (this.proses.username && this.proses.captcha && this.proses.password) {
        e.target.disabled = true;

        axios({
          method: "POST",
          url: "http://localhost/penerjemah.id/server/api/global.php",
          data: `params={"aksi":"cekcaptcha","id":"${
            this.currentCaptcha.id_captcha
          }","value":"${this.value.captcha}"}`,
          headers: { "content-type": "application/x-www-form-urlencoded" }
        }).then(val => {
          let v = val.data;
          if (v.status) {
            axios({
              method: "POST",
              url: "http://localhost/penerjemah.id/server/api/logic.php",
              data: `params=${JSON.stringify({
                aksi: "proseslogin",
                username: this.value.username,
                password: this.value.password
              })}`,
              headers: { "content-type": "application/x-www-form-urlencoded" }
            }).then(res => {
              if (res.data.status === "success") {
                let payload = JSON.stringify({
                  id_user: res.data.data.id_user,
                  username: res.data.data.username,
                  token: res.data.data.token,
                  avatar: res.data.data.avatar,
                  namalengkap: res.data.data.namalengkap,
                  rating: res.data.data.rating
                });
                this.$cookie.set("auth", payload);
                this.$store.commit("isLogged", true);
                this.$store.commit("updateCredentials", {
                  id_user: res.data.data.id_user,
                  username: res.data.data.username,
                  token: res.data.data.token,
                  avatar: res.data.data.avatar,
                  namalengkap: res.data.data.namalengkap,
                  rating: res.data.data.rating
                });
                this.$router.push({ path: "/" });
              } else {
                alert("Login gagal!");
                document.location.reload();
              }
            });
          } else {
            alert("Captcha yang dimasukkan salah!");
            e.target.disabled = false;
          }
        });
      } else {
        alert("Masukkan semua data!");
      }
    },
    sidebarHandler: (e, str) => {
      if (str === "jelajahiJasaDrawer") {
        if (
          document
            .querySelectorAll("#jelajahiJasa-List")[0]
            .classList.contains("terbuka")
        ) {
          document
            .querySelectorAll("#jelajahiJasa-List")[0]
            .classList.remove("slideKebawah");
          document
            .querySelectorAll("#jelajahiJasa-List")[0]
            .classList.add("slideKeatas");
          document
            .querySelectorAll("#jelajahiJasa-List")[0]
            .classList.remove("terbuka");
        } else {
          document
            .querySelectorAll("#jelajahiJasa-List")[0]
            .classList.remove("slideKeatas");
          document
            .querySelectorAll("#jelajahiJasa-List")[0]
            .classList.add("slideKebawah");
          document
            .querySelectorAll("#jelajahiJasa-List")[0]
            .classList.add("terbuka");
        }
      }
      if (str === "jelajahiUserDrawer") {
        if (
          document
            .querySelectorAll("#jelajahiUser-List")[0]
            .classList.contains("terbuka")
        ) {
          document
            .querySelectorAll("#jelajahiUser-List")[0]
            .classList.remove("slideKebawah");
          document
            .querySelectorAll("#jelajahiUser-List")[0]
            .classList.add("slideKeatas");
          document
            .querySelectorAll("#jelajahiUser-List")[0]
            .classList.remove("terbuka");
        } else {
          document
            .querySelectorAll("#jelajahiUser-List")[0]
            .classList.remove("slideKeatas");
          document
            .querySelectorAll("#jelajahiUser-List")[0]
            .classList.add("slideKebawah");
          document
            .querySelectorAll("#jelajahiUser-List")[0]
            .classList.add("terbuka");
        }
      }
    }
  },
  mounted() {
    console.log(this.$cookie);
  }
};
</script>

<style scoped>
div {
  cursor: default;
}

.listSidebar {
}

.fadeEffect {
  opacity: 1;
  transition: opacity 0.5s;
}

.fadeEffect:hover {
  opacity: 0.5;
}

.sideBarNav {
  border-right: 1px solid black;
}

@keyframes animation-slideKebawah {
  from {
    height: 0px;
  }
  to {
    height: 210px;
  }
}

@keyframes animation-slideKeatas {
  from {
    height: 210px;
  }
  to {
    height: 0px;
  }
}

.slideKeatas {
  animation-name: animation-slideKeatas;
  animation-duration: 0.5s;
  animation-fill-mode: forwards;
  animation-timing-function: linear;
}

.slideKebawah {
  animation-name: animation-slideKebawah;
  animation-duration: 0.5s;
  animation-fill-mode: forwards;
  animation-timing-function: linear;
}

.halamanDaftar {
  font-size: 12px;
}

.sidebarComponent {
  padding: 6px;
  border-bottom: solid 1px;
  color: white;
  background: linear-gradient(270deg, #0068bc, #006fc9);
  cursor: pointer;
  transition: opacity 0.5s;
}

.sidebarComponent:hover {
  opacity: 0.5;
}

.hidden {
  display: none;
}

#sloganHeader {
  padding: 50px;
}

@media screen and (max-width: 1200px) {
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

@media screen and (max-width: 991px) {
  .sidebarComponent {
    background: linear-gradient(
      270deg,
      rgb(1, 63, 120),
      rgb(0, 101, 183),
      rgb(0, 113, 205)
    );
  }

  .sideBarNav {
    border-right: 0px;
  }
}

@media screen and (max-width: 987px) {
  #selengkapnya1 {
    display: "flex";
  }
}

@media screen and (max-width: 575px) {
  #sloganHeader {
    padding-left: 30px;
  }
}
</style>
