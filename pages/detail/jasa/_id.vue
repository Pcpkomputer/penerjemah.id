<template>
<div id="halamanDetailJasa" style="overflow-x:hidden">
     <Header/>
      <div class="container-fluid" style="padding:0px;margin-top:10px;margin-bottom:10px;">
              <div class="container" style="padding-left:5px">
                    <div class="row" style="padding:10px;padding-right:13px">
                            <sideNav/>
                            <div class="col-lg-8 col-md-12 col-md-12" style="padding-right:2px;">

                              <div  v-if="this.editable" style="padding-right:15px;margin-top:12px;position:absolute;width:100%;height:100%;background-color:red;z-index:98;background-color:rgba(242, 242, 242, 0.82);">
                                    <div style="width:100%;display:flex;flex-direction:column">
                                          <div style="width:100%"><input style="width:100%;padding-left:5px" v-model="editablethread.judul" type="text"></div>
                                          <div style="width:100%;margin-top:5px"><textarea style="width:100%;height:200px;resize:none" v-model="editablethread.deskripsi"></textarea></div>
                                           <div style="display:flex;flex-direction:row;margin-top:5px;margin-bottom:5px">
                                                  <div style="display:flex;flex-direction:row;width:150px;overflow-x:scroll">
                                                      <div v-for="(x,i) in editablethread.tags" v-on:click="popLabel(i)" v-bind:key="i" style="cursor:pointer;background-color:#30566ba6;padding:2px;margin-right:5px;border-radius:3px;color:white">{{x}}</div>
                                                  </div>

                                                  <div style="margin-left:10px;">
                                                      <div><input id="inputLabel" style="width:100px" type="text"></div>
                                                  </div>

                                                  <div style="margin-left:10px">
                                                      <div class="tmblBiru fadeEffect" v-on:click="inputLabel()" style="cursor:pointer;padding-left:5px;padding-right:5px;">Masukkan Label</div>
                                                  </div>
                                          </div>
                                          <div style="display:flex;flex-direction:row;margin-top:5px" >
                                              <button v-on:click="ubahHandler($event)" style="cursor:pointer;margin-right:10px;padding:5px;" class="tmblBiru fadeEffect">Ubah</button>
                                              <div v-on:click="()=>{this.editable=false}" style="cursor:pointer;margin-right:10px;padding:5px;" class="tmblBiru fadeEffect">Batal</div>
                                          </div>
                                    </div>
                                  </div>

                                 <div style="font-size:28px;padding:10px;padding-right:0px;border-bottom:solid 1px;padding-left:0px;padding-bottom:5px;display:flex;flex-direction:row;justify-content:space-between"><div>{{data.thread.judul}}</div>
                                 <div v-if="this.$store.state.login.username===this.data.user.username" style="display:flex;flex-direction:row">
                                  <div v-on:click="()=>{this.editable=true;}" style="cursor:pointer;margin-left:10px;background-color:#cacaca; font-size:20px;padding-left:25px;padding-right:25px;display:flex;align-items:center;border-radius:5px;color:white">Edit</div>
                                  <div v-on:click="hapusHandler();" style="cursor:pointer;margin-left:10px;background-color:#cacaca; font-size:20px;padding-left:25px;padding-right:25px;display:flex;align-items:center;border-radius:5px;color:white">Hapus</div>
                                  </div>
                                 </div>
                                <div class="row" style="margin-top:20px;">    
                                    <div class="col-lg-8" style="margin-bottom:20px;">
                                      <div v-html="this.data.thread.deskripsi"></div>
                                      <div style="margin-top:25px;display:flex;flex-wrap:wrap">
                                          <div v-for="(val,i) in this.data.thread.tags" v-bind:key="i" style="margin-right:10px;margin-bottom:10px;padding:5px;cursor:pointer" class="noselect tmblBiru fadeEffect">{{val}}</div>
                                         
                                      </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div v-on:click="tanyaPadaPeminta($event,data.user.username)" v-if="this.$store.state.login.username!==this.data.user.username">
                                            <div class="tmblDeal">
                                                <div style="font-size:20px;font-weight:500;color:white">Rp. {{formatrupiah(this.data.thread.harga)}}</div>
                                                <div style="font-size:13px;font-weight:400;color:white">Hubungi Penjasa & Sepakat</div>
                                            </div>
                                        </div>

                                           <div v-if="this.$store.state.login.username===this.data.user.username">
                                            <div v-on:click="()=>{this.editable=true;}" class="tmblDeal">
                                                <div  style="font-size:20px;font-weight:500;color:white">Ubah Data</div>
                                            
                                            </div>
                                        </div>

                                        <div style="margin-top:25px;">
                                            <div style="height:220px;border:solid 1px">
                                               <img :src="this.data.thread.background" style="width:100%;height:100%">
                                            </div>
                                        </div>

                                        <div style="margin-bottom:15px;display:flex;flex-direction:row;justify-content:space-around;margin-top:25px">
                                           <div style="width:100px;height:70px;border:1px solid">
                                              <img style="width:100%;height:100%" :src="`https://penerjemah.web.id/assets/avatar/${this.data.user.avatar}`">
                                           </div>
                                           <div style="margin-left:15px;width:100%;display:flex;flex-direction:column">
                                              <div>{{this.data.user.username}}</div>
                  
                                              <div v-html="ratingHandler(this.data.user.rating)"></div>
                                              <div>{{this.data.user.rating}}/100</div>

                                           </div>
                                        </div>

                                       
                                    </div>

                                    
                                </div>

                                 <div class="row">
                                                <div class="col-lg-8">
                                                    <div style="font-weight: 300;font-size:21px;padding:0px;border-bottom: solid 1px;padding-bottom:5px">Komentar</div>
                                                    <div v-if="this.komentar.length===0" class="mt-2" style="height:150px;display:flex;justify-content:center;align-items: center;">Tidak ada komentar...</div>
                                                    <div style="margin-bottom:30px" if="this.komentar.length>0">
                                                        <div v-for="(val,i) in this.komentar" :key="i" style="display:flex;flex-direction:row;border-bottom:solid 1px;padding-bottom:24px;padding-top:20px">
                                                          <img :src="`https://penerjemah.web.id/assets/avatar/${val.gambar}`" style="width:70px;height:70px;border:solid 1px">
                                                          <div style="flex-direction:column">
                                                            <div style="margin-left:10px"><nuxt-link to="/">{{val.username}}</nuxt-link></div>
                                                            <div style="margin-left:10px">{{val.komentar}}</div>
                                                          </div>
                                                        </div>
                                                        <div v-if="this.$store.state.isLogged">
                                                        <div style="width:100%;margin-top:20px;height:100px"><textarea id="sandboxKomentar" style="width:100%;height:100%;resize:none"></textarea></div>
                                                        <div style="display:flex;margin-top:10px;cursor:pointer"><button v-on:click="kirimKomentar($event)" class="tmblBiru fadeEffect" style="padding:5px">Kirim</button></div>
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
import Footer from "@/components/Footer";
import Header from "@/components/Header";
import sideNav from "@/components/sideNav";
export default {
  components: {
    ContainerChat,
    Footer,
    Header,
    sideNav
  },
  asyncData(context) {
    return axios({
      method: "POST",
      url: "https://penerjemah.web.id/api/global.php",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      data: `params={"aksi":"memuatkomentarjasa","id":"${context.params.id}"}`
    })
      .then(res => {
        return axios({
          method: "POST",
          url: "https://penerjemah.web.id/api/global.php",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          data: `params={"aksi":"memuatkontenjasa","id":"${context.params.id}"}`
        }).then(res1 => {
          return {
            komentar: res.data,
            data: res1.data
          };
        });
      })
      .catch(err => {
        context.redirect(302, "/");
      });
  },
  validate({ params }) {
    return /(\d+)/.test(params.id);
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
    kirimKomentar: function(e) {
      let komentar = document.querySelectorAll("#sandboxKomentar")[0].value;
      if (komentar.length > 0) {
        e.target.disabled = true;
        axios({
          url: "https://penerjemah.web.id/api/insert.php",
          method: "POST",
          headers: { "content-type": "application/x-www-form-urlencoded" },
          data: `params=${JSON.stringify({
            aksi: "kirimKomentar",
            credentials: this.$store.state.login,
            id: this.$route.params.id,
            bearer: {
              komentar: komentar
            }
          })}`
        }).then(res => {
          console.log(res);
          if (res.data.status === "success") {
            alert("Komentar berhasil ditambahkan!");
            document.location.reload();
          }
        });
      }
    },
    badgeMapping: function(status) {
      if (status === "published") {
        return `<div style="background-color:#58a745;padding-left:5px;border-radius:5px;padding-right:5px;padding-top:1px;padding-bottom:1px;color:white;font-size:10px">Published</div>`;
      } else if (status === "in progress") {
        return `<div style="background-color:rgb(204, 150, 68);padding-left:5px;border-radius:5px;padding-right:5px;padding-top:1px;padding-bottom:1px;color:white;font-size:10px">In Progress</div>`;
      } else if (status === "waiting payment") {
        return `<div style="background-color:rgb(115, 115, 115);padding-left:5px;border-radius:5px;padding-right:5px;padding-top:1px;padding-bottom:1px;color:white;font-size:10px">Waiting Payment</div>`;
      } else if (status === "finished") {
        return `<div style="background-color:rgb(42, 40, 130);padding-left:5px;border-radius:5px;padding-right:5px;padding-top:1px;padding-bottom:1px;color:white;font-size:10px">Finished</div>`;
      }
    },
    hapusHandler: function() {
      axios({
        url: "https://penerjemah.web.id/api/delete.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params=${JSON.stringify({
          aksi: "deleteDetailJasa",
          credentials: this.$store.state.login,
          id: this.$route.params.id
        })}`
      }).then(res => {
        if (res.data.status === "success") {
          alert("Berhasil dihapus!");
          this.$router.push({ path: "/jelajahi/jasa" });
        } else {
          alert("Terjadi kesalahan!");
        }
      });
    },
    ubahHandler: function(e) {
      e.target.disabled = true;
      let deskripsi = "";
      if (this.editablethread.deskripsi.length === 0) {
        deskripsi = "";
      } else {
        deskripsi = this.editablethread.deskripsi
          .match(/^(.+|\s+)/gm)
          .map(
            res =>
              res.match(/\w+/)
                ? `<p style="margin-bottom:0px;">${res}</p>`
                : `<br>`
          )
          .join("");
      }

      axios({
        url: "https://penerjemah.web.id/api/update.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params=${JSON.stringify({
          aksi: "updateDetailJasa",
          credentials: this.$store.state.login,
          id: this.$route.params.id,
          bearer: {
            judul: this.editablethread.judul,
            deskripsi: deskripsi,
            label: this.editablethread.tags.join(",")
          }
        })}`
      }).then(res => {
        //alert(res.data);
        if (res.data.status === "success") {
          document.location.reload();
        } else {
          e.target.disabled = false;
          alert("Terjadi kesalahan!");
        }
      });
    },
    inputLabel: function() {
      let val = document.querySelectorAll("#inputLabel")[0].value;
      if (val.length > 0) {
        let p = this.editablethread.tags;
        p.push(val);
        this.editablethread.tags = p;
      }
    },
    popLabel: function(i) {
      let arr = this.editablethread.tags;
      let x = arr.filter((res, y) => {
        return y !== i;
      });
      this.editablethread.tags = x;
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
    perHandler: function(kategori) {
      if (kategori === "Penerjemah") {
        return "Lembar";
      } else {
        return "Null";
      }
    }
  },
  data() {
    return {
      chatpayload: [],
      editable: false,
      komentar: [],
      data: {
        user: {
          avatar: "",
          username: "",
          rating: 0,
          point: 0,
          ranking: ""
        },
        thread: {
          id: null,
          judul: "",
          deskripsi: "",
          tags: [],
          tgldibuat: "",
          harga: "",
          jangkawaktu: "",
          background: ""
        }
      },
      editablethread: {
        judul: "",
        deskripsi: "",
        tags: []
      }
    };
  },
  mounted() {
    this.editablethread.judul = this.data.thread.judul;
    let desk = this.data.thread.deskripsi.replace(
      /<[^>]+>([^<]+)<[^>]+>/gm,
      `$1\n`
    );
    desk = desk.replace(/<br>/gm, "\n");
    this.editablethread.deskripsi = desk;
    this.editablethread.tags = this.data.thread.tags;
    //console.log(this.komentar);
    //console.log(this.debug);
    //if (this.$store.state.detailjasa.data.thread.id !== null) {
    //  this.data.user = this.$store.state.detailjasa.data.user;
    //  this.data.thread = this.$store.state.detailjasa.data.thread;
    //}
    //console.log(this.data.user);
  }
};
</script>

<style scoped>
#halamanDetailJasa {
  font-size: 12px;
  background-color: #f2f2f2;
}

.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}

.tmblBiru {
  color: white;
  background-color: rgb(0, 107, 194);
  padding: 2px;
  outline: none;
  border: 0px;
}

.fadeEffect {
  opacity: 1;
  transition: opacity 0.5s;
}

.tmblDeal {
  background-color: rgb(0, 102, 185);
  padding: 10px;
  border-radius: 5px;
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
  cursor: pointer;
}

.tmblDeal:hover {
  background-color: rgb(0, 87, 158);
  padding: 10px;
  border-radius: 5px;
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
}

.fadeEffect:hover {
  opacity: 0.5;
}
</style>