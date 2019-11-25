/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
Vue.config.silent = true
import BootstrapVue from 'bootstrap-vue'
import VueFullCalendar from '@fullcalendar/vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'rrule/dist/es5/rrule.js';


Vue.use(BootstrapVue)
Vue.use(VueFullCalendar)

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
Vue.component('users-component', require('./components/UsersComponent.vue').default);
Vue.component('eventos-component', require('./components/EventosComponent.vue').default);

import $ from 'jquery';
import 'jquery-ui/ui/i18n/datepicker-es'
import 'jquery-datetimepicker/build/jquery.datetimepicker.full.js'
import moment from 'moment/moment.js'
import 'select2/dist/js/select2.full.js'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$("#datepicker").datetimepicker({
    format: 'd/m/Y',
    timepicker:false});
$("#datetimepicker").datetimepicker({
    format: 'd/m/Y H:i',
});

$("#datepicker").attr('autocomplete','off');
$("#datetimepicker").attr('autocomplete','off');
$("#from").attr('autocomplete','off');
$("#to").attr('autocomplete','off');



$(function () {
    var from = $("#from")
        .datetimepicker({
            format: 'd/m/Y H:i',
            closeOnTimeSelect: true,
            step: 10,
        })
        .on("change", function () {
            to.datetimepicker("setOptions", {
                minDate: moment(this.value,"DD/MM/YYYY HH:mm").format("YYYY-MM-DD"),
                minTime: moment(this.value,"DD/MM/YYYY HH:mm").format("HH:mm:ss")
            });
        }),
    to = $("#to").datetimepicker({
        format: 'd/m/Y H:i',
        closeOnTimeSelect: true,
        step: 10,
    })
        .on("change", function () {
            from.datetimepicker("setOptions", {
                maxDate: moment(this.value,"DD/MM/YYYY HH:mm").format("YYYY-MM-DD"),
                maxTime: moment(this.value,"DD/MM/YYYY HH:mm").format("HH:mm:ss")
            });
        });

});