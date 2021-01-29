$(document).ready(function () {

    // When an image is chosen, replace the "Choose a file" label
    $('.custom-file-input').on('change',function () {
        // Get the file name
        let filePath = $(this).val();
        let fileName = filePath.replace(/^.*[\\\/]/, '');

        // Replace the "Choose a file" label
        $('.selectedFile').html(fileName);
    })

    // Delete an already uploaded image
    $('.deleteImage').on('click',function () {
        $("input[name='{{$name}}_delete']").val("true");
        $("img.uploadedImage").remove();
    })
});
