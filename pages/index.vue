<template>
  <div class="halamanIndex" style="background-color:#f2f2f2;overflow-x:hidden">

    <Header/>
    
     <div class="container-fluid" style="padding:0px;background-color:#00203f;color:white;margin-bottom:14px">
        <div class="container" style="padding:0px;">
            <div style="display:flex;flex-direction:row">
                <div id="gambarHeader" style="width:100%">
                    <img style="width:100%;height:100%" src="https://cdn.projects.co.id/assets/custom/work-at-home.png">
                </div>
                <div id="sloganHeader" style="width:100%;height:100%">
                    <div style="display:flex;flex-direction:column;width:100%;height:100%">
                        <div style="font-size:30px;font-weight:normal">TEMUKAN SEORANG PENERJEMAH! {{this.$store.state.debug}}</div>
                        <div>DI SELURUH PENJURU INDONESIA UNTUK BERBAGAI PEKERJAAN PENERJEMAHAN</div>
                        <div style="padding-top:20px;padding-bottom:30px;">penerjemahan/pe·ner·je·mah·an/ n proses, cara, perbuatan menerjemahkan; pengalihbahasaan: ~ Pancatantra yang sempurna dilakukan pada Zaman Islam oleh Abdul Kadir Munsji</div>
                        <div style="display:flex;flex-direction:row">
                            <div v-on:click="moveHandler(`/jelajahi/permintaan`)" class="btnDaftar" style="margin-right:15px">PROMOSIKAN</div>
                            <nuxt-link to="pendaftaran" style="color:white;text-decoration:none" ><div v-show="this.$store.state.isLogged===false" class="btnDaftar">DAFTAR SEKARANG</div></nuxt-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        
     </div>

   <div class="container-fluid" style="margin-bottom:15px">
            <div class="container" style="">
                <div class="row" style="padding:0px;">
                    <div style="padding:0px;" class="col-lg-4 col-md-12 col-sm-12">
                      <div style="margin:10px;padding:10px;background-color:#ffffff;border:1px solid #abaaaa;">
                       <div style="border-bottom:solid 1px;display:flex;flex-direction:row;justify-content:space-between">
                          <div style="font-size:25px">Baru ditambahkan :</div>
                          <div v-on:click="moveHandler(`/jelajahi/permintaan`)" id="selengkapnya1" style="cursor:pointer;align-self:center">selengkapnya</div>
                       </div>
                       <div style="padding-top:12px;padding-bottom:10px;">
                          
                          
                          
                          <div v-for="(val,i) in this.baruditambahkan" v-bind:key="i" style="display:flex;flex-direction:row;margin-bottom:5px">
                            <div style="background-color: #f2f2f2;border: 1px solid #969696;height:80px;width:90px;padding:5px"><img style="width:100%;height:100%" :src="`http://localhost/penerjemah.id/server/assets/avatar/${val.avatar}`"></div>
                            <div style=";width:100%;padding-left:10px;padding-right:10px;">
                                 <div style="font-size:14px"><nuxt-link class="underline" style="color:blue" :to="`/detail/permintaan/${val.id}`">{{val.judul}}</nuxt-link></div>
                                 <div>Promotor : <nuxt-link class="underline" :to="`detail/user/${val.user}`">{{val.user}}</nuxt-link></div>
                            </div>
                            
                          </div>


            
                          
                      </div>
                    </div>
                    </div>
                    <div style="padding:0px" class="col-lg-4 col-md-12 col-sm-12">
                      <div style="background-color:#ffffff;border:1px solid #abaaaa;padding:10px;margin:10px;">
                       <div style="border-bottom:solid 1px;display:flex;flex-direction:row;justify-content:space-between">
                          <div style="font-size:25px">Rating tertinggi :</div>
                          <div style="align-self:center"></div>
                       </div>
                       
                       <div style="padding-top:12px;padding-bottom:5px;">
                          

                          <div v-for="(val,i) in this.ratingtertinggi" v-bind:key="i" style="display:flex;flex-direction:row;margin-bottom:5px">
                            <div style="background-color: #f2f2f2;border: 1px solid #969696;height:80px;width:90px;padding:5px"><img style="width:100%;height:100%" :src="`http://localhost/penerjemah.id/server/assets/avatar/${val.avatar}`"></div>
                            <div style=";width:100%;padding-left:10px;padding-right:10px;">
                                 <div style="font-size:14px"><nuxt-link :to="`/detail/user/${val.username}`" class="underline" style="color:blue">{{val.username}}</nuxt-link></div>
                                 <div style="margin-bottom:5px" v-html="ratingHandler(val.rating)"></div>
                                 <div>{{val.rating}}/100</div>
                                 <div v-if="val.rating===`No Ranking`">No Ranking</div>
                                <div v-else>#{{val.ranking}}/{{total}}</div>
                            </div>
                            
                          </div>


                       </div>
                    </div>
                    </div>
                    <div style="padding:0px;" class="col-lg-4 col-md-12 col-sm-12">
                      <div style="background-color:#ffffff;border:1px solid #abaaaa;;padding:10px;margin:10px">
                         <div style="border-bottom:solid 1px;display:flex;flex-direction:row;justify-content:space-between">
                          <div style="font-size:25px">Aktivitas :</div>
                          <div style="align-self:center"></div>
                       </div>
                       <div style="padding-top:12px;padding-bottom:10px;">

                                                    <div v-for="(val,i) in this.aktivitas" v-bind:key="i" style="display:flex;flex-direction:row;margin-bottom:5px">
                            <div style="background-color: #f2f2f2;border: 1px solid #969696;height:80px;width:90px;padding:5px"><img style="width:100%;height:100%" :src="`http://localhost/penerjemah.id/server/assets/avatar/${val.avatar}`"></div>
                            <div style=";width:100%;padding-left:10px;padding-right:10px;">
                                 <div style="font-size:14px"><nuxt-link style="color:blue" class="underline" :to="`/detail/user/${val.username}`">{{val.username}}</nuxt-link>: <span v-html="decodeURI(val.deskripsi)"></span></div>
                            </div>
                            

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
import Router from "vue-router";
import Header from "@/components/Header";
import Footer from "@/components/Footer";
import ContainerChat from "@/components/ContainerChat";
import axios from "axios";

