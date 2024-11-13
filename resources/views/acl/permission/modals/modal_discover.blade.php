<div class="modal fade" tabindex="-1" id="modal-discover">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Discover Permission</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body mt-2 mb-8" style="max-height: 68vh; overflow-y: scroll;">
                <form id="form-discover" enctype="multipart/form-data">

                    <div id="modal-discover-loading" style="display: none;">
                        <div class="d-flex flex-column flex-center" style="height: 270px;">
                            
                        </div>
                    </div>

                    <div id="modal-discover-no-data" style="display: none;">
                        <div class="d-flex flex-column flex-center" style="height: 270px;">
                            <img src="{{ asset(config('theme.assets.back-office').'/media/illustrations/sigma-1/5.png') }}" style="max-width: 175px;">
                            <div class="fs-1 fw-bolder text-dark mb-4">No data found</div>
                            <div class="fs-6">No new permissions discovered yet</div>
                        </div>
                    </div>

                    <div id="modal-discover-data" >
                        <div class="px-3" style="height: 270px; overflow-y: auto;">

                            {{-- <button type="button" id="modal-discover-submit" class="btn btn-sm btn-light-success mb-0 fw-semibolds" style="float: right;">
                                <i class="ki-duotone ki-cloud-add">
                                 <i class="path1"></i>
                                 <i class="path2"></i>
                                </i>

                                Import Permissions
                            </button> --}}

                            <table class="table align-middle table-row-dashed fs-6 gy-4" id="modal-discover-table-permission">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th style="width: 50px !important;">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input cursor-pointer" type="checkbox" id="modal-discover-checkbox-all">
                                            </div>
                                        </th>
                                        <th style="width: 30% !important;">Group</th>
                                        <th class="">Permissions</th>
                                        
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-700" id="modal-discover-table-container">
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input cursor-pointer form-discover-check" type="checkbox" name="import[]" value="Variants">
                                            </div>
                                        </td>
                                        <td>Variants</td>
                                        <td class="">

                                            

                                            <div class="badge badge-dark">list</div>
                                            <div class="badge badge-dark">detail</div>
                                            <div class="badge badge-dark">save</div>
                                            <div class="badge badge-dark">destroy</div>
                                            <div class="badge badge-dark">export</div>
                                            <div class="badge badge-dark">import</div>
                                        </td>
                                        
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input cursor-pointer form-discover-check" type="checkbox" name="import[]" value="Schools">
                                            </div>
                                        </td>
                                        <td>Schools</td>
                                        <td class="td-permission">
                                            <div class="div-permission">
                                                <div class="d-flex mb-1">

                                                    <div class="badge badge-primary" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;">POST</div>
                                                    <div class="badge badge-secondary ms-0 me-2" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;">list</div>

                                                    <div class="badge badge-primary" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;">GET</div>
                                                    <div class="badge badge-secondary ms-0 me-2" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;">detail</div>

                                                    <div class="badge badge-primary" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;">POST</div>
                                                    <div class="badge badge-secondary ms-0 me-2" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;">save</div>

                                                    <div class="badge badge-primary" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;">DELETE</div>
                                                    <div class="badge badge-secondary ms-0 me-2" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;">destroy</div>

                                                    <div class="badge badge-primary" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;">POST</div>
                                                    <div class="badge badge-secondary ms-0 me-2" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;">export</div>

                                                    <div class="badge badge-primary" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;">POST</div>
                                                    <div class="badge badge-secondary ms-0 me-2" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;">import</div>


                                                </div>
                                            </div>
                                            
                                        </td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-active-light me-3" data-bs-dismiss="modal">Close</button>
                <button type="button" id="modal-discover-submit" class="btn btn-primary" style="display: none;">
                    <span class="indicator-label">Create Permissions</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('additional-js')

<script type="text/javascript">

    function getDiscover() {

        $('#modal-discover-checkbox-all').prop('checked', false)
        // return
        
        $.ajax({
            type: "POST",
            url:  '{{ route('permission.discover') }}',
            data: {},
            beforeSend: function(){
                switchDiscoverContent();
            },
            success: function (res) {
                // log(JSON.stringify(res.data) === '{}')

                if(JSON.stringify(res.data) !== '{}'){
                    renderDiscover(res.data);
                    switchDiscoverContent('data')
                    $('#modal-discover-submit').show()
                }else{
                    switchDiscoverContent('no-data')
                    $('#modal-discover-submit').hide()
                }
            },
            error: function(xhr, textStatus, errorThrown){
                log(errorThrown);
                // toastr.error("Request Failed.", "System Error");
                switchDiscoverContent('no-data')
                $('#modal-discover-submit').hide()
            }
        });

    }

    function switchDiscoverContent(mode = 'loading') {
        
        $('#modal-discover-no-data').hide();
        $('#modal-discover-data').hide();
        $('#modal-discover-loading').hide();

        if(mode == 'loading') $('#modal-discover-loading').show();
        if(mode == 'data') $('#modal-discover-data').show();
        if(mode == 'no-data') $('#modal-discover-no-data').show();

    }

    function renderDiscover(data) {
        $('#modal-discover-table-container').html('')

        var content = '';
        $.each(data, function(label, permissions){
            var permission_element = '';
            $.each(permissions, function(index, permission){
                permission_element += '<div class="badge badge-info" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;">'+permission.url_method+'</div>'+
                                 '<div class="badge badge-secondary ms-0 me-3" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;">'+permission.action_key+'</div>';
            })

            content += '<tr>'+
                        '<td>'+
                            '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">'+
                                '<input class="form-check-input cursor-pointer form-discover-check" type="checkbox" name="import[]" value="'+label+'">'+
                            '</div>'+
                        '</td>'+
                        '<td>'+label+'</td>'+
                        '<td class="td-permission">'+
                            '<div class="div-permission">'+
                                '<div class="d-flex mb-1">'+
                                    permission_element
                                '</div>'+
                            '</div>'+
                        '</td>'+
                    '</tr>';
        })

        $('#modal-discover-table-container').html(content)

    }

    $('#modal-discover-checkbox-all').change(function(){
        if($(this).is(':checked')){
            log('ALL CHECK')
            $('.form-discover-check').prop("checked", true);
        }else{
            log('ALL UNCHECK')
            $('.form-discover-check').prop("checked", false);
        }
    })

    $('#modal-discover-submit').click(function(){

        var data = {}
        data.import = [...document.querySelectorAll('.form-discover-check:checked')].map(e => e.value)

        if(!data.import.length){
            // Swal.fire("Warning!", 'Please select at least one group permission', "warning");
            swaling({'text': 'Please select at least one group permission', 'icon': 'warning'})
            return
        }


        Swal.fire({
            text: "Permission will be generated based on selected permission groups",
            icon: 'question',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, save it!",
            cancelButtonText: "Cancel",
            stopKeydownPropagation: false,
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(choice) {

            if (choice.value) {

                $.ajax({
                    type: "POST",
                    url:  '{{ route('permission.discover') }}',
                    data: data,
                    beforeSend: function(){   
                        // getBlockUI().block();
                        submitProcess('modal-discover-submit');
                    },
                    success: function (result) {

                        if(result.success == true){
                            getData();
                            $('#modal-discover').modal('hide');
                        }else{
                            swaling({'text': result.message, 'icon': 'error'})
                            displayErrorInput($('#form-discover'), result.errors);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        toasting()
                    }
                }).always(function(){
                    // getBlockUI().release();
                    submitProcess('modal-discover-submit', 1);
                });
            }
        });

    });

</script>

@endpush