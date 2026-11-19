import tinymce from 'tinymce';
import 'tinymce/themes/silver';

import 'tinymce/icons/default';

import 'tinymce/plugins/advlist';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/charmap';
import 'tinymce/plugins/print';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/hr';
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
import 'tinymce/plugins/contextmenu';
import 'tinymce/plugins/directionality';
import 'tinymce/plugins/template';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/textcolor';
import 'tinymce/plugins/colorpicker';
import 'tinymce/plugins/textpattern';
import 'tinymce/plugins/imagetools';

/**
 * Configuration
 **/

var editor_config = {
    selector: '.textarea_tinymce',

    // Remove Html tags from paste text
    paste_as_text: true, //!important

    // Allow link target blank
    extended_valid_elements: 'a[href|target]',

    /*plugins : 'advlist autolink link image lists charmap print preview spellchecker media table',*/
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "template paste textcolor colorpicker textpattern imagetools"
    ],
    theme: 'silver',
    skin_url: '/js/skins/ui/oxide',
    content_css: '/js/skins/content/default/content.min.css',
    height: 400,

    toolbar: 'code | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media blockquote | hr',
    /*toolbar: 'bold | bullist  link ', */

    menubar: false,
    path_absolute : "/",
    relative_urls: false,

    image_class_list: [
        { title: 'Left', value: '' },
        { title: 'Right', value: 'float-left w-full md:w-6/12 md:float-right mb-6' }
    ],

    // Add styles to align right the image in the editor
    content_style: "body img.md\\:float-right{ float: right; }" +
                    "body img.md\\:w-6\\/12{ width: 50%; }",

    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '/tinymce_upload');
        var token = '{{ csrf_token() }}';
        xhr.setRequestHeader("X-CSRF-Token", token);
        xhr.onload = function() {
            var json;
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            success(json.location);
        };
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    }


    //forced_root_block : false, // force to add <br> instead of <p> - Better not to enable it - Warning: Not using p elements as the root block will impair the functionality of the editor. - https://www.tiny.cloud/docs/configure/content-filtering/#exampleusingforced_root_block

// do not delete the commented lines of tinymce! .. this is a file browser that can be useful for articles

/*file_browser_callback : function(field_name, url, type, win) {
    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
    if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
    } else {
        cmsURL = cmsURL + "&type=Files";
    }

    tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
    });
} */
}

tinymce.init(editor_config);
