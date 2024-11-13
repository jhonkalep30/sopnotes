@extends(config('theme.layouts.admin'),[
    'title' => 'Role',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        ['label' => 'User Management'],
        ['label' => 'Role'],
    ]

])

@section('content')

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9" id="data-container">

            
        <div class="col-md-4 data-role" style="height: 325px !important; display: none;">
            <div class="card card-flush h-md-100">
                <div class="card-header text-center align-items-center pt-5" {{-- style="min-height: 0px !important;" --}}>
                    <div class="card-title ">
                        <h2 class="text-hover-primary">Administrator</h2>
                    </div>
                </div>
                <div class="card-body py-0" style="min-height: 127px !important;">
                    <div class="d-flex flex-column text-gray-600">
                        <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>All Product Access</div>
                        <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>Some Variants Access</div>
                        <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports</div>
                        <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>View and Edit Payouts</div>
                        {{-- <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>View and Edit Disputes</div> --}}
                        <div class="d-flex align-items-center py-2">
                            <span class="bullet bg-primary me-3"></span>
                            <em>and 7 more...</em>
                        </div>
                       {{--  <div class="d-flex align-items-center py-2">
                            <span class="bullet bg-primary me-3"></span>
                            <em>No Access</em>
                        </div> --}}
                    </div>
                </div>
                <div class="card-footer flex-wrap pt-4">
                    <button type="button" class="btn btn-light-primary my-1" data-bs-toggle="modal" data-bs-target="#modal-form" onclick="editData(1)">Edit Role</button>
                </div>
            </div>
        </div>

        <div class="col-md-4 data-role" style="height: 325px !important; display: none;">
            <div class="card card-flush h-md-100">
                <div class="card-header text-center align-items-center pt-5" {{-- style="min-height: 0px !important;" --}}>
                    <div class="card-title ">
                        <h2 class="text-hover-primary">Administrator</h2>
                    </div>
                </div>
                <div class="card-body py-0" style="min-height: 127px !important;">
                    <div class="d-flex flex-column text-gray-600">
                       {{--  <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>All Product Access</div>
                        <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>Some Variants Access</div>
                        <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports</div>
                        <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>View and Edit Payouts</div>
                        <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>View and Edit Disputes</div>
                        <div class="d-flex align-items-center py-2">
                            <span class="bullet bg-primary me-3"></span>
                            <em>and 7 more...</em>
                        </div> --}}
                        <div class="d-flex align-items-center py-2">
                            <span class="bullet bg-primary me-3"></span>
                            <em>No Access</em>
                        </div>
                        {{-- <button type="button" class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal" data-bs-target="#modal-form" onclick="editData()">
                        <img src="{{ asset(config('theme.assets.back-office').'/media/illustrations/sigma-1/20.png') }}" alt="" class="mw-100 mh-150px mb-7">
                        <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Grant Access</div> --}}
                        
                    </button>
                    </div>
                </div>
                <div class="card-footer flex-wrap pt-4">
                    <button type="button" class="btn btn-light-primary my-1" data-bs-toggle="modal" data-bs-target="#modal-form" onclick="loadPermission(1)">Edit Role</button>
                </div>
            </div>
        </div>

        
        <div id="role-add-new" class="col-md-4 data-new" style="height: 325px !important; display: none;">
            <div class="card h-md-100">
                <div class="card-body d-flex flex-center">
                    <button type="button" class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal" data-bs-target="#modal-form" onclick="checkForm(); loadPermission();">
                        <img src="{{ asset(config('theme.assets.back-office').'/media/illustrations/sigma-1/4.png') }}" alt="" class="mw-100 mh-150px mb-7">
                        <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                    </button>
                </div>
            </div>
        </div>

    </div>

    @include('acl.role.modal_form')

@endsection

@push('additional-css')

