require('./bootstrap');

// Load vendor libraries
require('alpinejs');
require('justifiedGallery');
require("@fancyapps/fancybox");
require('bootstrap-datepicker');
require('select2');
require('slick-carousel');
require('livewire-sortable')
//require('trix');

// Load my scripts related to vendor libraries
require('./vendors/tinymce');
require('./vendors/select2');
require('./vendors/slick_carousel');
require('./forms/uploadImage');
//require("@staaky/tipped"); //imported in bootstrap.js
require('./video_embed');
require('./vendors/gallery_mansonry');
require('./vendors/bootstrap-datepicker');
require('./vendors/staaky_tipped');

// Helpers
require('./snippets/accordion');
