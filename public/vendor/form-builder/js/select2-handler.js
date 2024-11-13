function setSelect2IfPatchModal(element, id, text){

    element.select2("trigger", "select", {
        data: { id: id, text: text }
    });

    // Remove validation of success
    element.closest('.form-group').removeClass('has-success');

    var span = element.parent('.input-group').children('.input-group-addon');
    span.addClass('display-hide');

    // Remove focus from selection
    element.next().removeClass('select2-container--focus');

}