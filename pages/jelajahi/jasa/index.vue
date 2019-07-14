<template>
    <div class="halamanPencarianJasa" style="background-color:#f2f2f2;overflow-x:hidden">
        <Header/>
                    <div class="container-fluid" style="padding:0px;margin-top:10px;margin-bottom:10px;">
              <div class="container" style="padding-left:5px">
                    <div class="row" style="padding:10px;padding-right:13px">

                        <sideNav/>

                        <div class="col-lg-8 col-md-12 col-md-12" style="padding-right:2px;">
                          <div id="loadingScreen" style="display:none;position:absolute;background-color:#eaeaea6b;width:100%;height:100%"></div>
                                <div style="font-size:28px;padding:10px;border-bottom:solid 1px;padding-left:0px;padding-bottom:5px;">Jelajahi Jasa</div>
                          <div v-if="contentIsLoaded" style="padding-top:5px;padding-bottom:5px;border-bottom:solid 1px;display:flex;flex-direction:row;justify-content:space-between">
                              <div style="padding:5px"><button class="tmblBiru fadeEffect" style="padding:5px;">Buat Jasa</button></div>
                              <div style="display:flex;flex-direction:row;padding:5px">
                                <div id="toKiri" style="background-color:#006bc2;color:white;padding:5px;margin-right:4px"><<</div>
                                <div class="parentPagination" style="display:flex;flex-direction:row;width:184px;"> 
                                  <div v-for="i in this.pagination.totalhalaman" v-bind:key="i" :class="`numberPagination ${(i===1) ? 'checked':''}`" style="padding:5px;">{{i}}</div>
                                </div>
                                <div id="toKanan" style="background-color:#006bc2;padding:5px;margin-left:0px;color:white">>></div>
                              </div>
                          </div>

                             <div v-else style="padding-top:5px;padding-bottom:7px;border-bottom:solid 1px;display:flex;flex-direction:row;justify-content:space-between">
                              <div style="padding:5px"><button class="tmblBiru fadeEffect placeholder" style="padding:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default">Buat Jasa</button></div>
                              <div style="display:flex;flex-direction:row;padding:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default;height:30px;margin-top:4px;" class="placeholder">
                                <div class="parentPagination" style="display:flex;flex-direction:row;width:184px"> 
                                  
                                </div>
                              </div>
                          </div>
                              


                          <div  v-if="contentIsLoaded" id="isiKonten" style="padding-bottom:35px;">
                            <div v-for="(val,i) in this.data" v-bind:key="i" style="margin-top:10px;border-bottom:solid 1px;padding-bottom:20px;">
                                <div style="display:flex;flex-direction:row;justify-content:flex-end;margin-top:10px">
                                  
                                    <div v-on:click="tanyaPadaPeminta($event,val.pemostingjasa.nama)" style="margin-left:5px;"><button class="tmblBiru fadeEffect" style="padding:5px;">Chat Dengan Penjasa</button></div>
                                    <div style="margin-left:5px;"><button v-on:click="detailHandler(val.id,i)" class="tmblBiru fadeEffect" style="padding:5px">Lihat</button></div>
                                </div>
                    
                                <div>
                                   <div style="font-size:25px;margin-bottom:10px;overflow-x:hidden;text-overflow:ellipsis" class="underlined" v-on:click="detailHandler(val.id,i)">{{val.judul}}</div>
                                </div>

                                <div style="margin-top:2px;display:flex;flex-direction:row;justify-content:space-between">
                                  <div style="display:flex;flex-direction:column" class="list-component-one">
                                    <div style="display:flex;flex-direction:row;">
                                      <div style="margin-right:25px;">
                                        <div><b style="margin-right:4px;">Rating Pemosting Jasa:</b><span><nuxt-link to="">{{val.pemostingjasa.nama}}</nuxt-link></span></div>
                                        <div style="display:flex;flex-direction:row;margin-top:4px;" v-html="ratingHandler(val.rating)"></div>
                                        <div style="margin-top:4px;">{{val.rating}}/100</div>
                                      </div>
                                       <div style="font-size:17px;margin-right:25px"><b>Rp {{formatrupiah(parseInt(val.harga))}}</b><div style="font-size:14px">Waktu pengerjaan : {{val.waktupengerjaan}} Hari</div></div>
                                     </div>  

                                    <div style="margin-top:5px;word-break:break-word" class="list-component-two" >{{penggal(val.deskripsi)}}</div>

                                  </div>
                                        
                                  <div style="height:240px;width:100%;border:solid 1px "><img style="width:100%;height:100%" :src="val.gambar"></div>
                                </div>

                            </div>
                          </div>

                    
                        <div v-else id="isiKonten">
                              <div style="border-bottom:solid 1px;padding-bottom:35px;border-bottom:solid 1px">
                            <div style="margin-top:10px;">
                                <div style="display:flex;flex-direction:row;justify-content:flex-end">
                                    <div style="margin-left:5px;background-color:#e4e4e4;color:#e4e4e4;width:130px;" class="placeholder"></div>
                                    <div style="margin-left:5px;background-color:#e4e4e4;color:#e4e4e4;height:28px;width:35px;" class="placeholder"></div>
                                </div>
                    
                                <div>
                                   <div class="placeholder" style="font-size:25px;margin-bottom:10px;overflow-x:hidden;text-overflow:ellipsis;background-color:#e4e4e4;color:#e4e4e4;height:30px;margin-top:10px;width:62%"></div>
                                </div>

                                <div style="margin-top:2px;display:flex;flex-direction:row;justify-content:space-between">
                                  <div style="display:flex;flex-direction:column" class="list-component-one">
                                    <div style="display:flex;flex-direction:row;">
                                      <div style="margin-right:25px;">
                                        <div><b style="margin-right:4px;background-color:#e4e4e4;color:#e4e4e4;" class="placeholder">Rating Pemosting Jasa:</b><span><nuxt-link style=";background-color:#e4e4e4;color:#e4e4e4;" class="placeholder" to="">yudha.code</nuxt-link></span></div>
                                        <div style="display:flex;flex-direction:row;margin-top:4px;background-color:#e4e4e4;color:#e4e4e4;width:100px;height:15px" class="placeholder"></div>
                                        <div style="margin-top:4px;background-color:#e4e4e4;color:#e4e4e4;height:15px" class="placeholder">100/100</div>
                                      </div>
                                       <div style="font-size:17px;margin-right:25px"><b style=";background-color:#e4e4e4;color:#e4e4e4;" class="placeholder">Rp 2.000.000</b><div style="font-size:14px;background-color:#e4e4e4;color:#e4e4e4;margin-top:4px" class="placeholder">Waktu pengerjaan : {} Hari</div></div>
                                     </div>  

                                    <div style="margin-top:7px;word-break:break-word;background-color:#e4e4e4;color:#e4e4e4;height:170px;" class="list-component-two placeholder" ></div>

                                  </div>
                                        
                                  <div style="height:240px;width:100%;border:solid 1px;background-color:#e4e4e4;color:#e4e4e4;height:243px;" class="placeholder"></div>
                                </div>

                            </div>


                            

                             </div>

                              <div style="border-bottom:solid 1px;padding-bottom:35px;border-bottom:solid 1px">
                            <div style="margin-top:10px;">
                                <div style="display:flex;flex-direction:row;justify-content:flex-end">
                                    <div style="margin-left:5px;background-color:#e4e4e4;color:#e4e4e4;width:130px;" class="placeholder"></div>
                                    <div style="margin-left:5px;background-color:#e4e4e4;color:#e4e4e4;height:28px;width:35px;" class="placeholder"></div>
                                </div>
                    
                                <div>
                                   <div class="placeholder" style="font-size:25px;margin-bottom:10px;overflow-x:hidden;text-overflow:ellipsis;background-color:#e4e4e4;color:#e4e4e4;height:30px;margin-top:10px;width:62%"></div>
                                </div>

                                <div style="margin-top:2px;display:flex;flex-direction:row;justify-content:space-between">
                                  <div style="display:flex;flex-direction:column" class="list-component-one">
                                    <div style="display:flex;flex-direction:row;">
                                      <div style="margin-right:25px;">
                                        <div><b style="margin-right:4px;background-color:#e4e4e4;color:#e4e4e4;" class="placeholder">Rating Pemosting Jasa:</b><span><nuxt-link style=";background-color:#e4e4e4;color:#e4e4e4;" class="placeholder" to="">yudha.code</nuxt-link></span></div>
                                        <div style="display:flex;flex-direction:row;margin-top:4px;background-color:#e4e4e4;color:#e4e4e4;width:100px;height:20px" class="placeholder"></div>
                                        <div style="margin-top:4px;background-color:#e4e4e4;color:#e4e4e4;" class="placeholder">100/100</div>
                                      </div>
                                       <div style="font-size:17px;margin-right:25px"><b style=";background-color:#e4e4e4;color:#e4e4e4;" class="placeholder">Rp 2.000.000</b><div style="font-size:14px;background-color:#e4e4e4;color:#e4e4e4;margin-top:4px" class="placeholder">Waktu pengerjaan : {} Hari</div></div>
                                     </div>  

                                    <div style="margin-top:7px;word-break:break-word;background-color:#e4e4e4;color:#e4e4e4;height:170px;" class="list-component-two placeholder" ></div>

                                  </div>
                                        
                                  <div style="height:240px;width:100%;border:solid 1px;background-color:#e4e4e4;color:#e4e4e4;height:243px;" class="placeholder"></div>
                                </div>

                            </div>


                            

                      </div>
                            

                             <div style="border-bottom:solid 1px;padding-bottom:35px;border-bottom:solid 1px">
                            <div style="margin-top:10px;">
                                <div style="display:flex;flex-direction:row;justify-content:flex-end">
                                    <div style="margin-left:5px;background-color:#e4e4e4;color:#e4e4e4;width:130px;" class="placeholder"></div>
                                    <div style="margin-left:5px;background-color:#e4e4e4;color:#e4e4e4;height:28px;width:35px;" class="placeholder"></div>
                                </div>
                    
                                <div>
                                   <div class="placeholder" style="font-size:25px;margin-bottom:10px;overflow-x:hidden;text-overflow:ellipsis;background-color:#e4e4e4;color:#e4e4e4;height:30px;margin-top:10px;width:62%"></div>
                                </div>

                                <div style="margin-top:2px;display:flex;flex-direction:row;justify-content:space-between">
                                  <div style="display:flex;flex-direction:column" class="list-component-one">
                                    <div style="display:flex;flex-direction:row;">
                                      <div style="margin-right:25px;">
                                        <div><b style="margin-right:4px;background-color:#e4e4e4;color:#e4e4e4;" class="placeholder">Rating Pemosting Jasa:</b><span><nuxt-link style=";background-color:#e4e4e4;color:#e4e4e4;" class="placeholder" to="">yudha.code</nuxt-link></span></div>
                                        <div style="display:flex;flex-direction:row;margin-top:4px;background-color:#e4e4e4;color:#e4e4e4;width:100px;height:20px" class="placeholder"></div>
                                        <div style="margin-top:4px;background-color:#e4e4e4;color:#e4e4e4;" class="placeholder">100/100</div>
                                      </div>
                                       <div style="font-size:17px;margin-right:25px"><b style=";background-color:#e4e4e4;color:#e4e4e4;" class="placeholder">Rp 2.000.000</b><div style="font-size:14px;background-color:#e4e4e4;color:#e4e4e4;margin-top:4px" class="placeholder">Waktu pengerjaan : {} Hari</div></div>
                                     </div>  

                                    <div style="margin-top:7px;word-break:break-word;background-color:#e4e4e4;color:#e4e4e4;height:170px;" class="list-component-two placeholder" ></div>

                                  </div>
                                        
                                  <div style="height:240px;width:100%;border:solid 1px;background-color:#e4e4e4;color:#e4e4e4;height:243px;" class="placeholder"></div>
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
import axios from "axios";
import ContainerChat from "@/components/ContainerChat";
import Header from "@/components/Header";
import Footer from "@/components/Footer";
import sideNav from "@/components/sideNav";

