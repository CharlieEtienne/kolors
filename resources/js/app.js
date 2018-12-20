
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// Boostrap
require('./bootstrap');

// VueJS
window.Vue = require('vue');

// JQuery UI
import 'jquery-ui/ui/widgets/sortable.js';
import 'jquery-ui/ui/widgets/droppable.js';

// ClipboardJS
window.ClipboardJS = require('clipboard');

// Toastr
window.toastr = require('toastr');

// Contrast function
window.contrast = function contrast(hex){
    var threshold = 130;
    
    var red     = hexToR(hex);
    var green   = hexToG(hex);
    var blue    = hexToB(hex);        

    function hexToR(h) {return parseInt((cutHex(h)).substring(0,2),16)}
    function hexToG(h) {return parseInt((cutHex(h)).substring(2,4),16)}
    function hexToB(h) {return parseInt((cutHex(h)).substring(4,6),16)}
    function cutHex(h) {return (h.charAt(0)=="#") ? h.substring(1,7):h}

    var brightness = ((red * 299) + (green * 587) + (blue * 114)) / 1000;
    if (brightness > threshold) {
        return "#000000";
    } 
    else { 
        return "#ffffff";
    }	
};


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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
