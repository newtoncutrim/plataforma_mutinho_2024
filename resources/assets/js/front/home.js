
import Vue from 'vue'
import TheBanner from './TheBanner.vue'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
import Swal from 'sweetalert2/dist/sweetalert2.js'
import TheLogin from './TheLogin.vue'
import TheCustomer from './TheCustomer.vue'

window.Vue = Vue
Vue.use(VueSweetalert2)
Vue.component('the-login', TheLogin)
Vue.component('the-banner', TheBanner)
Vue.component('the-customer', TheCustomer)
const Toast = Swal.mixin({
  toast: true,
  position: 'top',
  timer: 1500,
  showConfirmButton: true,
})
window.Toast = Toast
const app = new Vue({
  el: '#app',
})

