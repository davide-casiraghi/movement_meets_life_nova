import './bootstrap';
import './tipped-global';
import './jquery-plugins';

// Load vendor libraries
import 'justifiedGallery';
import '@fancyapps/fancybox';
import 'bootstrap-datepicker';
import 'slick-carousel';
import 'livewire-sortable';
import 'flatpickr';

// Load my scripts related to vendor libraries
// TinyMCE is big: load it (as a separate chunk) only on the pages that have an editor
if (document.querySelector('.textarea_tinymce')) {
    import('./vendors/tinymce');
}
import './vendors/select2';
import './vendors/slick_carousel';
import './forms/uploadImage';
import './video_embed';
import './vendors/gallery_mansonry';
import './vendors/bootstrap-datepicker';
import './vendors/staaky_tipped';
import './vendors/flatpickr';

// Helpers
import './snippets/accordion';
