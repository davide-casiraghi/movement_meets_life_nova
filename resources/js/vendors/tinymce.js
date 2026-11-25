/**
 * TinyMCE 8 editor (self-hosted, bundled with Vite).
 * Used by the textareas with the .textarea_tinymce class (see resources/views/partials/forms/textarea.blade.php).
 **/

import tinymce from 'tinymce';

// Core: model, theme, icons
import 'tinymce/models/dom';
import 'tinymce/themes/silver';
import 'tinymce/icons/default';

// Skins bundled as JS: no need to serve the skin files from /public
import 'tinymce/skins/ui/oxide/skin.js';
import 'tinymce/skins/ui/oxide/content.js';
import 'tinymce/skins/content/default/content.js';

// Plugins (paste, text patterns, colors, context menu and hr are now part of the core)
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/charmap';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/anchor';
import 'tinymce/plugins/pagebreak';
import 'tinymce/plugins/searchreplace';
import 'tinymce/plugins/wordcount';
import 'tinymce/plugins/visualblocks';
import 'tinymce/plugins/visualchars';
import 'tinymce/plugins/code';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/insertdatetime';
import 'tinymce/plugins/media';
import 'tinymce/plugins/nonbreaking';
import 'tinymce/plugins/save';
import 'tinymce/plugins/table';
import 'tinymce/plugins/directionality';

/**
 * Upload of the images to the server (see app/Http/Controllers/ImageUploadController.php).
 * Must return a Promise resolving to the image URL.
 */
const uploadImage = (blobInfo) => {
    const formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

    return fetch('/tinymce_upload', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
    }).then(async (response) => {
        if (!response.ok) {
            let message = 'HTTP Error: ' + response.status;
            try {
                const json = await response.json();
                if (json?.message) {
                    message = json.message;
                }
            } catch (e) {
                // Not a JSON response: keep the HTTP status message
            }
            return Promise.reject({ message: message, remove: true });
        }

        const json = await response.json();
        if (!json || typeof json.location !== 'string') {
            return Promise.reject({ message: 'Invalid JSON response', remove: true });
        }

        return json.location;
    });
};

/**
 * Configuration
 **/
const editorConfig = {
    selector: '.textarea_tinymce',

    // Self-hosted under the GPL license (TinyMCE 7+)
    license_key: 'gpl',
    promotion: false,

    // Skins loaded from the bundled JS imports above
    content_css: 'default',

    // Remove Html tags from paste text
    paste_as_text: true, //!important

    // Allow link target blank
    extended_valid_elements: 'a[href|target]',

    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'pagebreak',
        'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen',
        'insertdatetime', 'media', 'nonbreaking', 'save', 'table', 'directionality',
    ],
    height: 400,

    toolbar: 'code | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media blockquote | hr',

    menubar: false,
    relative_urls: false,

    image_class_list: [
        { title: 'Left', value: '' },
        { title: 'Right', value: 'float-left w-full md:w-6/12 md:float-right mb-6' }
    ],

    // Add styles to align right the image in the editor
    content_style: "body img.md\\:float-right{ float: right; }" +
                    "body img.md\\:w-6\\/12{ width: 50%; }",

    // Image types accepted by the upload tab (default excludes svg).
    // Keep in sync with ALLOWED_EXTENSIONS in app/Http/Controllers/ImageUploadController.php
    images_file_types: 'jpeg,jpg,jpe,jfi,jif,jfif,png,gif,bmp,webp,svg',

    images_upload_handler: uploadImage,
};

tinymce.init(editorConfig);
