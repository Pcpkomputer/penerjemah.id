<template>
    <div class="halamanPencarianPermintaan" style="background-color:#f2f2f2;overflow-x:hidden">
        <Header/>
            <div class="container-fluid" style="padding:0px;margin-top:10px;margin-bottom:10px;">
              <div class="container" style="padding-left:5px">
                    <div class="row" style="padding:10px;padding-right:13px">


                        <sideNav/>

                        <div class="col-lg-8 col-md-12 col-md-12" style="padding-right:2px;">
                           <div  v-if="this.editable" style="padding-right:15px;margin-top:12px;position:absolute;width:100%;height:100%;background-color:red;z-index:98;background-color:rgba(242, 242, 242, 0.82);">
                              <div style="width:100%;margin-bottom:5px;"><input v-model="editablethread.judul" style="width:100%;padding-left:5px" placeholder="Judul permintaan" type="text"></div>
                              <div style="width:100%;margin-top:5px"><textarea style="width:100%;height:200px;resize:none;padding-left:5px" v-model="editablethread.deskripsi" placeholder="Deskripsi permintaan"></textarea></div>
                              <div style="width:100%;margin-bottom:5px;"><input v-model="editablethread.harga" style="width:100%;padding-left:5px" placeholder="Harga" type="text"></div>
                              <div style="width:100%;margin-bottom:5px;"><input v-model="editablethread.jangkawaktu" style="width:100%;padding-left:5px" placeholder="Jangka waktu penyelesaian" type="text"></div>
                              <div style="width:100%;margin-bottom:5px;">
                              <select id="selectKategori" style="padding-left:5px;">
                                <option v-for="(val,i) in this.kategori" v-bind:value="val" v-bind:key="i">{{val}}</option>
                              </select>
                              </div>
                              <div style="display:flex;flex-direction:row">
                               <div style="display:flex;flex-direction:row;width:150px;overflow-x:scroll;overflow-y:hidden;padding:5px">
                                                      <div v-for="(x,i) in editablethread.tags" v-on:click="popLabel(i)" v-bind:key="i" style="cursor:pointer;background-color:#30566ba6;padding:3px;margin-right:5px;border-radius:3px;color:white;display:flex"><div>{{x}}</div></div>
                                                        
                              </div>
                              <div style="margin-left:10px;margin-top:5px;">
                                                      <div><input id="inputLabel" style="width:100px;padding-left:5px;" type="text"></div>
                                                  </div>

                                                  <div style="margin-left:10px;margin-top:5px">
                                                      <div class="tmblBiru fadeEffect" v-on:click="inputLabel()" style="cursor:pointer;padding-left:7px;padding-right:7px;">Masukkan Label</div>
                                                  </div>
                              </div>

                               <div style="display:flex;flex-direction:row;margin-top:5px;margin-top:10px;" >
                                              <button v-on:click="kirimHandler($event)" style="cursor:pointer;margin-right:10px;padding:5px;" class="tmblBiru fadeEffect">Kirim</button>
                                              <div v-on:click="()=>{this.editable=false}" style="cursor:pointer;margin-right:10px;padding:5px;" class="tmblBiru fadeEffect">Batal</div>
                                          </div>
                              
                              
                           </div>
                          <div id="loadingScreen" style="display:none;position:absolute;background-color:#eaeaea6b;width:100%;height:100%">
                              
                          </div>
                          <div style="font-size:28px;padding:10px;border-bottom:solid 1px;padding-left:0px;padding-bottom:5px;">Jelajahi Permintaan</div>
                          <div v-if="contentIsLoaded" style="padding-top:5px;padding-bottom:5px;border-bottom:solid 1px;display:flex;flex-direction:row;justify-content:space-between">
                              <div style="padding:5px"><button v-on:click="buatPermintaan();" class="tmblBiru fadeEffect" style="padding:5px;">Buat Permintaan</button></div>
                              <div style="display:flex;flex-direction:row;padding:5px">
                                <div id="toKiri" style="background-color:#006bc2;color:white;padding:5px;margin-right:4px"><<</div>
                                <div class="parentPagination" style="display:flex;flex-direction:row;width:184px;"> 
                                  <div v-for="i in this.pagination.jumlahpage" v-bind:key="i-1" :class="`numberPagination ${(i===1) ? 'checked':''}`" style="padding:5px;">{{i}}</div>
                                
                                </div>
                                <div id="toKanan" style="background-color:#006bc2;padding:5px;margin-left:0px;color:white">>></div>
                              </div>
                          </div>

                           <div v-else style="padding-top:5px;padding-bottom:5px;border-bottom:solid 1px;display:flex;flex-direction:row;justify-content:space-between">
                              <div style="padding:5px"><button class="tmblBiru fadeEffect placeholder" style="padding:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default">Buat Permintaan</button></div>
                              <div style="display:flex;flex-direction:row;padding:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default;height:30px;margin-top:4px;" class="placeholder">
                                <div class="parentPagination" style="display:flex;flex-direction:row;width:184px"> 
                                  
                                </div>
                              </div>
                          </div>

                          <div v-if="contentIsLoaded" id="isiKonten">
                                     <div style="margin-top:10px" v-for="(val,i) in this.data" v-bind:key=i>
                                  <div style="display:flex;flex-direction:row;padding:5px">
                                        <div v-on:click="ikutTaruhan(val.thread.id, $event)"><button  class="tmblBiru fadeEffect" style="padding:5px;">Ikut Taruhan</button></div>
                                        <div v-on:click="tanyaPadaPeminta($event,val.user.username)" style="margin-left:5px;"><button  class="tmblBiru fadeEffect" style="padding:5px;">Tanya Pada Peminta</button></div>
                                        <div v-on:click="detailHandler(i,val.thread.id,$event)" style="margin-left:5px;"><button  class="tmblBiru fadeEffect" style="padding:5px;">Lihat Permintaan</button></div>
                                  </div>
                                  <div style="padding:5px;display:flex;flex-direction:row;margin-top:5px;border-bottom:solid 1px;padding-bottom:20px">
                                      <div style="display:flex;flex-direction:column">
                                        <div style="border:solid 1px;width:100px;height:105px;border-radius:5px"><img style="width:100%;height:100%" :src="`https://penerjemah.web.id/assets/avatar/${val.user.avatar}`"></div>
                                        <div style="padding:5px;cursor:pointer" v-on:click="()=>{$router.push({path:`/detail/user/${val.user.username}`})}">{{val.user.username}}</div>
                                        <div v-html="ratingHandler(val.user.rating)" style="display:flex;flex-direction:row;padding:5px;padding-top:0px;">
                                          
                                        </div>
                                        <div style="padding:5px;padding-top:0px;padding-bottom:0px;">
                                            {{val.user.rating}}/100
                                        </div>
                                        <div style="padding:5px;padding-top:0px;padding-bottom:0px;">{{val.user.point}} Point</div>
                                        <div v-if="val.user.ranking!==`No Ranking`" style="padding:5px;padding-top:0px;">{{val.user.ranking}}/{{val.user.jumlahuser}}</div>
                                        <div v-else style="padding:5px;padding-top:0px;">{{val.user.ranking}}</div>
                                      </div>
                                      <div style="width:100%;padding-left:10px;display:flex;flex-direction:column">
                                          <div v-on:click="detailHandler(i,val.thread.id,$event)" class="underlinedhover" style="font-size:25px;cursor:pointer" >{{val.thread.judul}}</div>
                                          <div style="margin-bottom:5px">{{penggal(val.thread.deskripsi)}}</div>
                                          <div v-show="!val.thread.tags[0]===``" style="display:flex;flex-direction:row;margin-bottom:10px;">
                                            <div v-for="(v,c) in val.thread.tags" v-bind:key=c style="margin-right:7px;background-color:#e4e4e4;padding:5px;border-radius:3px">{{v}}</div>                  
                                          </div>
                                          
                                          <div style="background-color:#e4e4e4;border-radius:5px;display:flex;flex-direction:row;padding:10px;">
                                              <div class="row" style="width:100%">
                                                  <div style="width:100%" class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                      <div>Tanggal dibuat : {{val.thread.tgldibuat}}</div>
                                                      <div>Harga : Rp.{{formatrupiah(val.thread.harga)}}</div>
                                                      <div>Jangka waktu penyelesaian : {{val.thread.jangkawaktu}} Hari</div>
                                                  </div>
                                                  <div style="width:100%" class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                      <div style="display:flex;flex-direction:row">Status jasa : <div style="padding-left:5px" v-html="badgeMapping(val.thread.status)"></div></div>
                                                      <div>Jumlah penaruh : {{val.thread.penaruh}}</div>
                                                  </div>
                                              </div>

                                          </div>

                                          
                                      </div>
                                  </div>
                              </div>
          
                          </div>

                          <div v-else id="isiKonten" style="user-select:none">
                                     <div style="margin-top:10px" v-for="(val,i) in this.placeholder" v-bind:key=i>
                                  <div style="display:flex;flex-direction:row;padding:5px">
                                        <div class="placeholder"><button  class="tmblBiru" style="padding:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default">Ikut Taruhan</button></div>
                                        <div class="placeholder" style="margin-left:5px;"><button  class="tmblBiru" style="padding:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default">Tanya Pada Peminta</button></div>
                                        <div class="placeholder" style="margin-left:5px;"><button  class="tmblBiru" style="padding:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default">Lihat Permintaan</button></div>
                                  </div>
                                  <div style="padding:5px;display:flex;flex-direction:row;margin-top:5px;border-bottom:solid 1px;padding-bottom:20px">
                                      <div style="display:flex;flex-direction:column">
                                        <div class="placeholder" style="border:solid 1px;width:100px;height:105px;border-radius:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default">gambar</div>
                                        <div class="placeholder" style="padding:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default;margin-top:5px;height:20px">{{val.user.username}}</div>
                                        <div class="placeholder" style="display:flex;flex-direction:row;padding:5px;padding-top:0px;background-color:#e4e4e4;color:#e4e4e4;cursor:default;height:20px;margin-top:5px;">
                                           
                                        </div>
                                        <div class="placeholder" style="padding:5px;padding-top:0px;padding-bottom:0px;background-color:#e4e4e4;color:#e4e4e4;cursor:default;margin-top:5px;width:40px;">
                                            {{val.user.rating}}/100
                                        </div>
                                        <div class="placeholder" style="padding:5px;padding-top:0px;padding-bottom:0px;background-color:#e4e4e4;color:#e4e4e4;cursor:default;margin-top:5px;width:70px">{{val.user.point}} Point</div>
                                
                                      </div>
                                      <div style="width:100%;padding-left:10px;display:flex;flex-direction:column">
                                          <div class="placeholder" style="font-size:25px;background-color:#e4e4e4;color:#e4e4e4;cursor:default" >{{val.thread.judul}}</div>
                                          <div class="placeholder" style="margin-bottom:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default">{{penggal(val.thread.deskripsi)}}</div>
                                          <div class="placeholder" style="display:flex;flex-direction:row;margin-bottom:10px;">
                                            <div v-for="(v,c) in val.thread.tags" v-bind:key=c style="margin-right:7px;background-color:#e4e4e4;padding:5px;border-radius:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default">{{v}}</div>                  
                                          </div>
                                          
                                          <div class="placeholder" style="background-color:#e4e4e4;border-radius:5px;display:flex;flex-direction:row;padding:10px;background-color:#e4e4e4;color:#e4e4e4;cursor:default">
                                              <div style="width:100%">
                                                  <div>Tanggal dibuat : {{val.thread.tgldibuat}}</div>
                                                  <div>Harga : {{val.thread.harga}} / {{per[val.thread.kategori]}}</div>
                                                  <div>Jangka waktu penyelesaian : {{val.thread.jangkawaktu}} Hari</div>
                                              </div>
                                              <div style="width:100%">
                                                  <div>Status jasa : {{val.thread.status}}</div>
                                                  <div>Jumlah penaruh : {{val.thread.penaruh}}</div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
          
                          </div>
                           
                        </div>

                

                    </div>
              </div>
        </div>
        <Footer/>
        <ContainerChat :chatpayload="this.chatpayload" />
    </div>
