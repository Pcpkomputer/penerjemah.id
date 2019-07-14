import Vuex from "vuex";
import axios from 'axios';

const createStore = () => {
    return new Vuex.Store({
        state: {

            notifikasiSudahDilihat: false,
            notifikasi: [],
            debug: null,
            isLogged: false,
            login: {
                id_user: null,
                username: null,
                token: null,
                avatar: null,
                namalengkap: null,
                rating: 0
            },
            sideNavbar: {
                jasa: {
                    terbuka: false,
                    height: "0px"
                },
                permintaan: {
                    terbuka: false,
                    height: "0px"
                },
                user: {
                    terbuka: false,
                    height: "0px"
                }
            }
        },
        actions: {
            nuxtServerInit({ commit, state }, { req }) {
                if (req && req.headers && req.headers.cookie) {
                    if (state.isLogged === false && req.headers.cookie.match(/auth=[^;]+/)) {
                        let p = decodeURI(req.headers.cookie.match(/auth=([^;]+)/)[1]).replace(/%3A/g, ":");
                        p = p.replace(/%2C/g, ",");
                        let parse = JSON.parse(p);
                        axios({
                            method: "POST",
                            url: "https://penerjemah.web.id/api/logic.php",
                            headers: { "content-type": "application/x-www-form-urlencoded" },
                            data: `params=${JSON.stringify({
                                aksi: "checkcredentials",
                                username: parse.username,
                                id_user: parse.id_user,
                                token: parse.token
                            })}`
                        }).then((res) => {
                            if (res.data.status === "success") {
                                commit("isLogged", true);
                                //commit("debug", "my pepe hard");
                                commit("updateCredentials", {
                                    username: parse.username,
                                    id_user: parse.id_user,
                                    token: parse.token,
                                    avatar: parse.avatar,
                                    namalengkap: parse.namalengkap,
                                    rating: parse.rating
                                });
                            }
                            else {
                                commit("isLogged", false);
                            }
                        }).catch((err) => {
                            commit("isLogged", false)
                        })

                    }
                }

            }
        },
        modules: {

        },
        mutations: {
            setNotifikasiSudahDilihat(state, ob) {
                state.notifikasiSudahDilihat = ob;
            },
            setNotifikasi(state, obj) {
                state.notifikasi = obj;
            },
            updateCredentials(state, obj) {
                state.login = obj;
            },
            isLogged(state, bool) {
                state.isLogged = bool;
            },
            debug(state, obj) {
                state.debug = obj;
            },
            sidebarnavPermintaanTerbuka(state, bool) {
                state.sideNavbar.permintaan.terbuka = bool;
            },
            sidebarnavUserTerbuka(state, bool) {
                state.sideNavbar.user.terbuka = bool;
            },
            sidebarnavJasaTerbuka(state, bool) {
                state.sideNavbar.jasa.terbuka = bool;
            },
            sidebarnavPermintaan(state, height) {
                state.sideNavbar.permintaan.height = height;
            },
            sidebarnavJasa(state, height) {
                state.sideNavbar.jasa.height = height;
            },
            sidebarnavUser(state, height) {
                state.sideNavbar.user.height = height;
            }
        }
    });
};

export default createStore;
