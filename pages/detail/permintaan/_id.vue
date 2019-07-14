<template>
<div id="halamanDetailPermintaan" style="overflow-x:hidden">
    <Header/>
        <div class="container-fluid" style="padding:0px;margin-top:10px;margin-bottom:10px;">
              <div class="container" style="padding-left:5px">
                    <div class="row" style="padding:10px;padding-right:13px">
                            <sideNav/>
                            <div class="col-lg-8 col-md-12 col-md-12" style="padding-right:2px;">
                                  <div v-if="this.penerimaan" style="padding-right:15px;margin-top:12px;position:absolute;width:100%;height:100%;background-color:red;z-index:98;background-color:rgba(242, 242, 242, 0.82);">
                                    <div style="width:100%;margin-top:5px"><textarea id="keterangan" style="width:100%;height:200px;resize:none" placeholder="Penjelasan"></textarea></div>
                                    <div style="margin-top:7px">Lampiran File (docx,doc,pdf): <input id="inputproses" v-on:change="fileHandler($event)" type="file"></div>
                                    <div style="display:flex;flex-direction:row">
                                    <button v-on:click="prosesTerima($event);" style="margin-top:7px;display:flex;padding:5px" class="tmblBiru fadeEffect">Terima</button>
                                    <div v-on:click="()=>{this.penerimaan=!this.penerimaan}" style="margin-left:5px;margin-top:7px;display:flex"><div class="tmblBiru fadeEffect" style="padding:5px">Batal</div></div>
                                    </div>
                                  </div>
                                 
                                  <div v-if="this.editable" style="padding-right:15px;margin-top:12px;position:absolute;width:100%;height:100%;background-color:red;z-index:98;background-color:rgba(242, 242, 242, 0.82);">
                                    <div style="width:100%;display:flex;flex-direction:column">
                                          <div style="width:100%"><input style="width:100%;padding-left:5px" v-model="editabledata.judul" type="text"></div>
                                          <div style="width:100%;margin-top:5px"><textarea style="width:100%;height:200px;resize:none" v-model="editabledata.deskripsi"></textarea></div>
                                          <div style="display:flex;flex-direction:row;margin-top:5px" >
                                              <button v-on:click="ubahHandler($event)" style="margin-right:10px;padding:5px;" class="tmblBiru fadeEffect">Ubah</button>
                                              <div v-on:click="()=>{this.editable=false}" style="margin-right:10px;padding:5px;" class="tmblBiru fadeEffect">Batal</div>
                                          </div>
                                    </div>
                                  </div>
                                 <div style="font-size:28px;padding:10px;padding-right:0px;border-bottom:solid 1px;padding-left:0px;padding-bottom:5px;display:flex;flex-direction:row;justify-content:space-between"><div>{{data.thread.judul}}</div>
                                 <div v-if="this.$store.state.login.username===this.data.user.username" style="display:flex;flex-direction:row">
                                  <div v-on:click="btnEdit()" style="cursor:pointer;margin-left:10px;background-color:#cacaca; font-size:20px;padding-left:25px;padding-right:25px;display:flex;align-items:center;border-radius:5px;color:white">Edit</div>
                                  <div v-on:click="btnHapus()" style="cursor:pointer;margin-left:10px;background-color:#cacaca; font-size:20px;padding-left:25px;padding-right:25px;display:flex;align-items:center;border-radius:5px;color:white">Hapus</div>
                                  </div>
                                 </div>
                                 <div v-html="this.data.thread.deskripsi" style="margin-top:15px;font-size:13px;">
                                 </div>
                                 <div style="margin-top:20px;display:flex;flex-direction:row">
                                     <div v-for="(res,i) in this.data.thread.tags"  v-bind:key="i" style="margin-right:7px;background-color:#e4e4e4;padding:5px">{{res}}</div>    
                                 </div>
                                 <div style="margin-top:15px;background-color:#e4e4e4;border-radius:5px;display:flex;flex-direction:row;padding:10px;">
                                              <div style="width:100%">
                                                  <div>Tanggal dibuat : {{this.data.thread.tgldibuat}}</div>
                                                  <div>Harga : Rp.{{formatrupiah(this.data.thread.harga)}}</div>
                                                  <div>Jangka waktu penyelesaian : {{this.data.thread.jangkawaktu}} Hari</div>
                                              </div>
                                              <div style="width:100%">
                                                  <div style="display:flex">Status jasa : <div style="margin-left:5px" v-html="badgeMapping(this.data.thread.status)"></div></div>
                                                  <div v-if="Object.keys(pekerjaterpilih>0)">Jumlah penaruh : {{this.data.thread.penaruh}}</div>
                                                  <div v-else>Jumlah penaruh : 0</div>
                                              </div>
                                          </div>

                                          <div style="margin-top:15px">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6" style="margin-bottom:15px">
                                                    <div style="font-size:20px;border-bottom:solid 1px;padding-bottom:7px;">Pemilik Permintaan</div>
                                                    <div style="display:flex;flex-direction:row">
                                                        <div style="margin-top:15px;height:100px;width:130px;border-radius:5px;border:solid 1px"><img style="padding:4px;border-radius:15px;width:100%;height:100%" :src="`https://penerjemah.web.id/assets/avatar/${this.data.user.avatar}`"></div>
                                                        <div style="width:100%;padding-top:15px;padding-left:30px">
                                                                <div v-on:click="moveHandler(`/detail/user/${data.user.username}`)" style="margin-bottom:5px;cursor:pointer">{{this.data.user.username}}</div>
                                                                <div style="display:flex;flex-direction:row;padding-top:0px;margin-bottom:5px" v-html="ratingHandler(this.data.user.rating)">
                                                                
                                                                </div>
                                                                <div>{{this.data.user.rating}}/100</div>
                                                                <div>{{this.data.user.point}} Poin</div>
                                                                <div v-if="this.data.user.ranking===`No Ranking`">{{this.data.user.ranking}}</div>
                                                                <div v-else>{{this.data.user.ranking}}/{{this.jumlahuser}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6" style="margin-bottom:15px">
                                                    <div style="font-size:20px;border-bottom:solid 1px;padding-bottom:7px;">Pekerja Terpilih</div>
                                                    <div v-if="Object.keys(pekerjaterpilih).length===0 && this.$store.state.login.username!==this.data.user.username && checkPenaruh(this.$store.state.login.id_user)===false">
                                                        <div style="padding-top:15px;">Taruhan masih terbuka.</div>
                                                        <div style="margin-top:15px;display:flex;flex-direction:row">
                                                            <div style="margin-right:5px;"><button v-on:click="ikutTaruhan($event)" class="tmblBiru fadeEffect" style="padding:5px">Ikut Taruhan</button></div>
                                                            <div v-on:click="tanyaPadaPeminta($event,data.user.username)" style="margin-right:5px;"><button class="tmblBiru fadeEffect" style="padding:5px">Tanya Pada Peminta</button></div>
                                                            <div v-on:click="tanyaPadaPeminta($event,data.user.username)" style="margin-right:5px;"><button class="tmblBiru fadeEffect" style="padding:5px">Chat</button></div>
                                                        </div>
                                                    </div>

                                                    <div style="display:flex;justify-content:center;align-items:center;width:100%;height:100%" v-if="Object.keys(pekerjaterpilih).length===0 && this.$store.state.login.username===this.data.user.username || checkPenaruh(this.$store.state.login.id_user)">
                                                        <div>Taruhan masih terbuka.</div>
                              
                                                    </div>

                                                    <div v-if="Object.keys(pekerjaterpilih).length>0">
                                                        <div style="display:flex;flex-direction:row">
                                                        <div style="margin-top:15px;height:100px;width:130px;border-radius:5px;border:solid 1px"><img style="padding:4px;border-radius:15px;width:100%;height:100%" v-bind:src="`https://penerjemah.web.id/assets/avatar/${this.pekerjaterpilih.gambar}`"></div>
                                                        <div style="width:100%;padding-top:15px;padding-left:30px">
                                                                <div v-on:click="moveHandler(`/detail/user/${pekerjaterpilih.username}`)" style="margin-bottom:5px;cursor:pointer">{{this.pekerjaterpilih.username}}</div>
                                                                <div style="display:flex;flex-direction:row;padding-top:0px;margin-bottom:5px" v-html="ratingHandler(this.pekerjaterpilih.rating)">
                                                                
                                                                </div>
                                                                <div>{{this.pekerjaterpilih.rating}}/100</div>
                                                                <div>{{this.pekerjaterpilih.point}} Poin</div>
                                                                <div>{{this.pekerjaterpilih.ranking}}/{{this.jumlahuser}}</div>
                                                        </div>
                                                    </div>
                                                    </div>


                                                </div>
                                            </div>
                                             <div style="font-size:20px;border-bottom:solid 1px;padding-bottom:7px;">Para Penaruh</div>
                                             <div v-if="penaruh.length===0 || Object.keys(pekerjaterpilih).length>0" style="padding-top:15px;margin-bottom:15px;justify-content:center;height:150px;display:flex;justify-content:center;align-items:center">
                                                <div>Tidak ditemukan penaruh...</div>
                                             </div>
                                             <div v-if="penaruh.length>0 && Object.keys(pekerjaterpilih).length===0" class="row" style="padding-top:15px">
                                                <div style="margin-bottom:5px;padding-left:15px;padding-right:5px;padding-bottom:12px" v-for="(item,index) in this.penaruh" v-bind:key="index">
                                                    <div style="height:100px;width:95px;border-radius:5px;border:solid 1px"><img style="padding:4px;border-radius:15px;width:100%;height:100%" v-bind:src="`https://penerjemah.web.id/assets/avatar/${item.gambar}`"></div>
                                                    <div v-on:click="moveHandler(`/detail/user/${item.username}`)" style="padding-top:5px;cursor:pointer">{{item.username}}</div>
                                                     <div style="margin-top:3px;" v-html="ratingHandler(item.rating)">
                                                                
                                                    </div>
                                                    <div>{{item.rating}}/100</div>
                                                    <div v-if="$store.state.login.username===data.user.username" v-on:click="buttonTerima(item.id_user);" style="padding:3px;margin-top:3px;background-color:#006ac1;color:white;cursor:pointer;border-radius:2px;display:flex;justify-content:center;align-items:center"><div>Terima</div></div>
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
import Footer from "@/components/Footer";
import ContainerChat from "@/components/ContainerChat";
import Header from "@/components/Header";
import sideNav from "@/components/sideNav";
import axios from "axios";
export default {
  components: {
    ContainerChat,
    Footer,
    Header,
    sideNav
  },

  validate({ params }) {
    return /(\d+)/.test(params.id);
  },
  methods: {
    tanyaPadaPeminta: function(e, username) {
      if (username !== this.$store.state.login.username) {
        e.target.disabled = false;
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
              e.target.disabled;
            } else {
              alert("User tidak online!");
              e.target.disabled;
            }
          });
      }
    },
    checkPenaruh: function(iduser) {
      let x = false;
      this.penaruh.map(res => {
        if (res.id_user === this.$store.state.login.id_user) {
          x = true;
        }
      });
      return x;
    },
    ikutTaruhan: function(e) {
      e.target.disabled = true;
      if (this.$store.state.isLogged === false) {
        alert("Login terlebih dahulu!");
      } else {
        axios({
          url: "https://penerjemah.web.id/api/insert.php",
          method: "POST",
          headers: { "content-type": "application/x-www-form-urlencoded" },
          data: `params=${JSON.stringify({
            aksi: "ikutTaruhan",
            credentials: this.$store.state.login,
            id: this.$route.params.id
          })}`
        }).then(res => {
          console.log(res);
          if (res.data.status === "success") {
            alert("Berhasil bertaruh!");
            document.location.reload();
          } else {
            alert("Terjadi kesalahan!");
          }
        });
      }
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
    fileHandler: function(e) {
      //console.log(e);
      if (!e.target.files[0].name.match(/(\.doc|\.docx|\.pdf|\.ass|\.srt)$/)) {
        e.target.value = "";
      }
    },
    prosesTerima: function(e) {
      e.target.disabled = true;
      if (document.querySelectorAll("#inputproses")[0].files.length > 0) {
        e.target.innerHTML = "Sedang mengunggah...";
        let idpermintaan = this.$route.params.id;
        let fd = new FormData();
        let file = document.querySelectorAll("#inputproses")[0].files[0];
        fd.append("file", file, file.name);
        fd.append(
          "params",
          JSON.stringify({
            aksi: "prosesPekerjaTerpilih",
            credentials: this.$store.state.login,
            id: this.$route.params.id,
            idterpilih: this.terpilih,
            deskripsi: document.querySelectorAll("#keterangan")[0].value
          })
        );

        axios
          .post("https://penerjemah.web.id/api/insert.php", fd, {
            headers: {
              "Content-Type": `multipart/form-data; boundary=${fd._boundary}`
            }
          })
          .then(res => {
            if (res.data.status === "success") {
              alert("Berhasil memilih kandidat!");
              document.location.reload();
            } else {
              alert("Terjadi kesalahan!");
            }
          });
      } else {
        alert("Masukkan semua data!");
      }
    },
    buttonTerima: function(terpilih) {
      this.terpilih = terpilih;
      this.penerimaan = true;
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
    ubahHandler: function(e) {
      e.target.disabled = true;
      let deskripsi = "";
      if (this.editabledata.deskripsi.length === 0) {
        deskripsi = "";
      } else {
        deskripsi = this.editabledata.deskripsi
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
          aksi: "updateDetailPermintaan",
          credentials: this.$store.state.login,
          id: this.$route.params.id,
          bearer: {
            judul: this.editabledata.judul,
            deskripsi: deskripsi
          }
        })}`
      }).then(res => {
        if (res.data.status === "success") {
          document.location.reload();
        } else {
          e.target.disabled = false;
          alert("Terjadi kesalahan!");
        }
      });
    },
    btnEdit: function() {
      this.editable = true;
    },
    btnHapus: function() {
      axios({
        url: "https://penerjemah.web.id/api/delete.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params=${JSON.stringify({
          aksi: "deleteDetailPermintaan",
          credentials: this.$store.state.login,
          id: this.$route.params.id
        })}`
      }).then(res => {
        console.log(res);
      });
    },
    moveHandler: function(path) {
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
      terpilih: null,
      penerimaan: false,
      editable: false,
      editabledata: {
        judul: "",
        deskripsi: ""
      },
      jumlahuser: null,
      penaruh: [],
      pekerjaterpilih: {},
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
          status: "",
          penaruh: "",
          kategori: ""
        }
      }
    };
  },
  async asyncData(context) {
    return axios({
      method: "POST",
      url: "https://penerjemah.web.id/api/global.php",
      headers: { "content-type": `application/x-www-form-urlencoded` },
      data: `params={"aksi":"memuatpekerjaterpilihpermintaan","id":"${
        context.params.id
      }"}`
    }).then(res1 => {
      return axios({
        method: "POST",
        url: "https://penerjemah.web.id/api/global.php",
        headers: { "content-type": `application/x-www-form-urlencoded` },
        data: `params={"aksi":"mencarijumlahuser"}`
      }).then(res2 => {
        return axios({
          method: "POST",
          url: "https://penerjemah.web.id/api/global.php",
          headers: { "content-type": `application/x-www-form-urlencoded` },
          data: `params={"aksi":"memuatpenaruhpermintaan","id":"${
            context.params.id
          }"}`
        }).then(res3 => {
          return axios({
            method: "POST",
            url: "https://penerjemah.web.id/api/global.php",
            headers: { "content-type": `application/x-www-form-urlencoded` },
            data: `params={"aksi":"memuatkontenpermintaan","id":"${
              context.params.id
            }"}`
          }).then(res4 => {
            return {
              data: res4.data,
              penaruh: res3.data,
              jumlahuser: res2.data.jumlahuser,
              pekerjaterpilih: res1.data
            };
          });
        });
      });
    });
  },
  mounted() {
    this.editabledata.judul = this.data.thread.judul;
    let desk = this.data.thread.deskripsi.replace(
      /<[^>]+>([^<]+)<[^>]+>/gm,
      `$1\n`
    );
    desk = desk.replace(/<br>/gm, "\n");
    this.editabledata.deskripsi = desk;
  }
};
</script>

<style scoped>
#halamanDetailPermintaan {
  font-size: 12px;
  background-color: #f2f2f2;
}

.tmblBiru {
  cursor: pointer;
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

.fadeEffect:hover {
  opacity: 0.5;
}
</style>