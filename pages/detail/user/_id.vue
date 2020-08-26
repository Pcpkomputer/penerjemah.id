<template>
<div class="halamanPencarianUser" style="background-color:#f2f2f2;overflow-x:hidden">
        <Header/>
            <div class="container-fluid" style="padding:0px;margin-top:10px;margin-bottom:10px;">
              <div class="container" style="padding-left:5px">
                    <div class="row" style="padding:10px;padding-right:13px">


                        <sideNav/>

                        <div class="col-lg-8 col-md-12 col-md-12" style="padding-right:2px;">
                           <div  v-if="this.undang" style="padding-right:15px;margin-top:12px;position:absolute;width:100%;height:100%;background-color:red;z-index:98;background-color:rgba(242, 242, 242, 0.82);">
                              <div style="width:100%">
                                    <select id="selectPilihanUndang" style="width:100%;height:30px;">
                                      <option v-for="(val,i) in this.pilihanUndang" :value="val.id" :key="i" >{{val.judul}}</option>
                                    
                                    </select>
                              </div>
                              <div style="display:flex;flex-direction:row">
                              <div v-on:click="kirimPilihanUndang($event)" style="display:flex;margin-top:8px;"><button class="tmblBiru fadeEffect" style="padding:5px">Kirim</button></div>
                               <div v-on:click="()=>{this.undang=false}" style="display:flex;margin-top:8px;margin-left:5px"><button class="tmblBiru fadeEffect" style="padding:5px">Batal</button></div>
                               </div>
                            </div>

                           <div  v-if="this.editable" style="padding-right:15px;margin-top:12px;position:absolute;width:100%;height:100%;background-color:red;z-index:98;background-color:rgba(242, 242, 242, 0.82);">
                              <div style="width:100%;margin-bottom:5px;"><input v-model="editableuserdata.namalengkap" style="width:100%;padding-left:5px" type="text"></div>
                              <div style="width:100%;margin-bottom:5px;"><input v-model="editableuserdata.provinsi" style="width:100%;padding-left:5px" type="text"></div>
                              <div style="width:100%;margin-bottom:5px;"><input v-model="editableuserdata.kabupaten" style="width:100%;padding-left:5px" type="text"></div>
                              <div style="width:100%;margin-top:5px"><textarea style="width:100%;height:200px;resize:none" v-model="editableuserdata.deskripsi"></textarea></div>
                                <div style="display:flex;flex-direction:row;margin-top:5px" >
                                              <button v-on:click="ubahHandler($event)" style="cursor:pointer;margin-right:10px;padding:5px;" class="tmblBiru fadeEffect">Ubah</button>
                                              <div v-on:click="()=>{this.editable=false}" style="cursor:pointer;margin-right:10px;padding:5px;" class="tmblBiru fadeEffect">Batal</div>
                                          </div>
                          </div>
                                 <div style="font-size:28px;padding:10px;border-bottom:solid 1px;padding-left:0px;padding-bottom:5px;">{{this.$route.params.id}}</div>
                                 <div style="margin-top:35px;border-bottom:solid 1px;display:flex;flex-direction:row">
                                    <div class="tmblBiru fadeEffect" v-on:click="navHandler($event)" style="padding:8px;margin-right:5px;font-size:14px;cursor:pointer">Profil</div>
                                    <div class="tmblBiru fadeEffect" v-on:click="navHandler($event)" style="padding:8px;margin-right:5px;font-size:14px;cursor:pointer">Portofolio</div>
                                    <div v-if="this.$store.state.isLogged && this.$route.params.id===this.$store.state.login.username" class="tmblBiru fadeEffect" v-on:click="navHandler($event)" style="bacgkround-color:#8e2727;padding:8px;margin-right:5px;font-size:14px;cursor:pointer;background-color:#842431">Dalam Progress</div>
                                    <div v-if="this.$store.state.isLogged && this.$route.params.id===this.$store.state.login.username" class="tmblBiru fadeEffect" v-on:click="navHandler($event)" style="bacgkround-color:#8e2727;padding:8px;margin-right:5px;font-size:14px;cursor:pointer;background-color:#842431">Permintaan Selesai</div>
                                 </div>
                                 <div v-show="this.switch.profil" style="margin-top:25px">
                                     <div class="row">
                                         <div class="col-lg-8" v-html="this.data.thread.deskripsi" style="margin-bottom:25px"></div>
                                         <div class="col-lg-4">
                                                <div v-if="this.$store.state.login.username!==this.$route.params.id" class="tmblDeal noselect" v-on:click="undangDalamTaruhan($event)"  style="color:white;padding:12px;border-radius:5px;display:flex;justify-content:center;align-items:center;flex-direction:column">
                                                    <div style="font-size:17px;font-weight:450;cursor:pointer">Undang Dalam Taruhan</div>
                                                    <div style="font-weight:300;cursor:pointer">Permintaan yang Kamu Buat</div>
                                                </div>

                                                 <div v-if="this.$store.state.login.username==this.$route.params.id"  class="tmblDeal noselect" v-on:click="()=>{this.editable=true;}" style="color:white;padding:12px;border-radius:5px;display:flex;justify-content:center;align-items:center;flex-direction:column">
                                                    <div  style="font-size:17px;font-weight:450;cursor:pointer">Ubah Identitas Profil</div>
                                                </div>

                                                <div :style="`margin-top:${(this.$store.state.login.username!==this.$route.params.id)?`15px`:`15px`}`">
                                                    <div style="width:100%;height:200px;border:solid 1px">
                                                        <img style="height:100%;width:100%;object-fit:contain" :src="`http://localhost/penerjemah.id/server/assets/avatar/${this.data.user.avatar}`">
                                                    </div>
                                                </div>

                                                <div style="margin-top:15px;border-top:solid 1px;">
                                                    <div style="background-color: #e0e0e0;display:flex;flex-direction:row;border-bottom:solid 1px;padding-top:6px;padding-bottom:6px">
                                                        <div style="width:150px">Nama Lengkap :</div>
                                                        <div style="width:100%;text-align:center">{{this.data.user.namalengkap}}</div>
                                                    </div>

                                                     <div style="display:flex;flex-direction:row;border-bottom:solid 1px;padding-top:6px;padding-bottom:6px">
                                                        <div style="width:150px">Username :</div>
                                                        <div style="width:100%;text-align:center">{{this.data.user.username}}</div>
                                                    </div>

                                                     <div style="background-color: #e0e0e0;display:flex;flex-direction:row;border-bottom:solid 1px;padding-top:6px;padding-bottom:6px">
                                                        <div style="width:150px">Tanggal Dibuat :</div>
                                                        <div style="width:100%;text-align:center">{{this.data.user.tanggaldibuat}}</div>
                                                    </div>

                                                    <div style="display:flex;flex-direction:row;border-bottom:solid 1px;padding-top:6px;padding-bottom:6px">
                                                        <div style="width:150px">Provinsi :</div>
                                                        <div style="width:100%;text-align:center">{{this.data.user.provinsi}}</div>
                                                    </div>

                                                    <div style="background-color: #e0e0e0;display:flex;flex-direction:row;border-bottom:solid 1px;padding-top:6px;padding-bottom:6px">
                                                        <div style="width:150px">Kabupaten :</div>
                                                        <div style="width:100%;text-align:center">{{this.data.user.kabupaten}}</div>
                                                    </div>

                                                    <div style="display:flex;flex-direction:row;border-bottom:solid 1px;padding-top:6px;padding-bottom:6px">
                                                        <div style="width:150px">Permintaan dan Jasa:</div>
                                                        <div style="width:100%;text-align:center">{{this.data.user.permintaandanjasaselesai}}</div>
                                                    </div>

                                                    <div style="background-color: #e0e0e0;display:flex;flex-direction:row;border-bottom:solid 1px;padding-top:6px;padding-bottom:6px">
                                                        <div style="width:150px">Terakhir Login :</div>
                                                        <div style="width:100%;text-align:center">{{this.data.user.terakhirlogin}}</div>
                                                    </div>

                                                
                                                </div>
                                                
                                         </div>
                                         
                                     </div>
                                    
                                 </div>
                                 
                                 <div v-show="this.switch.profil" class="row mt-5">
                                    <div class="col-lg-12">
                                        <div>
                                            <div style="border-bottom:solid 1px;font-size:20px;padding-bottom:5px">Permintaan</div>
                                            <div v-if="this.permintaan.length===0" style="height:125px;display:flex;justify-content:center;align-items:center">
                                                <div>Tidak ditemukan permintaan...</div>
                                            </div>

                                            <div v-else style="margin-bottom:25px">
                                                <div style="padding-top:16px;padding-bottom:10px;display:flex;flex-direction:row;overflow-x:scroll">

                                                    <div v-for="(val,i) in this.permintaan" v-bind:key="i" class="opacityReduced" v-on:click="moveHandler(`/detail/permintaan/${val.id}`)" style="display:flex;flex-direction:row;margin-right:10px;cursor:pointer;background-color:#e4e4e4;border:solid 1px;padding:20px">
                                                        <div style="display:flex;flex-direction:column;margin-left:10px">
                                                            <div style="width:150px"><b>{{val.judul}}</b></div>
                                                            <div style="display:flex"><div v-html="badgeMapping(val.status)"></div></div>
                                                        </div>
                                                    </div>  

                                                
                                                </div>
                                            </div>

                                        </div>

                                          <div>
                                            <div style="border-bottom:solid 1px;font-size:20px;padding-bottom:5px">Jasa</div>
                                            <div v-if="this.jasa.length===0" style="height:125px;display:flex;justify-content:center;align-items:center">
                                                <div>Tidak ditemukan jasa...</div>
                                            </div>

                                            
                                         <div v-else>
                                                <div style="padding-top:16px;padding-bottom:10px;display:flex;flex-direction:row;overflow-x:scroll">

                                                    <div v-for="(val,i) in this.jasa" v-bind:key="i" style="display:flex;flex-direction:row;margin-right:10px">
                                                        <div style="border:solid 1px"><img :src="val.background" style="width:100px;height:100px"></div>
                                                        <div style="display:flex;flex-direction:column;margin-left:10px">
                                                            <div style="width:150px"><nuxt-link style="color:black" :to="`/detail/jasa/${val.id}`">{{val.judul}}</nuxt-link></div>
                                                            <div>{{val.status}}</div>
                                                        </div>
                                                    </div>  

                                                
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                 </div>
                                 
                                 <div v-show="this.switch.portofolio" style="margin-top:15px;margin-bottom:50px;display:flex;flex-direction:column;flex-wrap:wrap">
                                    <div  v-if="this.$store.state.login.username===this.$route.params.id" v-on:click="()=>{this.openInputPortofolio=!this.openInputPortofolio;}" style="margin-bottom:14px;padding:0px;display:flex">
                                        <div class="tmblBiru fadeEffect" style="cursor:pointer;padding:8px;font-size:13px">Tambah Portofolio</div>
                                    </div>
                                    <div  v-show="openInputPortofolio" style="margin-bottom:15px">
                                    <textarea id="txtareaPorto" style="width:300px;height:100px;resize:none"></textarea>
                                    <div style="margin-top:5px"><input v-on:change="fileHandler($event);" id="inputPorto" type="file"></div>
                                    <button v-on:click="kirimPortofolio($event);" style="cursor:pointer;display:flex;margin-top:10px;padding:10px" class="tmblBiru fadeEffect">Kirim</button>
                                    </div>
                        
                                    <div style="display:flex;flex-direction:row;flex-wrap:wrap">
                                        <div v-for="(val,i) in this.portofolio" v-bind:key="i" style="display:flex;flex-direction:column;margin-right:15px;margin-bottom:15px">
                                            <div style="width:130px;height:130px;border:solid 1px"><img style="object-fit:contain;width:100%;height:100%" :src="`http://localhost/penerjemah.id/server/assets/portofolio/${val.gambar}`"></div>
                                            <div style="margin-top:10px;word-wrap:wrap;width:130px">{{val.keterangan}}</div>
                                        </div>
                                    </div>

                                 </div>

                                  <div v-show="this.switch.permintaanselesai" style="margin-top:15px;margin-bottom:50px;display:flex;flex-direction:column;flex-wrap:wrap">
                                     <div v-for="(val,i) in this.permintaanselesai" :key="i" style="margin-bottom:13px;display:flex;flex-direction:column;background-color:white;padding:10px;border:solid 1px">
                                        <div style="display:flex" v-html="badgeMapping(val.status)"></div>
                                        <div style="margin-top:5px">{{val.judul}}</div>
                                        <div style="display:flex;flex-direction:row">Dari<div style="margin-left:4px;color:blue">{{val.dari}}</div></div>
                                        <div style="display:flex;flex-direction:row">Attachment : <button id="attcc" v-on:click="clickAttachment(val.idpermintaan,$event)" style="margin-left:5px;color:blue;text-decoration:underline;cursor:pointer">download</button></div>
                                     </div>


                                 </div>




                                  <div v-show="this.switch.dalamprogress" style="margin-top:15px;margin-bottom:50px;display:flex;flex-direction:column;flex-wrap:wrap">
                                    <div v-for="(val,i) in this.dalamprogress" v-bind:key="i" style="margin-bottom:15px;display:flex;flex-direction:column;border-bottom:solid 1px;padding-bottom:15px">
                                        <div style="display:flex;margin-bottom:8px"><div v-html="badgeMapping(val.status)"></div><div v-on:click="moveHandler(`/detail/permintaan/${val.id}`)" style="margin-left:10px;">{{val.judul}}</div>
                                        <div style="background-color:#a74545;padding-left:5px;border-radius:5px;padding-right:5px;padding-top:1px;padding-bottom:1px;color:white;font-size:10px;margin-left:10px">Rp.{{formatrupiah(val.harga)}}</div>
                                        <div style="background-color:#a74545;padding-left:5px;border-radius:5px;padding-right:5px;padding-top:1px;padding-bottom:1px;color:white;font-size:10px;margin-left:10px">Deadline : {{val.deadline}}</div>
                                         <div v-if="val.status!==`finished`" v-html="cekExpired(val.deadline)"></div>
                                         <div v-if="val.status==`finished`">  <div style="background-color:rgb(115, 90, 175);padding-left:5px;border-radius:5px;padding-right:5px;padding-top:1px;padding-bottom:1px;color:white;font-size:10px;margin-left:10px">Permintaan telah terselesaikan</div></div>
                                        </div>
                                        
                                        <div style="background-color:white;border:solid 1px;width:100%;padding:5px;">{{val.deskripsi}}</div>
                                        <div style="margin-top:8px;display:flex"><div>Attachment :</div><div v-on:click="berpindah(`http://localhost/penerjemah.id/server/assets/handwork/${val.file}`)" style="color:blue;text-decoration:underline;cursor:pointer;">{{val.file}}</div></div>
                                        <div v-show="val.status===`in progress`" style="margin-top:8px"><input v-on:change="fileHandlerTransact($event)" id="filekerjaan" type="file"></div>
                                        <div v-show="val.status===`in progress`" style="display:flex;margin-top:7px"><button class="tmblBiru fadeEffect" v-on:click="kirimKerjaan($event,i,val.id)" style="padding:5px">Kirim</button></div>
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
  async asyncData(context) {
    return axios({
      method: "POST",
      url: "http://localhost/penerjemah.id/server/api/global.php",
      data: `params={"aksi":"memuatdetailuser","id":"${context.params.id}"}`,
      headers: { "content-type": "application/x-www-form-urlencoded" }
    }).then(res1 => {
      return axios({
        method: "POST",
        url: "http://localhost/penerjemah.id/server/api/global.php",
        data: `params={"aksi":"memuatdetailuser-permintaan","id":"${
          context.params.id
        }"}`,
        headers: { "content-type": "application/x-www-form-urlencoded" }
      }).then(res2 => {
        return axios({
          method: "POST",
          url: "http://localhost/penerjemah.id/server/api/global.php",
          data: `params={"aksi":"memuatdetailuser-jasa","id":"${
            context.params.id
          }"}`,
          headers: { "content-type": "application/x-www-form-urlencoded" }
        }).then(res3 => {
          return axios({
            method: "POST",
            url: "http://localhost/penerjemah.id/server/api/global.php",
            data: `params={"aksi":"loaddataportofolio","id":"${
              context.params.id
            }"}`,
            headers: { "content-type": "application/x-www-form-urlencoded" }
          }).then(res4 => {
            return {
              portofolio: res4.data,
              data: res1.data,
              permintaan: res2.data,
              jasa: res3.data
            };
          });
        });
      });
    });
  },
  validate({ params }) {
    return /([^\d+])/.test(params.id);
  },
  methods: {
    kirimPilihanUndang: function(e) {
      let el = document.querySelectorAll("#selectPilihanUndang")[0];
      if (el.selectedIndex !== -1) {
        let idkategori = el.value;
        e.target.disabled = true;
        axios({
          url: "http://localhost/penerjemah.id/server/api/transaction.php",
          method: "POST",
          headers: { "content-type": "application/x-www-form-urlencoded" },
          data: `params=${JSON.stringify({
            aksi: "mengirimPermintaanUndangan",
            id: idkategori,
            target: this.$route.params.id,
            credentials: this.$store.state.login
          })}`
        }).then(res => {
          console.log(res);
          if (res.data.status === "success") {
            alert("User berhasil diundang!");
            document.location.reload();
          } else {
            alert("Terjadi kesalahan!");
            e.target.disabled = false;
          }
        });
      }
    },
    undangDalamTaruhan: function(e) {
      if (this.$store.state.isLogged === false) {
        alert("Login terlebih dahulu!");
      } else {
        e.target.disabled = true;
        axios({
          method: "POST",
          url: "http://localhost/penerjemah.id/server/api/global.php",
          data: `params=${JSON.stringify({
            aksi: "loadJudulPermintaan",
            credentials: this.$store.state.login
          })}`,
          headers: { "content-type": "application/x-www-form-urlencoded" }
        }).then(res => {
          this.undang = true;
          e.target.disabled = false;
          this.pilihanUndang = res.data;
        });
      }
    },
    clickAttachment: function(idpermintaan, e) {
      e.target.disabled = true;
      axios({
        url: "http://localhost/penerjemah.id/server/api/transaction.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params=${JSON.stringify({
          aksi: "loadFileTransaksi",
          id: idpermintaan,
          credentials: this.$store.state.login
        })}`
      }).then(res => {
        if (res.data.status === "unauthorized") {
          if (
            window.confirm(
              `Permintaan masih membutuhkan pembayaran apakah Anda ingin membayarnya? (Rp.${this.formatrupiah(
                res.data.jumlahbayar
              )}/500=${res.data.token} Mata Uang Digital)`
            )
          ) {
            axios({
              url: "http://localhost/penerjemah.id/server/api/transaction.php",
              method: "POST",
              headers: { "content-type": "application/x-www-form-urlencoded" },
              data: `params=${JSON.stringify({
                aksi: "prosesPembayaran",
                id: idpermintaan,
                credentials: this.$store.state.login
              })}`
            }).then(res1 => {
              console.log(res1);
              if (res1.data.status === "alert") {
                alert(res1.data.keterangan);
                e.target.disabled = false;
              }
              if (res1.data.status === "success") {
                alert(res1.data.keterangan);
                document.location.reload();
              }
            });
          }
        } else {
          if (res.data.status === "success") {
            e.target.disabled = false;
            window.open(
              `http://localhost/penerjemah.id/server/assets/locked/${
                res.data.link
              }`,
              "_blank"
            );
          }
        }
      });
    },
    kirimKerjaan: function(e, index, idpermintaan) {
      let file = document.querySelectorAll("#filekerjaan")[index];
      if (file.files.length > 0) {
        e.target.disabled = true;
        let fd = new FormData();
        fd.append("file", file.files[0], file.files[0].name);
        fd.append(
          "params",
          JSON.stringify({
            aksi: "prosesDalamProgress",
            credentials: this.$store.state.login,
            id: idpermintaan
          })
        );

        axios
          .post(
            "http://localhost/penerjemah.id/server/api/transaction.php",
            fd,
            {
              headers: {
                "Content-Type": `multipart/form-data; boundary=${fd._boundary}`
              }
            }
          )
          .then(res => {
            console.log(res);
            if (res.data.status === "success") {
              alert("Berhasil mengunggah file!");
              document.location.reload();
            } else {
              e.target.disabled = false;
              alert("Terjadi kesalahan!");
            }
          });
      } else {
        e.target.disabled = false;
        alert("Masukkan file dulu!");
      }
    },
    cekExpired: function(tanggal) {
      let deadline = new Date(`${tanggal} 00:00:00`).getTime();
      let now = new Date().getTime();

      if (deadline > now) {
        return `<div style="background-color:#468c2f;padding-left:5px;border-radius:5px;padding-right:5px;padding-top:1px;padding-bottom:1px;color:white;font-size:10px;margin-left:10px">Masih berlaku</div>`;
      } else {
        return `<div style="background-color:#a74545;padding-left:5px;border-radius:5px;padding-right:5px;padding-top:1px;padding-bottom:1px;color:white;font-size:10px;margin-left:10px">Expired</div>`;
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
      if (!e.target.files[0].name.match(/(\.png|\.jpg)$/)) {
        e.target.value = "";
        this.prosesPorto = false;
      } else if (!e.target.files[0].type.match(/(image\/jpeg|image\/png)/)) {
        e.target.value = "";
        this.prosesPorto = false;
      } else {
        this.prosesPorto = true;
      }
    },
    kirimPortofolio: function(e) {
      if (this.prosesPorto) {
        e.target.disabled = true;
        let desc = document.querySelectorAll(`#txtareaPorto`)[0].value;
        let file = document.querySelectorAll("#inputPorto")[0].files[0];
        let fdata = new FormData();
        fdata.append("file", file, file.name);
        fdata.append(
          "params",
          JSON.stringify({
            aksi: "uploadPortofolio",
            id: this.$route.params.id,
            credentials: this.$store.state.login,
            bearer: {
              deskripsi: desc
            }
          })
        );

        axios
          .post("http://localhost/penerjemah.id/server/api/insert.php", fdata, {
            headers: {
              "Content-Type": `multipart/form-data; boundary=${fdata._boundary}`
            }
          })
          .then(res => {
            //console.log(res);
            if (res.data.status === "success") {
              alert("Portofolio berhasil diupload!");
              document.location.reload();
            } else {
              e.target.disabled = false;
              alert("Terjadi kesalahan!");
            }
          });
      } else {
        e.target.disabled = false;
        alert("Masukkan data yang benar!");
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
    ubahHandler: function(e) {
      e.target.disabled = true;
      let deskripsi = "";
      if (this.editableuserdata.deskripsi.length === 0) {
        deskripsi = "";
      } else {
        deskripsi = this.editableuserdata.deskripsi
          .match(/^(.+|\s+)/gm)
          .map(
            res =>
              res.match(/\w+/)
                ? `<p style="margin-bottom:0px;">${res}</p>`
                : `<br>`
          )
          .join("");
      }

      //alert(deskripsi);

      axios({
        url: "http://localhost/penerjemah.id/server/api/update.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params=${JSON.stringify({
          aksi: "updateDetailUser",
          credentials: this.$store.state.login,
          id: this.$route.params.id,
          bearer: {
            namalengkap: this.editableuserdata.namalengkap,
            provinsi: this.editableuserdata.provinsi,
            kabupaten: this.editableuserdata.kabupaten,
            deskripsi: deskripsi
          }
        })}`
      })
        .then(res => {
          if (res.data.status === "success") {
            document.location.reload();
          } else {
            e.target.disabled = false;
            alert("Terjadi kesalahan!");
          }
        })
        .catch(err => {
          alert(err);
        });
    },
    berpindah: function(a) {
      window.open(a, "_blank");
    },
    fileHandlerTransact: function(e) {
      //console.log(e);
      if (!e.target.files[0].name.match(/(\.doc|\.docx|\.pdf|\.ass|\.srt)$/)) {
        e.target.value = "";
      }
    },
    navHandler: function(el) {
      let a = el.target.innerHTML;
      if (a.match("Profil")) {
        this.switch.permintaanselesai = false;
        this.switch.portofolio = false;
        this.switch.dalamprogress = false;
        this.switch.profil = true;
      } else if (a.match("Portofolio")) {
        this.switch.profil = false;
        this.switch.permintaanselesai = false;
        this.switch.dalamprogress = false;
        this.switch.portofolio = true;
      } else if (a.match("Dalam Progress")) {
        this.switch.profil = false;
        this.switch.permintaanselesai = false;
        this.switch.portofolio = false;
        this.switch.dalamprogress = true;
      } else if (a.match("Permintaan Selesai")) {
        this.switch.profil = false;
        this.switch.portofolio = false;
        this.switch.dalamprogress = false;
        this.switch.permintaanselesai = true;
      }
    },
    moveHandler(path) {
      this.$router.push({ path: path });
    }
  },
  mounted() {
    ///loaddalamprogress
    function formatrupiah(angka) {
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
    }

    if (
      this.$store.state.isLogged &&
      this.$route.params.id === this.$store.state.login.username
    ) {
      axios({
        url: "http://localhost/penerjemah.id/server/api/transaction.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params=${JSON.stringify({
          aksi: "loadDalamProgress",
          credentials: this.$store.state.login
        })}`
      }).then(res => {
        this.dalamprogress = res.data;
      });

      axios({
        url: "http://localhost/penerjemah.id/server/api/transaction.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params=${JSON.stringify({
          aksi: "loadPermintaanSelesai",
          credentials: this.$store.state.login
        })}`
      }).then(res => {
        console.log(res);
        this.permintaanselesai = res.data;
      });
    }

    this.editableuserdata.namalengkap = this.data.user.namalengkap;
    this.editableuserdata.provinsi = this.data.user.provinsi;
    this.editableuserdata.kabupaten = this.data.user.kabupaten;
    let desk = this.data.thread.deskripsi.replace(
      /<[^>]+>([^<]+)<[^>]+>/gm,
      `$1\n`
    );
    desk = desk.replace(/<br>/gm, "\n");
    this.editableuserdata.deskripsi = desk;
  },
  data() {
    return {
      chatpayload: [],
      pilihanUndang: [
        { id: 1, judul: "tes123333" },
        { id: 2, judul: "55555555" }
      ],
      undang: false,
      disabledButon: false,
      debug: "",
      permintaanselesai: [],
      dalamprogress: [],
      prosesPorto: false,
      openInputPortofolio: false,
      editable: false,
      portofolio: [
        { id: "", gambar: "", keterangan: "sadsad" },
        { id: "", gambar: "", keterangan: "asdsadsadasd" }
      ],
      data: {
        user: {
          id: 1,
          avatar: "",
          namalengkap: "1",
          username: "sadasd",
          tanggaldibuat: "222",
          provinsi: "123",
          kabupaten: "",
          permintaandanjasaselesai: 0,
          terakhirlogin: ""
        },
        thread: {
          deskripsi: "aaaa"
        }
      },
      switch: {
        profil: true,
        portofolio: false,
        dalamprogress: false,
        permintaanselesai: false
      },
      permintaan: [],
      jasa: [],
      editableuserdata: {
        namalengkap: "",
        provinsi: "",
        kabupaten: "",
        deskripsi: ""
      }
    };
  }
};
</script>


<style scoped>
div {
  cursor: default;
}

p {
  margin-bottom: 0px;
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
  cursor: pointer;
  color: white;
  background-color: rgb(0, 107, 194);
  padding: 2px;
  outline: none;
  border: 0px;
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

.opacityReduced:hover {
  cursor: pointer;
  opacity: 0.5;
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

.halamanPencarianUser {
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

.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}
</style>
