require('./bootstrap');
import 'material-design-icons-iconfont/dist/material-design-icons.css' // Ensure you are using css-loader
import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader
import Vue from 'vue'
import Vuetify from 'vuetify'
import Notifications from 'vue-notification'
import VueProgressBar from 'vue-progressbar';
import router from './router';


Vue.use(Notifications)
const options = {
    color: '#b73a3f',
    failedColor: '#874b4b',
    thickness: '15px',
    transition: {
        speed: '0.2s',
        opacity: '1s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}

Vue.use(VueProgressBar, options)

Vue.use(Vuetify, {
    iconfont: 'fa'
})

import 'vuetify/dist/vuetify.min.css'

//import 'vuetify/src/stylus/main'

const app = new Vue({
    el: '#app',
    router,
});