</template>

<script>
import ContainerChat from "@/components/ContainerChat";
import Header from "@/components/Header";
import axios from "axios";
import Footer from "@/components/Footer";
import sideNav from "@/components/sideNav";
export default {
  components: {
    ContainerChat,
    Header,
    Footer,
    sideNav
  },
  watchQuery: ["kategori"],
  data() {
    return {
      chatpayload: [],
      kategori: [
        "Penerjemah",
        "Interpreter",
        "Terminologist",
        "Editor",
        "Subtitler",
        "Pelokal",
        "Leksikografer",
        "Linguis",
        "Manajerpenerjemahan",
        "Insinyurbahasa"
      ],
      editable: false,
      debug: null,
      pagination: {
        offset: 0,
        limit: 25,
        jumlahpage: null
      },
      editablethread: {
        judul: "",
        deskripsi: "",
        tags: [],
        harga: "",
        jangkawaktu: "",
        kategori: ""
      },
      data: [
        {
          user: {
            avatar: "",
            username: "terrificsubs",
            rating: 80,
            point: 0,
            ranking: "No Ranking",
            jumlahuser: 0
          },
          thread: {
            id: 1,
            judul: "Penulisan tentang implementasi Cryptocurrency",
            deskripsi:
              "Hi guys, Saya lagi mencari 1-2 penulis untuk website https://cerdaskan.id . Konten yang diperlukan berbahasa indonesia dan berhubungan dengan pendidikan (SMA-Kuliah-Keterampilan), sangat diharapkan memang minat dengan topik itu jadi enjoy selama penulisannya :) Budget: Base 8.000/konten - Negotiable lagi after 30 artikel depends on the skill, kalau cocok bisa permanen Kriteria: Bersedia start dengan komitmen deliver 30 konten Konten valid, mempunyai referensi dan dapat dipertanggungjawabkan Mengerti tata cara penulisan yang baik, wajib enak dibaca Tulis manual...",
            tags: ["Java", "Javascript", "Python", "Data Mining"],
            tgldibuat: "14/10/2012",
            harga: "50000",
            jangkawaktu: "5",
            status: "published",
            penaruh: "2",
            kategori: "Penerjemah"
          }
        },

        {
          user: {
            avatar: "",
            username: "terrificsubs",
            rating: 80,
            point: 0,
            ranking: "No Ranking"
          },
          thread: {
            id: 1,
            judul: "Penulisan tentang implementasi Cryptocurrency",
            deskripsi:
              "Hi guys, Saya lagi mencari 1-2 penulis untuk website https://cerdaskan.id . Konten yang diperlukan berbahasa indonesia dan berhubungan dengan pendidikan (SMA-Kuliah-Keterampilan), sangat diharapkan memang minat dengan topik itu jadi enjoy selama penulisannya :) Budget: Base 8.000/konten - Negotiable lagi after 30 artikel depends on the skill, kalau cocok bisa permanen Kriteria: Bersedia start dengan komitmen deliver 30 konten Konten valid, mempunyai referensi dan dapat dipertanggungjawabkan Mengerti tata cara penulisan yang baik, wajib enak dibaca Tulis manual...",
            tags: ["Java", "Javascript", "Python", "Data Mining"],
            tgldibuat: "14/10/2012",
            harga: "50000",
            jangkawaktu: "5",
            status: "published",
            penaruh: "2",
            kategori: "Penerjemah"
          }
        },

        {
          user: {
            avatar: "",
            username: "terrificsubs",
            rating: 80,
            point: 0,
            ranking: "No Ranking"
          },
          thread: {
            id: 1,
            judul: "Penulisan tentang implementasi Cryptocurrency",
            deskripsi:
              "Hi guys, Saya lagi mencari 1-2 penulis untuk website https://cerdaskan.id . Konten yang diperlukan berbahasa indonesia dan berhubungan dengan pendidikan (SMA-Kuliah-Keterampilan), sangat diharapkan memang minat dengan topik itu jadi enjoy selama penulisannya :) Budget: Base 8.000/konten - Negotiable lagi after 30 artikel depends on the skill, kalau cocok bisa permanen Kriteria: Bersedia start dengan komitmen deliver 30 konten Konten valid, mempunyai referensi dan dapat dipertanggungjawabkan Mengerti tata cara penulisan yang baik, wajib enak dibaca Tulis manual...",
            tags: ["Java", "Javascript", "Python", "Data Mining"],
            tgldibuat: "14/10/2012",
            harga: "50000",
            jangkawaktu: "5",
            status: "published",
            penaruh: "2",
            kategori: "Penerjemah"
          }
        }
      ],
      per: {
        Penerjemah: "Lembar"
      },
      contentIsLoaded: false,
      placeholder: [
        {
          user: {
            avatar: "",
            username: "terrificsubs",
            rating: 80,
            point: 0,
            ranking: "No Ranking"
          },
          thread: {
            id: 1,
            judul: "Penulisan tentang implementasi Cryptocurrency",
            deskripsi:
              "Hi guys, Saya lagi mencari 1-2 penulis untuk website https://cerdaskan.id . Konten yang diperlukan berbahasa indonesia dan berhubungan dengan pendidikan (SMA-Kuliah-Keterampilan), sangat diharapkan memang minat dengan topik itu jadi enjoy selama penulisannya :) Budget: Base 8.000/konten - Negotiable lagi after 30 artikel depends on the skill, kalau cocok bisa permanen Kriteria: Bersedia start dengan komitmen deliver 30 konten Konten valid, mempunyai referensi dan dapat dipertanggungjawabkan Mengerti tata cara penulisan yang baik, wajib enak dibaca Tulis manual...",
            tags: ["Java", "Javascript", "Python", "Data Mining"],
            tgldibuat: "14/10/2012",
            harga: "50000",
            jangkawaktu: "5",
            status: "published",
            penaruh: "2",
            kategori: "Penerjemah"
          }
        },

        {
          user: {
            avatar: "",
            username: "terrificsubs",
            rating: 80,
            point: 0,
            ranking: "No Ranking"
          },
          thread: {
            id: 1,
            judul: "Penulisan tentang implementasi Cryptocurrency",
            deskripsi:
              "Hi guys, Saya lagi mencari 1-2 penulis untuk website https://cerdaskan.id . Konten yang diperlukan berbahasa indonesia dan berhubungan dengan pendidikan (SMA-Kuliah-Keterampilan), sangat diharapkan memang minat dengan topik itu jadi enjoy selama penulisannya :) Budget: Base 8.000/konten - Negotiable lagi after 30 artikel depends on the skill, kalau cocok bisa permanen Kriteria: Bersedia start dengan komitmen deliver 30 konten Konten valid, mempunyai referensi dan dapat dipertanggungjawabkan Mengerti tata cara penulisan yang baik, wajib enak dibaca Tulis manual...",
            tags: ["Java", "Javascript", "Python", "Data Mining"],
            tgldibuat: "14/10/2012",
            harga: "50000",
            jangkawaktu: "5",
            status: "published",
            penaruh: "2",
            kategori: "Penerjemah"
          }
        },

        {
          user: {
            avatar: "",
            username: "terrificsubs",
            rating: 80,
            point: 0,
            ranking: "No Ranking"
          },
          thread: {
            id: 1,
            judul: "Penulisan tentang implementasi Cryptocurrency",
            deskripsi:
              "Hi guys, Saya lagi mencari 1-2 penulis untuk website https://cerdaskan.id . Konten yang diperlukan berbahasa indonesia dan berhubungan dengan pendidikan (SMA-Kuliah-Keterampilan), sangat diharapkan memang minat dengan topik itu jadi enjoy selama penulisannya :) Budget: Base 8.000/konten - Negotiable lagi after 30 artikel depends on the skill, kalau cocok bisa permanen Kriteria: Bersedia start dengan komitmen deliver 30 konten Konten valid, mempunyai referensi dan dapat dipertanggungjawabkan Mengerti tata cara penulisan yang baik, wajib enak dibaca Tulis manual...",
            tags: ["Java", "Javascript", "Python", "Data Mining"],
            tgldibuat: "14/10/2012",
            harga: "50000",
            jangkawaktu: "5",
            status: "published",
            penaruh: "2",
            kategori: "Penerjemah"
          }
        }
      ]
    };
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
    ikutTaruhan: function(idpermintaan, e) {
      e.target.disabled = true;
      if (this.$store.state.isLogged === false) {
        alert("Login terlebih dahulu!");
        e.target.disabled = false;
      } else {
        axios({
          url: "https://penerjemah.web.id/api/insert.php",
          method: "POST",
          headers: { "content-type": "application/x-www-form-urlencoded" },
          data: `params=${JSON.stringify({
            aksi: "ikutTaruhan",
            credentials: this.$store.state.login,
            id: idpermintaan
          })}`
        }).then(res => {
          console.log(res);
          if (res.data.status === "success") {
            alert("Berhasil bertaruh!");
            document.location.reload();
          } else {
            e.target.disabled = false;
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
    kirimHandler: function(e) {
      //alert(parseInt(this.editablethread.harga));
      if (
        this.editablethread.harga.match(/\D+/) ||
        this.editablethread.jangkawaktu.match(/\D+/) ||
        this.editablethread.tags.length === 0 ||
        this.editablethread.judul.length === 0 ||
        this.editablethread.harga.length === 0 ||
        this.editablethread.jangkawaktu.length === 0 ||
        document.querySelectorAll("#selectKategori")[0].selectedIndex === -1
      ) {
        alert("Masukkan semua data!");
      } else {
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
          url: "https://penerjemah.web.id/api/insert.php",
          method: "POST",
          headers: { "content-type": "application/x-www-form-urlencoded" },
          data: `params=${JSON.stringify({
            aksi: "membuatPermintaan",
            credentials: this.$store.state.login,
            bearer: {
              judul: this.editablethread.judul,
              deskripsi: deskripsi,
              kategori: this.kategori[
                document.querySelectorAll("#selectKategori")[0].selectedIndex
              ],
              harga: this.editablethread.harga,
              jangkawaktu: this.editablethread.jangkawaktu,
              label: this.editablethread.tags.join(",")
            }
          })}`
        }).then(res => {
          if (res.data.status === "success") {
            alert("Permintaan berhasil dibuat!");
            this.$router.go({ path: "/jelajahi/permintaan" });
          } else {
            e.target.disabled = false;
            alert("Terjadi kesalahan!");
          }
        });
      }
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
    buatPermintaan: function() {
      if (this.$store.state.isLogged === false) {
        alert("Login terlebih dahulu!");
      } else {
        this.editable = true;
      }
    },
    detailHandler: function(index, id, ev) {
      if (ev.target.classList.contains("clicked")) {
      } else {
        ev.target.classList.add("clicked");
        this.$router.push({ path: `/detail/permintaan/${id}` });
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
      //str = aw;
      if (str.length > 498) {
        str.match(/\S+/g).forEach(val => {
          if (retVal.length < 500) {
            retVal = retVal + " " + val;
          } else {
            retVal = retVal;
          }
        });
        return retVal + "...";
      } else {
        return str;
      }
    }
  },
  asyncData(context) {
    if (context.route.query.kategori) {
      return axios({
        url: "https://penerjemah.web.id/api/global_.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params={"aksi":"memuatkontenpermintaan-withcategory","limit":"25","offset":"0","kategori":"${
          context.route.query.kategori
        }"}`
      }).then(res => {
        return axios({
          url: "https://penerjemah.web.id/api/global_.php",
          method: "POST",
          headers: { "content-type": "application/x-www-form-urlencoded" },
          data: `params={"aksi":"memuattotalkontenpermintaan-withcategory","kategori":"${
            context.route.query.kategori
          }"}`
        }).then(res2 => {
          let jumlahpage = 0;
          let a = res2.data.data.total / 25;
          let b = a.toString();
          if (b.match(".")) {
            jumlahpage = Math.floor(a) + 1;
          } else {
            jumlahpage = a;
          }
          return {
            debug: context.route.query,
            contentIsLoaded: true,
            data: res.data,
            pagination: {
              limit: 25,
              offset: 0,
              jumlahpage: jumlahpage
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
      data: `params={"aksi":"memuatkontenpermintaan","limit":"${limit}","offset":"${offset}"}`
    }).then(res1 => {
      return axios({
        url: "https://penerjemah.web.id/api/global.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params={"aksi":"memuattotalkontenpermintaan"}`
      }).then(res2 => {
        if (res2.data.status === "ok") {
          let jumlahpage = 0;
          let a = res2.data.data.total / 25;
          let b = a.toString();
          if (b.match(".")) {
            jumlahpage = Math.floor(a) + 1;
          } else {
            jumlahpage = a;
          }
          return {
            debug: context.route.query,
            contentIsLoaded: true,
            data: res1.data,
            pagination: {
              limit: 25,
              offset: 0,
              jumlahpage: jumlahpage
            }
          };
        } else {
          return {};
        }
      });
    });
  },
  mounted() {
    let initialScroll = 0;
    console.log(this.data);
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
  }
};
</script>

<style scoped>
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

.halamanPencarianPermintaan {
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

.underlinedhover:hover {
  text-decoration: underline;
}
</style>
