<div class="modal fade" tabindex="-1" id="modal-form">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><span id="modal-form-title">Create</span> Menu</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body" style="max-height: 68vh; overflow-y: scroll;">
                <form id="form-menu" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" value="">

                    {{ 
                        Form::select2Input('type', null, [
                            'section' => 'Section',
                            'group' => 'Group',
                            'link' => 'Link',
                        ]) 
                    }}

                    <div id="parent-section" style="display: none">
                        {{ 
                            Form::select2Input('parent_section_id', null/*[1, '<b>asd</b> 123']*/, route('menu.data'), [
                                'key' => 'id',
                                'text' => 'obj.select2_label',
                                'labelText' => 'Parent',
                                'required' => 'required',
                                'errorGroup' => 'parent_id',
                                'ajaxParams' => [
                                    'paginate' => 10,
                                    'type' => '"section"',
                                ],
                            ]) 
                        }}
                    </div>

                    <div id="parent-group" style="display: none">
                        {{ 
                            Form::select2Input('parent_group_id', null, route('menu.data'), [
                                'key' => 'id',
                                'text' => 'obj.select2_label',
                                'labelText' => 'Parent',
                                'required' => 'required',
                                'errorGroup' => 'parent_id',
                                'ajaxParams' => [
                                    'paginate' => 10,
                                    'type' => '["group", "section"]'
                                ],
                            ]) 
                        }}
                    </div>

                    {{ Form::textInput('label', null, ['required' => 'required']) }}
                    
                    <div id="form-content-icon" style="display: none">
                        {{ 
                            Form::textareaInput('icon', null, [
                                'elOptions' => [
                                    'rows' => 3,
                                ],
                            ]) 
                        }}
                    </div>

                    {{ Form::numberInput('order') }}

                    <div id="form-content-url" style="display: none">
                        {{ 
                            Form::textInput('url', null, [
                                'labelText' => 'URL',
                                'elOptions' => [
                                    'placeholder' => 'Please enter URL here'
                                ]
                            ]) 
                        }}
                    </div>
                    
                    <div id="form-content-permission" style="display: none">
                        {{-- {{ Form::textInput('permission_id', null, ['labelText' => 'Permission']) }} --}}

                        {{ 
                            Form::select2Input('permission_id', null, route('permission.data'), [
                                'key' => 'id',
                                'text' => 'obj.select2_label',
                                'labelText' => 'Permission',
                                'ajaxParams' => [
                                    'paginate' => 10,
                                ],
                            ]) 
                        }}
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-active-light me-3" data-bs-dismiss="modal">Close</button>

                <button type="button" id="modal-form-submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('additional-js')

<script type="text/javascript">
    $('#modal-form-submit').click(function(){

        var data = {}

        // if($('#id').val()){
        //     data.id = $('#id').val();
        //     if($('#select2-type').val()) data.type = $('#select2-type').val();
        //     if($('#label').val()) data.label = $('#label').val();
        //     if($('#icon').val()) data.icon = $('#icon').val();
        //     if($('#order').val()) data.order = $('#order').val();
        //     if($('#url').val()) data.url = $('#url').val();

        //     if($('#select2-type').val() == 'group'){
        //        if($('#select2-parent_section_id').val()) data.parent_id = $('#select2-parent_section_id').val()
        //     }else if($('#select2-type').val() == 'link'){
        //        if($('#select2-parent_group_id').val()) data.parent_id = $('#select2-parent_group_id').val()
        //     }

        // }else{
        //     data.type = $('#select2-type').val();
        //     data.label = $('#label').val();
        //     data.icon = $('#icon').val();
        //     data.order = $('#order').val();
        //     data.url = $('#url').val();

        //     if($('#select2-type').val() == 'group'){
        //        data.parent_id = $('#select2-parent_section_id').val()
        //     }else if($('#select2-type').val() == 'link'){
        //        data.parent_id = $('#select2-parent_group_id').val()
        //     }

            
        // }

        if($('#id').val()) data.id = $('#id').val();
        data.type = $('#select2-type').val();
        data.label = $('#label').val();
        data.icon = $('#icon').val();
        if($('#order').val()) data.order = $('#order').val();
        data.url = $('#url').val();

        if($('#select2-type').val() == 'group'){
           data.parent_id = $('#select2-parent_section_id').val()
        }else if($('#select2-type').val() == 'link'){
           data.parent_id = $('#select2-parent_group_id').val()
           data.permission_id = $('#select2-permission_id').val()
        }

        // log(data)
        // return;

        // Swal.fire({
        //     title: "Are you sure?",
        //     text: "Data will be saved!",
        //     icon: "warning",
        //     showCancelButton: true,
        //     confirmButtonText: "Yes, save it!",
        //     confirmButtonColor: '#009EF7',
        //     stopKeydownPropagation: false
        // }).then(function(result) {

        //     if (result.value) {

                // FETCH DATA

                $.ajax({
                    type: "POST",
                    url:  '{{ route('menu.save') }}',
                    data: data,
                    beforeSend: function(){   
                        // getBlockUI().block();
                        // $('#modal-form-submit').attr('disabled', 'disabled')
                        submitProcess('modal-form-submit');
                    },
                    success: function (result) {

                        if(result.success == true){
                            clearForm();
                            getMenus();
                            $('#modal-form').modal('hide');
                            // Swal.fire("Success!", result.msg, "success");
                        }else{
                            // Swal.fire("Error!", result.msg, "error");
                            swaling({'text': result.message, 'icon': 'error'})
                            displayErrorInput($('#form-menu'), result.errors);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        toasting()
                        // toastr.error("Request Failed.", "System Error");
                    }
                }).always(function(){
                    // getBlockUI().release();
                    submitProcess('modal-form-submit', 1);
                });
        //     }
        // });

    })

    function clearForm(){
        $('#form-menu :input').each(function(){
            var inputType = $(this).attr('type')
            if($(this).is("select")){
                if($(this).data('multiple') == 1){
                    var name = $(this).attr('name').replace('multiple','').replace(/_/g,'');
                    var el = $(this).closest('.row').find('.'+name+'_row');

                    $.each(el,function(key,item){
                        var id = $(item).attr('id').replace('row','').replace(/_/g,'');
                        window['deleteRow_' + name](id);
                    })
                }else{
                    $(this).val('').trigger('change');
                }
            }else{
                if(inputType == 'checkbox'){
                    if($(this).is(':checked')){
                        $(this).click();
                    }
                }else if(inputType == 'radio'){
                    // DO NOTHING, SEE BELOW
                }else if(inputType == 'file'){
                    // $(this).fileinput('clear');
                    window['previewFile_' + $(this).attr('id')]();
                }else{
                    if($(this).hasClass('flatpickr-input')){
                        $(this)[0]._flatpickr.clear();
                    }else{
                        $(this).val('').trigger('change');
                    }
                }
            }

            $('.error-container').html('');
        });

        $('#form-menu .m-radio-inline').each(function(){
            $(this).find("input[type=radio]:first").click();
        });

        $('.form-only-edit').hide();
    }

    $('#select2-type').on('change', function(){
        switchMode($(this).val())
    })

    function switchMode(mode = 'section') {
        
        $('#parent-section').hide();
        $('#parent-group').hide();
        $('#form-content-icon').hide();
        $('#form-content-url').hide();
        $('#form-content-permission').hide();

        if(mode == 'group'){
            $('#parent-section').show();
            $('#form-content-icon').show();
        }

        if(mode == 'link'){
            $('#parent-group').show();
            $('#form-content-icon').show();
            $('#form-content-url').show();
            $('#form-content-permission').show();
        }

    }
</script>

@endpush