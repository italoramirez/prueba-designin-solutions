import {createApp} from 'vue'
import {createPinia} from 'pinia'
import App from './App.vue'
import router from './router/router'
import useFetchDefault from './plugins/useFetch'
import {useAuthStore} from './stores/auth.store'
import * as Vue from 'vue'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import axios from 'axios'
import VueAxios from 'vue-axios'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
const vuetify = createVuetify({
    components,
    directives,
})

const app = createApp(App)

app.use(createPinia())
app.use(useFetchDefault, {
    authStore: useAuthStore(),
    router: router
})
app.use(vuetify)
app.use(VueAxios, axios)
app.provide('axios', app.config.globalProperties.axios)
app.use(router)
app.use(VueSweetalert2);
window.Swal =  app.config.globalProperties.$swal
app.mount('#app')
