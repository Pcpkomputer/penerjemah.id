<template>
    <div style="position:fixed;display:flex;align-items:center;justify-content:flex-end;bottom:0px;width:100%;height:2rem">
        <div id="containerChat" style="display:flex;justify-content:flex-end;align-items:center;width:100%;height:100%">

                                 
             <div v-for="(val,i) in this.currentchat" :key="i" v-on:click="clickBarChat($event)" :id="val.id" style="cursor:pointer;background-color:white;height:100%;display:flex;align-items:center;padding-right:10px;padding-left:10px;width:14rem;border:solid 1px rgb(171, 170, 170)">
                <div id="isiChat" @click.stop="clickBarChat()" @click.stop.prevent="clickBarChat()"  style="border:1px solid rgb(171, 170, 170);position:absolute;background-color:white;width:14rem;padding:10px;margin-left:-11px;height:250px;margin-top:-141px;">
                    <div style="height:205px;overflow-y:scroll">
                    <div v-for="(res,index) in val.isichat" :key="index"><b>{{res.pengirim}} : </b>{{res.pesan}}</div>
                    </div>
                </div>
                <div id="textBoxChat" style="position:absolute;margin-top:-35px;"><input v-on:keyup.enter="kirimChat($event,val.id,i)" type="text" placeholder="isi pesan" style="width:200px;border:0px;border-bottom:solid 1px"></div>
                <div>{{val.id}}</div>
                
            </div>


        </div>
         <div style="display:flex;justify-content:center;align-items:center;width:40px;background-color:white;border:solid 1px rgb(171, 170, 170);height:100%">
            <font-awesome-icon style="height:18px;color:#828282;width:18px;margin-bottom:1px;margin-left:4px;margin-right:4px" icon="comments"/>
        </div>
    </div>
</template>

<script>
export default {
  props: ["chatpayload"],
  mounted() {
    if (this.$store.state.isLogged === true) {
      this.socket = new WebSocket(
        `ws://idpenerjemahsocket.herokuapp.com/?username=${
          this.$store.state.login.username
        }`
      );

      this.socket.onopen = () => {
        this.canMessage = true;
      };

      this.socket.onmessage = res => {
        let parsed = JSON.parse(res.data);
        console.log(res.data);
        if (parsed.context === "mendapatPesan") {
          let ketemu = false;
          this.currentchat.map(res => {
            if (res.id === parsed.data.from) {
              ketemu = true;
            }
          });

          if (ketemu === true) {
            let idchat = null;
            this.currentchat.map((res, index) => {
              if (res.id === parsed.data.from) {
                idchat = index;
              }
            });

            this.currentchat[idchat].isichat.push({
              pengirim: parsed.data.from,
              pesan: parsed.data.isipesan
            });
          } else {
            this.currentchat.push({
              id: parsed.data.from,
              isichat: [
                {
                  pengirim: parsed.data.from,
                  pesan: parsed.data.isipesan
                }
              ]
            });
          }
        }
      };
    }
  },
  data() {
    return {
      socket: "",
      canMessage: false,
      currentchat: this.chatpayload
    };
  },
  methods: {
    prevent: function(e) {
      e.target.preventDefault();
    },
    kirimChat: function(e, username, index) {
      if (e.target.value.length !== 0) {
        //alert(username);
        this.socket.send(
          JSON.stringify({
            context: "kirimPesan",
            to: {
              username: username,
              isipesan: e.target.value
            }
          })
        );

        this.currentchat[index].isichat.push({
          pengirim: "Kamu",
          pesan: e.target.value
        });

        e.target.value = "";
      }
    },
    clickBarChat: function(e) {
      try {
        if (e.target.querySelector("#isiChat").style.display === "none") {
          e.target.querySelector("#isiChat").style.display = "";
          e.target.querySelector("#textBoxChat").style.display = "";
        } else {
          e.target.querySelector("#isiChat").style.display = "none";
          e.target.querySelector("#textBoxChat").style.display = "none";
        }
      } catch (error) {}
    }
  }
};
</script>