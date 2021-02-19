$(document).ready(function () {

    /**
     * Add Select2 single selection to all the divs with class .select2
     */
    $(".select2").select2({
        placeholder: "Select one",
        width: '100%'
    });

    /**
     * Add Select2 multiple selection to all the divs with class .select2-multiple
     */
    $(".select2-multiple").select2({
        placeholder: "Select one or more",
        width: '100%'
    });

});

window.autoSave = function () {
    console.log('test test');
    //this.select2 = $(this.$refs.select).select2();
    //$('#teacher_ids').select2();
}