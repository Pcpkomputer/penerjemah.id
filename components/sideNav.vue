<template>
                    <div class="col-lg-4 col-md-12 col-sm-12 sideBarNav" style="padding:0px;padding-left:15px">
                            <div v-on:click="sidebarHandler($event,`jelajahiPermintaanDrawer`)" class="sidebarComponent">Jelajahi Permintaan</div>
                            <div id="jelajahiPermintaan-List" style="overflow-y:hidden;" v-bind:class="{terbuka:this.$store.state.sideNavbar.permintaan.terbuka}" v-bind:style="{'height':`${this.$store.state.sideNavbar.permintaan.height}`}">
                                <div style="padding:10px">
                                <ul>
                                  <li><nuxt-link :to="{ path: '/jelajahi/permintaan/?kategori=Penerjemah'}">Penerjemah (translator) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/permintaan/?kategori=Interpreter'}">Juru bahasa (interpreter) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/permintaan/?kategori=Terminologist'}">Juru istilah (terminologist) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/permintaan/?kategori=Editor'}">Editor terjemahan (editor) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/permintaan/?kategori=Subtitler'}">Penerjemah film (subtitler) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/permintaan/?kategori=Pelokal'}">Pelokal (localizor) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/permintaan/?kategori=Leksikografer'}">Leksikografer (lexicographer)</nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/permintaan/?kategori=Linguis'}">Linguis (linguist) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/permintaan/?kategori=Manajerpenerjemahan'}">Manajer penerjemahan (project manager) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/permintaan/?kategori=Insinyurbahasa'}">Insinyur bahasa (langugage engineer) </nuxt-link></li>
                                </ul>
                                </div>
                            </div>

                            <div v-on:click="sidebarHandler($event,`jelajahiJasaDrawer`)" class="sidebarComponent">Jelajahi Jasa</div>
                            <div id="jelajahiJasa-List" style="overflow-y:hidden;" v-bind:class="{terbuka:this.$store.state.sideNavbar.jasa.terbuka}" v-bind:style="{'height':`${this.$store.state.sideNavbar.jasa.height}`}">
                                <div style="padding:10px">
                                <ul>
                                 <li><nuxt-link :to="{ path: '/jelajahi/jasa/?kategori=Penerjemah'}">Penerjemah (translator) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/jasa/?kategori=Interpreter'}">Juru bahasa (interpreter) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/jasa/?kategori=Terminologist'}">Juru istilah (terminologist) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/jasa/?kategori=Editor'}">Editor terjemahan (editor) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/jasa/?kategori=Subtitler'}">Penerjemah film (subtitler) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/jasa/?kategori=Pelokal'}">Pelokal (localizor) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/jasa/?kategori=Leksikografer'}">Leksikografer (lexicographer)</nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/jasa/?kategori=Linguis'}">Linguis (linguist) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/jasa/?kategori=Manajerpenerjemahan'}">Manajer penerjemahan (project manager) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/jasa/?kategori=Insinyurbahasa'}">Insinyur bahasa (langugage engineer) </nuxt-link></li>
                                </ul>
                                </div>
                            </div>

                            
                            <div v-on:click="sidebarHandler($event,`jelajahiUserDrawer`)" class="sidebarComponent">Jelajahi User</div>
                             <div id="jelajahiUser-List" style="overflow-y:hidden" v-bind:class="{'terbuka':this.$store.state.sideNavbar.user.terbuka}" v-bind:style="{'height':`${this.$store.state.sideNavbar.user.height}`}">
                                <div style="padding:10px">
                                <ul>
                                <li><nuxt-link :to="{ path: '/jelajahi/user/?kategori=Penerjemah'}">Penerjemah (translator) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/user/?kategori=Interpreter'}">Juru bahasa (interpreter) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/user/?kategori=Terminologist'}">Juru istilah (terminologist) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/user/?kategori=Editor'}">Editor terjemahan (editor) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/user/?kategori=Subtitler'}">Penerjemah film (subtitler) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/user/?kategori=Pelokal'}">Pelokal (localizor) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/user/?kategori=Leksikografer'}">Leksikografer (lexicographer)</nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/user/?kategori=Linguis'}">Linguis (linguist) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/user/?kategori=Manajerpenerjemahan'}">Manajer penerjemahan (project manager) </nuxt-link></li>
                                  <li><nuxt-link :to="{ path: '/jelajahi/user/?kategori=Insinyurbahasa'}">Insinyur bahasa (langugage engineer) </nuxt-link></li>
                                </ul>
                            </div>
                          </div>
      
                        </div>
</template>

<script>
export default {
  data() {
    return {
      height: "0px"
    };
  },
  beforeMount() {},
  methods: {
    sidebarHandler: function(e, str) {
      if (str === "jelajahiPermintaanDrawer") {
        if (
          document
            .querySelectorAll("#jelajahiPermintaan-List")[0]
            .classList.contains("terbuka")
        ) {
          document
            .querySelectorAll("#jelajahiPermintaan-List")[0]
            .classList.remove("slideKebawah");
          document
            .querySelectorAll("#jelajahiPermintaan-List")[0]
            .classList.add("slideKeatas");
          //document.querySelectorAll("#jelajahiPermintaan-List")[0].classList.remove("terbuka");
          setTimeout(() => {
            this.$store.commit("sidebarnavPermintaan", "0px");
            this.$store.commit("sidebarnavPermintaanTerbuka", false);
          }, 500);
        } else {
          document
            .querySelectorAll("#jelajahiPermintaan-List")[0]
            .classList.remove("slideKeatas");
          document
            .querySelectorAll("#jelajahiPermintaan-List")[0]
            .classList.add("slideKebawah");
          //document.querySelectorAll("#jelajahiPermintaan-List")[0].classList.add("terbuka");
          setTimeout(() => {
            this.$store.commit("sidebarnavPermintaan", "210px");
            this.$store.commit("sidebarnavPermintaanTerbuka", true);
          }, 500);
        }
      }

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
          //document.querySelectorAll("#jelajahiPermintaan-List")[0].classList.remove("terbuka");
          setTimeout(() => {
            this.$store.commit("sidebarnavJasa", "0px");
            this.$store.commit("sidebarnavJasaTerbuka", false);
          }, 500);
        } else {
          document
            .querySelectorAll("#jelajahiJasa-List")[0]
            .classList.remove("slideKeatas");
          document
            .querySelectorAll("#jelajahiJasa-List")[0]
            .classList.add("slideKebawah");
          //document.querySelectorAll("#jelajahiPermintaan-List")[0].classList.add("terbuka");
          setTimeout(() => {
            this.$store.commit("sidebarnavJasa", "210px");
            this.$store.commit("sidebarnavJasaTerbuka", true);
          }, 500);
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
          //document.querySelectorAll("#jelajahiUser-List")[0].classList.remove("terbuka");
          setTimeout(() => {
            this.$store.commit("sidebarnavUser", "0px");
            this.$store.commit("sidebarnavUserTerbuka", false);
          }, 500);
        } else {
          document
            .querySelectorAll("#jelajahiUser-List")[0]
            .classList.remove("slideKeatas");
          document
            .querySelectorAll("#jelajahiUser-List")[0]
            .classList.add("slideKebawah");
          //document.querySelectorAll("#jelajahiUser-List")[0].classList.add("terbuka");
          setTimeout(() => {
            this.$store.commit("sidebarnavUser", "210px");
            this.$store.commit("sidebarnavUserTerbuka", true);
          }, 500);
        }
      }
    }
  },
  mounted() {}
};
</script>

<style scoped>
div {
  cursor: default;
}

.listSidebar {
}

a {
  color: black;
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