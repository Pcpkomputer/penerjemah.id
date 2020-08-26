<template>
 <div class="halamanPencarianUser" style="background-color:#f2f2f2;overflow-x:hidden">
        <Header/>
            <div class="container-fluid" style="padding:0px;margin-top:10px;margin-bottom:10px;">
              <div class="container" style="padding-left:5px">
                    <div class="row" style="padding:10px;padding-right:13px">


                        <sideNav/>

                        <div class="col-lg-8 col-md-12 col-md-12" style="padding-right:2px;">
                          <div style="font-size:28px;padding:10px;border-bottom:solid 1px;padding-left:0px;padding-bottom:5px;">Jelajahi User</div>

                           <div v-if="contentIsLoaded" style="padding-top:5px;padding-bottom:5px;border-bottom:solid 1px;display:flex;flex-direction:row;justify-content:flex-end">
                              <div style="display:flex;flex-direction:row;padding:5px">
                                <div id="toKiri" style="background-color:#006bc2;color:white;padding:5px;margin-right:4px"><<</div>
                                <div class="parentPagination" style="display:flex;flex-direction:row;width:184px;"> 
                                  <div :class="`numberPagination ${(i===1 ? 'checked':'')}`" v-for="i in this.pagination.totalhalaman" :key="i" style="padding:5px;">1</div>
                                </div>
                                <div id="toKanan" style="background-color:#006bc2;padding:5px;margin-left:0px;color:white">>></div>
                              </div>
                          </div>

                          
                             <div v-else style="padding-top:5px;padding-bottom:7px;border-bottom:solid 1px;display:flex;flex-direction:row;justify-content:flex-end">
                            
                              <div style="display:flex;flex-direction:row;padding:5px;background-color:#e4e4e4;color:#e4e4e4;cursor:default;height:30px;margin-top:4px;" class="placeholder">
                                <div class="parentPagination" style="display:flex;flex-direction:row;width:184px"> 
                                  
                                </div>
                              </div>
                          </div>

 
                          <div v-if="!contentIsLoaded" v-for="i in 3" v-bind:key="i" style="margin-top:20px">
                            <div style="border-bottom:solid 1px;padding-bottom:40px;padding-left:25px">
                              <div style="margin-bottom:15px;display:flex;justify-content:flex-end">
                                  <div class="tmblBiru fadeEffect placeholder" style="width:50px;height:29px;padding:5px;padding-right:7px;padding-left:7px;background-color:#e4e4e4;color:#e4e4e4;cursor:default;"></div>
                              </div>
                              <div style="display:flex">

                                  <div style="width:200px;height:150px;color:#e4e4e4;background-color:#e4e4e4" class="placeholder"></div>
                                  <div style="margin-left:20px;width:100%">
                                       <div class="placeholder" style="font-size:23px;width:120px;height:26px;color:#e4e4e4;background-color:#e4e4e4"></div>
                                       <div class="placeholder" style="margin-bottom:3px;height:13px;width:100px;color:#e4e4e4;background-color:#e4e4e4;margin-top:5px"></div>
                                       <div class="placeholder" style="margin-bottom:6px;color:#e4e4e4;background-color:#e4e4e4;margin-top:5px;width:100px;height:13px"></div>
                                       <div class="placeholder" style="background-color:#e4e4e4;margin-top:5px;width:40px;height:13px"></div>
                                  </div>
                              </div>
                            </div>
                          </div>

                          <div v-if="contentIsLoaded" v-for="(val,i) in this.user" v-bind:key="i" style="margin-top:20px">
                            <div style="border-bottom:solid 1px;padding-bottom:40px;padding-left:25px">
                              <div style="margin-bottom:15px;display:flex;justify-content:flex-end">
                                  <div class="tmblBiru fadeEffect" style="padding:5px;padding-right:7px;padding-left:7px" v-on:click="detailHandler(val.user)">Lihat</div>
                              </div>
                              <div style="display:flex">

                                  <div style="width:200px;height:150px;border:solid 1px"><img :src="`http://localhost/penerjemah.id/server/assets/avatar/${val.avatar}`" style="width:100%;height:100%"></div>
                                  <div style="margin-left:20px;width:100%">
                                       <div style="font-size:23px" class="underlined" v-on:click="detailHandler(val.user)">{{val.user}}</div>
                                       <div style="margin-bottom:3px">Reputasi User :</div>
                                       <div style="margin-bottom:6px" v-html="ratingHandler(val.reputasi)"></div>
                                       <div>{{val.reputasi}}/100</div>
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
import ContainerChat from "@/components/ContainerChat";
import Footer from "@/components/Footer";
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
  mounted() {
    console.log(this.user);
  },
  asyncData(context) {
    if (context.route.query.kategori) {
      return axios({
        url: "http://localhost/penerjemah.id/server/api/global_.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params={"aksi":"memuatkontenuser-withcategory","limit":"25","offset":"0","kategori":"${
          context.route.query.kategori
        }"}`
      }).then(res1 => {
        return axios({
          url: "http://localhost/penerjemah.id/server/api/global_.php",
          method: "POST",
          headers: { "content-type": "application/x-www-form-urlencoded" },
          data: `params={"aksi":"memuattotaluser-withcategory","kategori":"${
            context.route.query.kategori
          }"}`
        }).then(res2 => {
          let total = parseInt(res2.data.total) / 25;
          total = total.toString();
          if (total.match(".")) {
            total = Math.floor(parseInt(total)) + 1;
          } else {
            total = parseInt(total);
          }

          return {
            user: res1.data,
            contentIsLoaded: true,
            pagination: {
              limit: 25,
              offset: 0,
              totalhalaman: total
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
      url: "http://localhost/penerjemah.id/server/api/global.php",
      method: "POST",
      headers: { "content-type": "application/x-www-form-urlencoded" },
      data: `params={"aksi":"memuatkontenuser","limit":"${limit}","offset":"${offset}"}`
    }).then(res1 => {
      return axios({
        url: "http://localhost/penerjemah.id/server/api/global.php",
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: `params={"aksi":"memuattotaluser"}`
      }).then(res2 => {
        let total = res2.data.total / 25;
        total = total.toString();
        if (total.match(".")) {
          total = Math.floor(parseInt(total)) + 1;
        } else {
          total = parseInt(total);
        }

        return {
          user: res1.data,
          contentIsLoaded: true,
          pagination: {
            limit: 25,
            offset: 0,
            totalhalaman: total
          }
        };
      });
    });
  },
  watchQuery: ["kategori"],
  data: function() {
    return {
      chatpayload: [],
      pagination: {
        limit: 25,
        offset: 0,
        totalhalaman: 0
      },
      contentIsLoaded: false,
      user: []
    };
  },
  methods: {
    detailHandler: function(id) {
      this.$router.push({ path: `/detail/user/${id}` });
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

a {
  color: white;
  text-decoration: none;
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

.underlined:hover {
  cursor: pointer;
  text-decoration: underline;
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
