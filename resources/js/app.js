import './bootstrap';

// Small scripts used on many pages: always loaded
import 'livewire-sortable'; // Livewire directive: must be registered before Livewire starts
import './video_embed';
import './forms/uploadImage';
import './snippets/accordion';

/**
 * The vendor libraries are loaded (as separate chunks) only on the pages that use them,
 * so the public pages don't download the admin libraries (editor, selects, date pickers).
 * Each module imports its own library and initializes the elements on the page.
 */
const pageHas = (selector) => document.querySelector(selector) !== null;

if (pageHas('.textarea_tinymce')) import('./vendors/tinymce');
if (pageHas('.select2, .select2-multiple')) import('./vendors/select2');
if (pageHas('.datepicker, .datepickerMultiple')) import('./vendors/bootstrap-datepicker');
if (pageHas('.flatpickr')) import('./vendors/flatpickr');
if (pageHas('.testimonialsList')) import('./vendors/slick_carousel');
if (pageHas('.postsCarousel')) import('./vendors/posts_carousel');
if (pageHas('.lifeGallery')) import('./vendors/gallery_mansonry');
if (pageHas('[data-fancybox]')) import('@fancyapps/fancybox');
if (pageHas('.has-glossary-term')) import('./vendors/staaky_tipped');
