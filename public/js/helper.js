function getBlockUI() {
    return blockUI;
}

function displayErrorInput(formEl, errors, reset = true) {
  if(reset) $('.error-container').html('');

  // $.each(errors,function(key,item){
  //     $('[name='+key+'], [error-group='+key+']').addClass('input-error');
  //     var container = $('[name='+key+'], [error-group='+key+']').closest('div').find('.error-container');
  //     container.append('<ul class="error-listing"></ul>');
  //     $.each(item,function(index,errMsg){
  //         container.find('ul').append('<li>'+errMsg+'</li>');
  //     })
  // });

  $.each(errors,function(key, item){
        formEl.find('input[name="'+key+'"]').closest('.row').find('.error-container').html('<span class="text-danger">'+item[0]+'</span>');
        formEl.find('select[name="'+key+'"]').closest('.row').find('.error-container').html('<span class="text-danger">'+item[0]+'</span>');
        formEl.find('input[type="file"][name="'+key+'"]').closest('.form-group').find('.error-container').html('<span class="text-danger">'+item[0]+'</span>');
  });
}

function delay(callback, ms) {
    var timer = 0;

    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}

function log(text, additional = null) {
    if(additional) console.log(text, additional);
    else console.log(text);
}

function toLabel(str) {
    return str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
}

function toasting(params = {}) {

    text = params.text ?? 'Something went wrong'
    title = params.title ?? 'Request failed'
    mode = params.mode ?? 'danger'
    place = params.place ?? 'toast-top-right'
    time = params.time ?? ''
    icon = params.icon ?? ''

    $('#'+place+'-title').html(title)
    $('#'+place+'-text').html(text)
    $('#'+place+'-time').html(time)
    if(icon) $('#'+place+'-icon').html(icon)
    $('#'+place+'-icon')
        .removeClass('text-danger')
        .removeClass('text-success')
        .removeClass('text-warning')
        .removeClass('text-info')
        .removeClass('text-secondary')
        .removeClass('text-dark')
        .removeClass('text-primary')

    $('#'+place+'-icon').addClass('text-'+mode)

    const toastElement = document.getElementById(place);
    const toast = bootstrap.Toast.getOrCreateInstance(toastElement);
    toast.show();
}

function swaling(params = {}){

    options = {
        text: 'Something went wrong',
        icon: 'info',
        showCancelButton: false,
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
            confirmButton: "btn btn-primary"
        }
    };

    if(params.text) options.text = params.text
    if(params.title) options.title = params.title
    if(params.icon) options.icon = params.icon
    if(params.confirmButtonText) options.confirmButtonText = params.confirmButtonText
    if(params.confirmButton) options.customClass.confirmButton = params.confirmButton

    Swal.fire(options);
}

function submitProcess(el, mode = 0) {
    $('#'+el).removeAttr('disabled').removeAttr('data-kt-indicator');
    if(mode == 0) $('#'+el).attr('disabled', 'disabled').attr('data-kt-indicator', 'on');
}