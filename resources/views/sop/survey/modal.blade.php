@component(config('theme.components').'.modal-ajax-form',[
    'title' => 'Bulk Create',
    'name' => 'modal_bulk_create',
    'withDefaultJS' => false,
    'additionalClass' => 'mw-650px',
    'size' => '',
])

    <input type="hidden" name="question_id" id="bulk_create_question_id">

    {{ 
        Form::textareaInput('answer',null, [
            'formAlignment' => 'vertical', 
            'required' => 'required', 
            'labelText' => config('dynamic-survey.answer'), 
            'useLabel' => false,
            'elOptions' => [
                'id' => 'bulk_create_answer_textarea'
            ]
        ])
    }}

@endcomponent

@component(config('theme.components').'.modal-ajax-form',[
    'title' => 'Create '.config('dynamic-survey.question_group'),
    'name' => 'modal_create_section',
    'withDefaultJS' => false,
    'additionalClass' => 'mw-650px',
    'size' => '',
])
    {{ Form::textInput('name',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

    {{ Form::textInput('description',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

@endcomponent

@component(config('theme.components').'.modal-ajax-form',[
    'title' => 'Create '.config('dynamic-survey.question'),
    'name' => 'modal_create_question',
    'withDefaultJS' => false,
    'additionalClass' => 'mw-650px',
    'size' => '',
])

    <input type="hidden" name="question_group_id" id="question_group_id">

    {{-- {{
        Form::select2Input('parent_id',null, route('question.list'),[
            'labelText' => 'Parent '.config('dynamic-survey.question'),
            'formAlignment' => 'vertical',
            'text' => 'obj.content',
            'ajaxParams' => [
                'survey_id' => $data->id,
                'has_multiple_answer' => 1,
            ]
        ])
    }}

    <div class="answer-trigger-container" style="display: none;">
        {{
            Form::select2Input('answer_id',null, route('answer.list'),[
                'labelText' => config('dynamic-survey.answer').' Trigger',
                'formAlignment' => 'vertical',
                'text' => 'obj.content',
                'ajaxParams' => [
                    'question_id' => '$("#select2-parent_id").val()',
                ]
            ])
        }}
    </div> --}}

    {{ Form::textareaInput('content',null, ['formAlignment' => 'vertical', 'required' => 'required', 'elOptions' => ['rows' => 2]]) }}

    <div class="row">
        {{-- <div class="col-12 col-md-8">
            {{ 
                Form::select2Input('answer_type',null, App\Models\SOP\Answer::getTypeList(['text','checkbox']),[
                    'formAlignment' => 'vertical',
                    'pluginOptions' => [
                        'allowClear' => false
                    ]
                ])
            }}
        </div> --}}
        
        <input type="hidden" name="answer_type" id="answer_type" value="checkbox">
        
        {{-- <div class="col-12 col-md-4"> --}}
        <div class="col-12 col-md-12">
            {{ Form::switchInput('is_required',1,['formAlignment' => 'vertical','labelText' => 'Mandatory']) }}
        </div> 
    </div>

@endcomponent

@component(config('theme.components').'.modal-ajax-form',[
    'title' => 'Create '.config('dynamic-survey.answer'),
    'name' => 'modal_create_answer',
    'withDefaultJS' => false,
    'additionalClass' => 'mw-650px',
    'size' => '',
])

    <input type="hidden" name="question_id" id="question_id">

    {{ Form::textareaInput('content',null, ['formAlignment' => 'vertical', 'required' => 'required', 'elOptions' => ['rows' => 2]]) }}

    <div class="row">
        <div class="col-6">
            {{ Form::switchInput('show_freetext',1,['formAlignment' => 'vertical']) }}
        </div>
        <div class="col-6">
            {{ Form::switchInput('is_required',1,['formAlignment' => 'vertical','labelText' => 'Mandatory','elOptions' => ['id' => 'is_required_answer']]) }}
        </div>
    </div> 


@endcomponent

@component(config('theme.components').'.modal-ajax-form',[
    'title' => 'Edit '.config('dynamic-survey.question_group'),
    'name' => 'modal_edit_section',
    'withDefaultJS' => false,
    'additionalClass' => 'mw-650px',
    'size' => '',
])
    <input type="hidden" name="id" id="id">

    {{ Form::textInput('name',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

    {{ Form::textInput('description',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

@endcomponent

@component(config('theme.components').'.modal-ajax-form',[
    'title' => 'Edit '.config('dynamic-survey.question'),
    'name' => 'modal_edit_question',
    'withDefaultJS' => false,
    'additionalClass' => 'mw-650px',
    'size' => '',
])
    <input type="hidden" name="id" id="id">

    {{ Form::textareaInput('content',null, ['formAlignment' => 'vertical', 'required' => 'required', 'elOptions' => ['rows' => 2]]) }}

@endcomponent

@component(config('theme.components').'.modal-ajax-form',[
    'title' => 'Edit '.config('dynamic-survey.answer'),
    'name' => 'modal_edit_answer',
    'withDefaultJS' => false,
    'additionalClass' => 'mw-650px',
    'size' => '',
])
    <input type="hidden" name="id" id="id">

    {{ Form::textareaInput('content',null, ['formAlignment' => 'vertical', 'required' => 'required', 'elOptions' => ['rows' => 2]]) }}

    <div class="row">
        <div class="col-6">
            {{ Form::switchInput('show_freetext',1,['formAlignment' => 'vertical','elOptions' => ['id' => 'edit_show_freetext']]) }}
        </div>
        <div class="col-6">
            {{ Form::switchInput('is_required',1,['formAlignment' => 'vertical','labelText' => 'Mandatory','elOptions' => ['id' => 'edit_is_required_answer']]) }}
        </div>
    </div> 

@endcomponent

@push('additional-js')
<script type="text/javascript">
    $('#select2-parent_id').on('change',function(){
        if($(this).val() != null){
            $('.answer-trigger-container').show();
        }else{
            $('.answer-trigger-container').hide();
        }
    });

    function createSection() {
        $.each($('#modal_create_section_form :input'),function(){
            if($(this).attr('type') != null){
                $(this).val('');
            }
        });

        $('#modal_create_section').modal('show');
    }

    function saveSection(modalName) {
        var formEl = $('#modal_'+modalName+'_form')
        var form = formEl[0];
        var formData = new FormData(form);

        formData.append('survey_id',{{$data->id}});

        $.ajax({
            type: "POST",
            url:  '{{route('question-group.save')}}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function()
            {   
                $('#modal_'+modalName+'_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
            },
            success: function (result) {
                if(result.success){
                    // swaling({'text': result.message, 'icon': 'success'})
                    localStorage.setItem('active_section',result.data.id);
                    $('#modal_'+modalName).modal('hide');
                    renderSection(result.data)
                }else{
                    swaling({'text': result.message, 'icon': 'error'})
                    displayErrorInput(formEl, result.errors)
                }
            },
            error: function(xhr, textStatus, errorThrown){
                console.log(errorThrown);
                toasting()
            }
        }).always(function(){
            $('#modal_'+modalName+'_ajax_submit').removeAttr('data-kt-indicator').removeAttr('disabled');
        })
    }

    $('#modal_create_section_ajax_submit').on('click',function(){
        saveSection('create_section');
    });

    $('.edit-section').on('click',function(){
        var id = $(this).closest('.section').data('id');
        $('#modal_edit_section').find('#name').val($(this).closest('.row').find('.section-name-col').text());
        $('#modal_edit_section').find('#description').val($(this).closest('.row').find('.section-description-col').text());
        $('#modal_edit_section').find('#id').val(id);
        $('#modal_edit_section').modal('show');
    })

    $('#modal_edit_section_ajax_submit').on('click',function(){
        saveSection('edit_section');
    });

    $('.delete-section').on('click',function(){
        var el = $(this).closest('.section');
        var id = el.data('id');
        Swal.fire({
            text: 'Do you want to delete this {{strtolower(config('dynamic-survey.question_group'))}}?',
            icon: 'question',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-primary"
            }
        }).then((choice) => {
            if (choice.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url:  '{{route('question-group.delete')}}'+'/'+id,
                    beforeSend: function()
                    {   
                        // $('#modal_create_section_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
                    },
                    success: function (result) {
                        if(result.success){
                            location.reload()
                        }else{
                            swaling({'text': result.message, 'icon': 'error'})
                            displayErrorInput(formEl, result.errors)
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        toasting()
                    }
                }).always(function(){
                    // $('#modal_create_section_ajax_submit').removeAttr('data-kt-indicator').removeAttr('disabled');
                })
            }
        })
    })

    $('.create-question').on('click',function(){
        $.each($('#modal_create_question_form input:not([type="hidden"]):not("select")'),function(){
            if($(this).attr('type') != null){
                $(this).val('');
            }
        });

        $.each($('#modal_create_question_form textarea'),function(){
            $(this).val('');
        });

        $.each($('#modal_create_question_form select'),function(){
            $(this).val(null).trigger('change');
        });


        $('#question_group_id').val($(this).closest('.section').data('id'))
        $('#modal_create_question').modal('show');
    })

    function saveQuestion(modalName) {
        var formEl = $('#modal_'+modalName+'_form')
        var form = formEl[0];
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url:  '{{route('question.save')}}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function()
            {   
                $('#modal_'+modalName+'_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
            },
            success: function (result) {
                if(result.success){
                    // swaling({'text': result.message, 'icon': 'success'})
                    $('#modal_'+modalName+'').modal('hide');
                    renderQuestion(result.data.question_group_id)
                }else{
                    swaling({'text': result.message, 'icon': 'error'})
                    displayErrorInput(formEl, result.errors)
                }
            },
            error: function(xhr, textStatus, errorThrown){
                console.log(errorThrown);
                toasting()
            }
        }).always(function(){
            $('#modal_'+modalName+'_ajax_submit').removeAttr('data-kt-indicator').removeAttr('disabled');
        })
    }

    $('#modal_create_question_ajax_submit').on('click',function(){
        saveQuestion('create_question');
    });
    
    $('.edit-question').on('click',function(){
        var id = $(this).closest('.question').data('id');
        $('#modal_edit_question').find('#content').val($(this).closest('.row').find('.question-col h4').text().replace(' *',''));
        $('#modal_edit_question').find('#id').val(id);
        $('#modal_edit_question').modal('show');
    })

    $('.delete-question').on('click',function(){
        var el = $(this).closest('.question');
        var id = el.data('id');
        Swal.fire({
            text: 'Do you want to delete this {{strtolower(config('dynamic-survey.question'))}}?',
            icon: 'question',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-primary"
            }
        }).then((choice) => {
            if (choice.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url:  '{{route('question.delete')}}'+'/'+id,
                    beforeSend: function()
                    {   
                        // $('#modal_create_section_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
                    },
                    success: function (result) {
                        if(result.success){
                            swaling({'text': result.message, 'icon': 'success'})
                            el.remove();
                        }else{
                            swaling({'text': result.message, 'icon': 'error'})
                            displayErrorInput(formEl, result.errors)
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        toasting()
                    }
                }).always(function(){
                    // $('#modal_create_section_ajax_submit').removeAttr('data-kt-indicator').removeAttr('disabled');
                })
            }
        })
    })

    $('#modal_edit_question_ajax_submit').on('click',function(){
        saveQuestion('edit_question');
    });

    $('.create-answer').on('click',function(){
        $.each($('#modal_create_answer_form :input:not([type="hidden"]):not([type="checkbox"])'),function(){
            if($(this).attr('type') != null){
                $(this).val('');
            }
        });

        $('#question_id').val($(this).closest('.question').data('id'))
        $('#modal_create_answer').modal('show');
    })

    function saveAnswer(modalName) {
        var formEl = $('#modal_'+modalName+'_form')
        var form = formEl[0];
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url:  '{{route('answer.save')}}',
            data: formData,

            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function()
            {   
                $('#modal_'+modalName+'_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
            },
            success: function (result) {
                if(result.success){
                    // swaling({'text': result.message, 'icon': 'success'})
                    $('#modal_'+modalName+'').modal('hide');
                    renderAnswer(result.data.question)
                }else{
                    swaling({'text': result.message, 'icon': 'error'})
                    displayErrorInput(formEl, result.errors)
                }
            },
            error: function(xhr, textStatus, errorThrown){
                console.log(errorThrown);
                toasting()
            }
        }).always(function(){
            $('#modal_'+modalName+'_ajax_submit').removeAttr('data-kt-indicator').removeAttr('disabled');
        })
    }

    $('#modal_create_answer_ajax_submit').on('click',function(){
        saveAnswer('create_answer');
    });

    $('.edit-answer').on('click',function(){
        if($('#modal_edit_answer').find('#edit_is_required_answer').is(':checked')) $('#modal_edit_answer').find('#edit_is_required_answer').click();
        if($('#modal_edit_answer').find('#edit_show_freetext').is(':checked')) $('#modal_edit_answer').find('#edit_show_freetext').click();

        var id = $(this).closest('.answer-group').data('id');
        $('#modal_edit_answer').find('#content').val($(this).closest('.answer-group').find('.answer').val());
        if($(this).closest('.answer-group').data('showFreetext') == 1 && !$('#modal_edit_answer').find('#edit_show_freetext').is(':checked')){
            $('#modal_edit_answer').find('#edit_show_freetext').click()
        }

        if($(this).closest('.answer-group').data('required') == 1 && !$('#modal_edit_answer').find('#edit_is_required_answer').is(':checked')){
            $('#modal_edit_answer').find('#edit_is_required_answer').click()
        }
        
        $('#modal_edit_answer').find('#id').val(id);
        $('#modal_edit_answer').modal('show');
    })

    $('.delete-answer').on('click',function(){
        var el = $(this).closest('.answer-group');
        var id = el.data('id');
        var elQuestions = $(this).closest('.section-container').find('.question[data-answer-id="'+id+'"]');
        Swal.fire({
            text: 'Do you want to delete this {{strtolower(config('dynamic-survey.answer'))}}?',
            icon: 'question',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-primary"
            }
        }).then((choice) => {
            if (choice.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url:  '{{route('answer.delete')}}'+'/'+id,
                    beforeSend: function()
                    {   
                        // $('#modal_create_section_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
                    },
                    success: function (result) {
                        if(result.success){
                            swaling({'text': result.message, 'icon': 'success'})
                            el.remove();
                            elQuestions.remove();
                        }else{
                            swaling({'text': result.message, 'icon': 'error'})
                            displayErrorInput(formEl, result.errors)
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        toasting()
                    }
                }).always(function(){
                    // $('#modal_create_section_ajax_submit').removeAttr('data-kt-indicator').removeAttr('disabled');
                })
            }
        })
    })

    $('#modal_edit_answer_ajax_submit').on('click',function(){
        saveAnswer('edit_answer');
    });

    $('#modal_bulk_create_ajax_submit').on('click',function(){
        Swal.fire({
            text: 'Do you want to bulk create {{config('dynamic-survey.answer')}} for this {{config('dynamic-survey.question')}}?',
            icon: 'question',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-primary"
            }
        }).then((choice) => {
            if (choice.isConfirmed) {
                var formEl = $('#modal_bulk_create_form')
                var form = formEl[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    url:  '{{route('question.bulk-create-answer')}}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function()
                    {   
                        $('#modal_bulk_create_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
                    },
                    success: function (result) {
                        if(result.success){
                            renderAnswer(result.data);
                            $('#modal_bulk_create').modal('hide');
                            $('#bulk_create_answer_textarea').val('');
                        }else{
                            swaling({'text': result.message, 'icon': 'error'})
                            displayErrorInput(formEl, result.errors)
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        toasting()
                    }
                }).always(function(){
                    $('#modal_bulk_create_ajax_submit').removeAttr('data-kt-indicator').removeAttr('disabled');
                })
            }
        })
    });
</script>
@endpush