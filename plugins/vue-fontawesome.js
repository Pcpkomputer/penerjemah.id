import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faComments, faWrench, faCoins, faUserSecret, faEnvelope, faSignInAlt, faQuestion, faUsers, faSignOutAlt, faUser } from '@fortawesome/free-solid-svg-icons'
import { faPhone } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faUserSecret);
library.add(faCoins);
library.add(faPhone);
library.add(faWrench);
library.add(faEnvelope);
library.add(faSignInAlt);
library.add(faQuestion);
library.add(faUsers);
library.add(faSignOutAlt);
library.add(faUser);
library.add(faComments);



Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false