export default {
  components: {
    ContainerChat,
    Header,
    Footer
  },
  fetch({ store, params, context }) {},
  asyncData() {
    return axios({
      method: "POST",
      url: "http://localhost/penerjemah.id/server/api/global.php",
      data: `params={"aksi":"loaddatadashboard"}`,
      headers: { "content-type": "application/x-www-form-urlencoded" }
    }).then(res => {
      let d = res.data;
      return {
        total: d.total,
        baruditambahkan: d.baruditambahkan,
        ratingtertinggi: d.ratingtertinggi,
        aktivitas: d.aktivitas
      };
    });
  },
  data() {
    return {
      chatpayload: [],
      total: 0,
      baruditambahkan: [
        { id: "", avatar: "", judul: "55", user: "123" },
        { id: "", avatar: "", judul: "55", user: "123" },
        { id: "", avatar: "", judul: "55", user: "123" },
        { id: "", avatar: "", judul: "55", user: "123" },
        { id: "", avatar: "", judul: "55", user: "123" }
      ],
      ratingtertinggi: [
        { username: "lorem", avatar: "", rating: 80, ranking: "No Ranking" },
        { username: "lorem", avatar: "", rating: 80, ranking: "No Ranking" },
        { username: "lorem", avatar: "", rating: 80, ranking: "No Ranking" },
        { username: "lorem", avatar: "", rating: 80, ranking: "No Ranking" },
        { username: "lorem", avatar: "", rating: 80, ranking: "No Ranking" }
      ],
      aktivitas: [
        { username: "testing", deskripsi: "choco cornet" },
        { username: "testing", deskripsi: "choco cornet" },
        { username: "testing", deskripsi: "choco cornet" },
        { username: "testing", deskripsi: "choco cornet" },
        { username: "testing", deskripsi: "choco cornet" }
      ]
    };
  },
  beforeMount() {},
  methods: {
    moveHandler(path) {
      this.$router.push({ path: path });
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
    }
  },
  mounted() {
    console.log(this.$store.state.debug);
    console.log(this.$store.state.isLogged);
  }
};
</script>

<style>
.underline:hover {
  text-decoration: underline;
}

div {
  cursor: default;
}

a {
  color: inherit;
  text-decoration: none;
}

.btnDaftar {
  padding: 5px;
  background-color: #0067ba;
  cursor: pointer;
}

.btnDaftar:hover {
  background-color: #004786;
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

@media screen and (max-width: 991px) {
  #sloganHeader {
    background: url("https://cdn.projects.co.id/assets/custom/work-at-home.png");
    background-repeat: round;
  }
  #gambarHeader {
    display: none;
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