export default {
  components: {
    ContainerChat,
    Header,
    Footer,
    sideNav
  },
  data() {
    return {
      chatpayload: [],
      debug: "",
      pagination: {
        offset: 0,
        limit: 25,
        totalhalaman: 1
      },
      data: [
        {
          judul: "aaaaa",
          pemostingjasa: {
            id: 11,
            nama: "yudha.code"
          },
          rating: 100,
          harga: 1000000,
          waktupengerjaan: 111,
          deskripsi: `>> Tahun 2019 pingin ganti cara promosi yang lebih kekinian? Bingung mau promosi #pakeAnimasiAja. Saatnya anda mengubah cara promosi konvensional menuju Modern dengan Video Explainer 2D. Kami adalah Epic Anima, tim berbasis di Malang yang fokus pada pembuatan video animasi premium dan sudah dipercaya lebih dari 100 client lokal maupun internasional. Portofolio terbaru kami : Youtube : https://www.youtube.com/channel/UCg7BRgVGWnMFV_B8S7ZNIfg/videos Instagram : https://www.instagram >> Tahun 2019 pingin ganti cara promosi yang lebih kekinian? Bingung mau promosi #pakeAnimasiAja. Saatnya anda mengubah cara promosi konvensional menuju Modern dengan Video Explainer 2D. Kami adalah Epic Anima, tim berbasis di Malang yang fokus pada pembuatan video animasi premium dan sudah dipercaya lebih dari 100 client lokal maupun internasional. Portofolio terbaru kami : Youtube : https://www.youtube.com/channel/UCg7BRgVGWnMFV_B8S7ZNIfg/videos Instagram : https://www.instagram`,
          gambar:
            "https://cdn.projects.co.id/upload/usre70413/201901145c3be815692d4.jpg"
        },
        {
          judul: "aaaaa",
          pemostingjasa: {
            id: 11,
            nama: "yudha.code"
          },
          rating: 100,
          harga: 500000,
          waktupengerjaan: 111,
          deskripsi: `>> Tahun 2019 pingin ganti cara promosi yang lebih kekinian? Bingung mau promosi #pakeAnimasiAja. Saatnya anda mengubah cara promosi konvensional menuju Modern dengan Video Explainer 2D. Kami adalah Epic Anima, tim berbasis di Malang yang fokus pada pembuatan video animasi premium dan sudah dipercaya lebih dari 100 client lokal maupun internasional. Portofolio terbaru kami : Youtube : https://www.youtube.com/channel/UCg7BRgVGWnMFV_B8S7ZNIfg/videos Instagram : https://www.instagram >> Tahun 2019 pingin ganti cara promosi yang lebih kekinian? Bingung mau promosi #pakeAnimasiAja. Saatnya anda mengubah cara promosi konvensional menuju Modern dengan Video Explainer 2D. Kami adalah Epic Anima, tim berbasis di Malang yang fokus pada pembuatan video animasi premium dan sudah dipercaya lebih dari 100 client lokal maupun internasional. Portofolio terbaru kami : Youtube : https://www.youtube.com/channel/UCg7BRgVGWnMFV_B8S7ZNIfg/videos Instagram : https://www.instagram`,
          gambar:
            "https://cdn.projects.co.id/upload/usre70413/201901145c3be815692d4.jpg"
        },
        {
          judul: "aaaaa",
          pemostingjasa: {
            id: 11,
            nama: "yudha.code"
          },
          rating: 100,
          harga: 500000,
          waktupengerjaan: 111,
          deskripsi: `>> Tahun 2019 pingin ganti cara promosi yang lebih kekinian? Bingung mau promosi #pakeAnimasiAja. Saatnya anda mengubah cara promosi konvensional menuju Modern dengan Video Explainer 2D. Kami adalah Epic Anima, tim berbasis di Malang yang fokus pada pembuatan video animasi premium dan sudah dipercaya lebih dari 100 client lokal maupun internasional. Portofolio terbaru kami : Youtube : https://www.youtube.com/channel/UCg7BRgVGWnMFV_B8S7ZNIfg/videos Instagram : https://www.instagram >> Tahun 2019 pingin ganti cara promosi yang lebih kekinian? Bingung mau promosi #pakeAnimasiAja. Saatnya anda mengubah cara promosi konvensional menuju Modern dengan Video Explainer 2D. Kami adalah Epic Anima, tim berbasis di Malang yang fokus pada pembuatan video animasi premium dan sudah dipercaya lebih dari 100 client lokal maupun internasional. Portofolio terbaru kami : Youtube : https://www.youtube.com/channel/UCg7BRgVGWnMFV_B8S7ZNIfg/videos Instagram : https://www.instagram`,
          gambar:
            "https://cdn.projects.co.id/upload/usre70413/201901145c3be815692d4.jpg"
        }
      ],
      contentIsLoaded: false
    };
  },
  watchQuery: ["kategori", "halaman"],
  asyncData(context) {
    if (context.route.query.kategori) {
      return axios({
        url: "https://penerjemah.web.id/api/global_.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params={"aksi":"memuatkontenjasa-withcategory","limit":"25","offset":"0","kategori":"${
          context.route.query.kategori
        }"}`
      }).then(res1 => {
        return axios({
          url: "https://penerjemah.web.id/api/global_.php",
          method: "POST",
          headers: { "content-type": "application/x-www-form-urlencoded" },
          data: `params={"aksi":"memuattotalkontenjasa-withcategory","kategori":"${
            context.route.query.kategori
          }"}`
        }).then(res2 => {
          let data = res2.data;
          let a = parseInt(data.data.total) / 25;
          a = a.toString();
          if (a.match(".")) {
            a = Math.floor(a) + 1;
          } else {
            a = ParseInt(a);
          }

          return {
            debug: res2.data,
            contentIsLoaded: true,
            data: res1.data,
            pagination: {
              totalhalaman: a,
              offset: 0,
              limit: 25
            }
          };
        });
      });
    }

    let limit = 25;
    let offset = 0;

    if (context.route.query.halaman) {
      limit = 25 * context.route.query.halaman;
      offset = 25 * (context.route.query.halaman - 1);
    }

    return axios({
      url: "https://penerjemah.web.id/api/global.php",
      method: "POST",
      headers: { "content-type": "application/x-www-form-urlencoded" },
      data: `params={"aksi":"memuatkontenjasa","limit":"${limit}","offset":"${offset}"}`
    }).then(res1 => {
      return axios({
        url: "https://penerjemah.web.id/api/global.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params={"aksi":"memuattotalkontenjasa"}`
      }).then(res2 => {
        let data = res1.data;
        let a = data.total / 25;
        a = a.toString();
        if (a.match(".")) {
          var totalh = Math.floor(a) + 1;
        } else {
          var totalh = ParseInt(a);
        }

        return {
          contentIsLoaded: true,
          data: data,
          pagination: {
            offset: 0,
            limit: 25,
            totalhalaman: 1
          }
        };
      });
    });
  },
  mounted() {
    //alert(this.$store.state.isLogged);
    console.log(this.debug);
    let initialScroll = 0;

    function clearPagination() {
      document.querySelectorAll(".numberPagination").forEach(el => {
        el.classList.remove("checked");
      });
    }

    $(document).on("click", ".numberPagination", e => {
      if (!e.currentTarget.classList.contains("checked")) {
        clearPagination();
        e.currentTarget.classList.add("checked");
        document.querySelectorAll("#loadingScreen")[0].style.display = "";
        setTimeout(() => {
          document.querySelectorAll("#loadingScreen")[0].style.display = "none";
        }, 1000);
      }
    });

    $(document).on("click", "#toKiri", () => {
      if (initialScroll <= 0) {
        initialScroll = 0;
      } else {
        initialScroll = initialScroll - 100;
      }

      document.querySelectorAll(".parentPagination")[0].scrollTo({
        left: initialScroll,
        behavior: "smooth"
      });
    });

    $(document).on("click", "#toKanan", () => {
      if (
        initialScroll >=
        document.querySelectorAll(".parentPagination")[0].scrollWidth
      ) {
        initialScroll = document.querySelectorAll(".parentPagination")[0]
          .scrollWidth;
      } else {
        initialScroll = initialScroll + 100;
      }

      document.querySelectorAll(".parentPagination")[0].scrollTo({
        left: initialScroll,
        behavior: "smooth"
      });
    });
  },
  methods: {
    tanyaPadaPeminta: function(e, username) {
      if (username !== this.$store.state.login.username) {
        e.target.disabled = true;
        axios
          .get(
            `https://idpenerjemahsocket.herokuapp.com/cekOnline?username=${username}`
          )
          .then(res => {
            if (res.data.status === "online") {
              let ketemu = false;
              this.chatpayload.map(res => {
                if (res.id === username) {
                  ketemu = true;
                }
              });

              if (ketemu !== true) {
                this.chatpayload.push({
                  id: username,
                  isichat: []
                });
              }
              e.target.disabled = false;
            } else {
              alert("User tidak online!");
              e.target.disabled = false;
            }
          });
      }
    },
    detailHandler: function(id, togel) {
      this.$router.push({ path: `/detail/jasa/${id}` });
    },
    formatrupiah: function(angka) {
      var rupiah = "";
      var angkarev = angka
        .toString()
        .split("")
        .reverse()
        .join("");
      for (var i = 0; i < angkarev.length; i++)
        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ".";
      return rupiah
        .split("", rupiah.length - 1)
        .reverse()
        .join("");
    },
    penggal: function(str) {
      let retVal = "";
      let match = str.match(/<[^\>]+>([^<]+)<[^>]+>/gm);
      if (match) {
        str = match
          .map(function(item) {
            return /<[^\>]+>([^<]+)<[^>]+>/.exec(item)[1];
          })
          .join(" ");
      } else {
        str = str;
      }
      if (str.length > 550) {
        str.match(/\S+/g).forEach(val => {
          if (retVal.length < 550) {
            retVal = retVal + " " + val;
          } else {
            retVal = retVal;
          }
        });
        return retVal + "...";
      } else {
        return str;
      }
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
  }
};
</script>


<style scoped>
.list-component-one {
  width: 1450px;
}
.list-component-two {
  width: 450px;
}

@media screen and (max-width: 1200px) {
  .list-component-one {
    width: 930px;
  }
  .list-component-two {
    width: 340px;
  }
}

@media screen and (max-width: 992px) {
  .list-component-one {
    width: 1230px;
  }
  .list-component-two {
    width: 400px;
  }
}

@media screen and (max-width: 768px) {
  .list-component-one {
    width: 540px;
  }
  .list-component-two {
    width: 220px;
  }
}

div {
  cursor: default;
}

.listSidebar {
}

@keyframes placeholder_animation {
  0% {
    opacity: 0.5;
  }
  50% {
    opacity: 1;
  }
  100% {
    opacity: 0.5;
  }
}

.placeholder {
  pointer-events: none;
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
  animation-name: placeholder_animation;
  animation-duration: 1s;
  animation-iteration-count: infinite;
}

.parentPagination {
  overflow: scroll;
  margin-right: 2px;
}

.parentPagination::-webkit-scrollbar {
  display: none;
}

.numberPagination {
  cursor: pointer;
  border: solid 1px #006bc2;
  margin-right: 2px;
}

.numberPagination:hover {
  border: solid 1px #006bc2;
  background-color: #006bc21c;
}

.checked {
  border: solid 1px #006bc2;
  background-color: #006bc21c;
}

.tmblBiru {
  color: white;
  background-color: rgb(0, 107, 194);
  padding: 2px;
  outline: none;
  border: 0px;
}

.underlined:hover {
  cursor: pointer;
  text-decoration: underline;
}

.block-ellipsis {
  display: block;
  display: -webkit-box;
  max-width: 100%;
  height: 43px;
  margin: 0 auto;
  font-size: 14px;
  line-height: 1;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
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

.halamanPencarianJasa {
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