<style type="text/css">
    .td-permission {
        max-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .div-permission {
        overflow-x: auto; 
        width: 100%;
    }

    .form-check, .form-check-input {
        cursor: pointer;
    }

    .grid-container {
      display: grid;
      grid-template-columns: 33% 33% 33%;
      /*background-color: #2196F3;*/
      /*padding: 10px;*/
    }
    .grid-item {
      /*background-color: rgba(255, 255, 255, 0.8);*/
      /*border: 1px solid rgba(0, 0, 0, 0.8);*/
      /*padding: 20px;*/
      /*font-size: 30px;*/
      /*text-align: center;*/
    }
</style>

@endpush

@push('additional-js')

<script type="text/javascript">

    $(document).ready(function(){
        getData();
    })

    function getData() {
        
        $.ajax({
            type: "POST",
            url:  '{{ route('role.render') }}',
            beforeSend: function(){
                $('#role-add-new').hide();
                getBlockUI().release();
                getBlockUI().block();
            },
            success: function (res) {
                log(res.data)

                if(res.data.length) renderItem(res.data);
            },
            error: function(xhr, textStatus, errorThrown){
                log(errorThrown);
                toastr.error("Error while getting data", "System Error");
            }
        }).always(function(){
            $('#role-add-new').show();
            getBlockUI().release();
        });

    }

    function renderItem(datas) {

        $('.data-role').remove();
        
        $.each(datas, function(index, data){

            let elData = '';

            elData += '<div class="col-md-4 data-role" style="height: 325px !important;">'+
                        '<div class="card card-flush h-md-100">'+
                            '<div class="card-header text-center align-items-center pt-5">'+
                                '<div class="card-title ">'+
                                    '<h2 class="text-hover-primary">'+data.name+'</h2>'+
                                '</div>'+
                            '</div>'+
                            '<div class="card-body py-0">'+
                                '<div class="d-flex flex-column text-gray-600">';

            if(data.permissions.length){

                $.each(data.permissions, function(indexPermission, permission){
                    if(indexPermission <= 3){

                        elData += '<div class="d-flex align-items-center py-2">'+
                                    '<span class="bullet bg-primary me-3"></span>'+permission+'</div>';

                    }else if(indexPermission == 4){

                        elData += '<div class="d-flex align-items-center py-2">'+
                                    '<span class="bullet bg-primary me-3"></span>'+
                                    '<em>and '+(data.permissions.length - 4)+' more...</em>'+
                                '</div>';

                    }
                });

            }else{
                elData +=           '<div class="d-flex align-items-center py-2">'+
                                        '<span class="bullet bg-primary me-3"></span>'+
                                        '<em>No Access</em>'+
                                    '</div>';
            }

            elData +=           '</div>'+
                            '</div>'+
                            '<div class="card-footer justify-content-between pt-4">'+
                                '<button type="button" class="btn btn-light-primary my-1 me-3" data-bs-toggle="modal" data-bs-target="#modal-form" onclick="loadPermission('+data.id+')">Update</button>'+
                                '<button type="button" class="btn btn-danger my-1" onclick="deleteRole('+data.id+')">Remove</button>'+
                            '</div>'+
                        '</div>'+
                    '</div>';

            if(elData) $('#data-container').prepend(elData);
        });

    }

    function checkForm() {
        if($('#id').val()){
            $('#id').val('')
            $('#role').val('')
            $('#acl-all').prop('checked', false)
        }
    }

    function deleteRole(id) {

        Swal.fire({
            text: "Data will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            stopKeydownPropagation: false,
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(choice) {

            if (choice.value) {
                $.ajax({
                    type: "DELETE",
                    url:  '{{ url('role/delete') }}/'+id,
                    beforeSend: function(){   
                        getBlockUI().block();
                    },
                    success: function (result) {

                        if(result.success == true){
                            getData();
                            // $('#modal-form').modal('hide');
                            // Swal.fire("Success!", result.msg, "success");
                        }else{
                            // Swal.fire("Error!", result.msg, "error");
                            swaling({'text': result.message, 'icon': 'error'})
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        // toastr.error("Request Failed.", "System Error");
                        toasting()
                    }
                }).always(function(){
                    getBlockUI().release();
                });
            }
        });

    }
</script>

@endpush