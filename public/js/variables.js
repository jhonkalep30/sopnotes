toastr.options = {
  closeButton: false,
  debug: false,
  newestOnTop: false,
  progressBar: true,
  preventDuplicates: false,
  positionClass: "toastr-bottom-right",
  onclick: null,
  showDuration: "300",
  hideDuration: "1000",
  timeOut: "5000",
  extendedTimeOut: "1000",
  showEasing: "swing",
  hideEasing: "linear",
  showMethod: "fadeIn",
  hideMethod: "fadeOut"
};

var blockUI = new KTBlockUI(document.querySelector('#kt_body'), {
    message: '<div class="blockui-message blockui-message-bg blockui-full"><span class="spinner-border text-primary"></span> Loading...</div>',
});