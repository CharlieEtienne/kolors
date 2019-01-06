
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

// Static Edit (by @thomasruiz)
window.StaticEdit = require('static-edit');

// Polyfill
require('keyboardevent-key-polyfill').polyfill();

// CodeMirror
window.CodeMirror = require('codemirror');
import 'codemirror/mode/htmlembedded/htmlembedded.js';
import 'codemirror/mode/htmlmixed/htmlmixed.js';
import 'codemirror/mode/css/css.js';
import 'codemirror/mode/javascript/javascript.js';
import 'codemirror/addon/scroll/simplescrollbars.js';
import 'codemirror/addon/search/search.js';
import 'codemirror/addon/search/searchcursor.js';
import 'codemirror/addon/search/match-highlighter.js';
import 'codemirror/addon/mode/overlay.js';

// Vue Color Pickers Tools
import { Photoshop,Chrome,Compact,Material,Sketch,Slider,Swatches } from 'vue-color'

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
    $('[data-popover="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    $('[data-tooltip="tooltip"]').tooltip({ trigger: "hover" });
});

// Typescript color tool
var tinycolor = require("tinycolor2");

// Based on Chamarel work (https://github.com/praveenpuglia/chamarel)
var regex = {
    "rgb" : /(rgba?\((\d+),\s*(\d+),\s*(\d+),?\s*(\d*(?:\.\d+)?)\))/g,
    "hex" : /(#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3}))/g,
    "hsl" : /(hsla?\((\d+),\s*([\d.]+)%,\s*([\d.]+)%,?\s*(\d*(?:\.\d+)?)\))/g
};

var fullRegex = /((rgba?\((\d+),\s*(\d+),\s*(\d+),?\s*(\d*(?:\.\d+)?)\))|(#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3}))|(hsla?\((\d+),\s*([\d.]+)%,\s*([\d.]+)%,?\s*(\d*(?:\.\d+)?)\)))/;

function parseCss(css){
    var rgbColors = getColors(css,"rgb");
    var hexColors = getColors(css,"hex");
    var hslColors = getColors(css,"hsl");
    return rgbColors.concat(hexColors,hslColors);
}
function getColors(css,type){
    var m;
    var ca = [];
    var re = regex[type];
    do {
        m = re.exec(css);
        if (m) {
            ca.push(m[1]);
        }
    } while (m);
    return Array.from( new Set( ca ) );
}

CodeMirror.defineMode("kolors", function(config, parserConfig) {
    var kolorsOverlay = {
    //   token: function(stream, state) {
    //       console.log(stream);
    //     //var colorsInStream = '/' + fullRegex.exec(stream.string);
    //     if (stream.match(fullRegex)) {
    //         return "kolors";
    //     }

    //     while (stream.next() != null && !stream.match(fullRegex)) {}
    //     return null;
    //     // parseCss(stream).map(function(value){
    //     //     return "kolors";
    //     // });
    //     // return null;
    //   }
      token: function(stream, state) {
        var ch;
        if (stream.match(fullRegex)) {
            return "kolors"
        }
        while (stream.next() != null && !stream.match(fullRegex, false)) {}
        return null;
      }
    };
    return CodeMirror.overlayMode(CodeMirror.getMode(config, parserConfig.backdrop || "htmlmixed"), kolorsOverlay);
});

window.getAllColors = function getAllColors(codeStr) {

    var allColors = [];
    var index = 0;
    parseCss(codeStr).map(function(value){
        var clr = tinycolor(value);
        if (clr.isValid()) {
            var color = {
                'index'     : index,
                'original'  : clr.getOriginalInput(),
                'hex'       : (clr.getAlpha() < 1) ? clr.toHex8String() : clr.toHexString(),
                'rgb'       : clr.toRgbString(),
                'hsl'       : clr.toHslString(),
                'name'      : clr.toName()
            };
            allColors.push(color);
        }
        ++index;
    });

    return allColors;
}


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

let defaultProps = {
    hex: '#194d33e6',
    hsl: {
      h: 150,
      s: 0.5,
      l: 0.2,
      a: 0.9
    },
    hsv: {
      h: 150,
      s: 0.66,
      v: 0.30,
      a: 0.9
    },
    rgba: {
      r: 25,
      g: 77,
      b: 51,
      a: 0.9
    },
    a: 0.9
  }

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        'material-picker': Material,
        'compact-picker': Compact,
        'swatches-picker': Swatches,
        'slider-picker': Slider,
        'sketch-picker': Sketch,
        'chrome-picker': Chrome,
        'photoshop-picker': Photoshop
    },
    data () {
        return {
            colors: defaultProps,
            state: {
                ColorEdit: false,
            }
        }
    },
    computed: {
        bgc () {
            return this.colors.hex8
        }
    },
    methods: {
        onOk () {
            console.log('ok')
        },
        onCancel () {
            console.log('cancel')
        },
        updateValue (value) {
            this.colors = value
        },
        edit: function() {
            this.edit = this.edit.show('fast');
        }
    },
    created () {
    }
});
