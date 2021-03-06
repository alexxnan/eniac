/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import { Form, HasError, AlertError } from 'vform'
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import Swal from 'sweetalert2';

import Gate from "./Gate.js";
Vue.prototype.$gate = new Gate(window.user);

Vue.component('not-found', ()=> import('./components/NotFound.vue'));
Vue.component('pagination', ()=> import('laravel-vue-pagination'));

// SWEETALERT Alerta
window.Swal=Swal;
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});
window.toast=toast;


window.form = Form
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)






import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/factura', component: require('./components/Factura.vue').default },
    { path: '/orders', component: require('./components/Orders.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default },
]


const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})




Vue.filter('upText',function (text){
    return text.charAt(0).toUpperCase()+text.slice(1);
});
Vue.filter ('myDate',function (created){
    return moment(created).format('DD.MM.YYYY')
})
 //custom event pentru cerere HTTP

window.Fire = new Vue();

//Vue ProgressBar

const options = {
    color: '#00ba27',
    failedColor: '#980303',
    thickness: '10px',
    transition: {
        speed: '1.5s',
        opacity: '0.5s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}

Vue.use(VueProgressBar, options);




/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('dashboard', require('./components/Dashboard.vue'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data:{
        search:'',
    },
    methods:{
        searchIt:_.debounce(()=>{
            console.log("Cautam...");
            Fire.$emit('Cautare');
        },1000),
        printme() {
            window.print();
        }
    }
});
