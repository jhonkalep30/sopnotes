@extends(config('theme.layouts.admin'),[
    'title' => 'Form Editor',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'SOP',
            'url' => route('sop.view')
        ],
        ['label' => 'Form Editor'],
    ]

])

@if($data->privacy == 1)
    @push('additional-css')
    <style type="text/css">
        .form-element{
            display:none !important;
        }
        .question[data-parent-id]{
            display:none;
        }
    </style>
    @endpush
@endif

@section('content')

    @if($data->privacy == 0)
    <div class="alert alert-warning d-flex align-items-center alert-editing-mode" role="alert" style="display:flex !important">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </svg>
        <div>
            You're in editing mode!
        </div>
    </div>

    <div class="alert alert-success d-flex align-items-center alert-preview-mode" role="alert" style="display:none !important">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </svg>
        <div>
            You're in preview mode!
        </div>
    </div>
    @endif

    <div class="row pb-5">
        <div class="col-6">
            <a href="{{route('sop.view')}}" class="btn btn-sm btn-primary fw-bolder"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
        <div class="col-6" align="right">
            @if($data->privacy == 0)
                <button type="button" class="btn btn-sm btn-icon btn-warning preview-btn" onclick="previewMode()"><i class="fas fa-pencil"></i></button>&nbsp;
                {{-- <button type="button" class="btn btn-sm btn-icon btn-info" onclick="publishSurvey('publish')"><i class="fas fa-sign-out-alt"></i></button>&nbsp; --}}
                <div class="form-check form-switch form-check-custom form-check-solid" style="display:contents;">
                    <input class="form-check-input w-55px publish-switch" style="height: calc(1.5em + 1.1rem + 2px) !important" type="checkbox" value="" id="flexSwitchChecked" onclick="publishSurvey('publish')" />
                    <label class="form-check-label" for="flexSwitchChecked">
                        Draft
                    </label>
                </div>
            @else
            {{-- <button type="button" class="btn btn-sm btn-icon btn-warning" onclick="publishSurvey('unpublish')"><i class="fas fa-sign-in-alt"></i></button>&nbsp; --}}
            <div class="form-check form-switch form-check-custom form-check-solid" style="display:inline-flex;">
                <input class="form-check-input w-55px publish-switch" style="height: calc(1.5em + 1.1rem + 2px) !important" type="checkbox" value="" id="flexSwitchChecked" checked="checked" onclick="publishSurvey('unpublish')" />
                <label class="form-check-label" for="flexSwitchChecked">
                    Published
                </label>
            </div>
            @endif
            {{-- <button type="button" class="btn btn-sm btn-icon btn-danger" onclick="deleteSurvey()"><i class="fas fa-trash"></i></button> --}}
        </div>
    </div>
    

    @component(config('theme.components').'.card',['name' => 'form_creator_card','headerPadding' => 'pt-0','minHeight' => '0px'])
        <div class="row">
            <div class="col-12 section-container">
                @if($data->question_groups) 
                    @foreach($data->question_groups as $key =>  $group)
                        <div class="section pb-5" id="section_{{$group->id}}" data-id="{{$group->id}}" style="display:{{$key == 0 ? 'block' : 'none'}};">
                            <div align="center">
                                <div class="row">
                                    <h2 class="text-info section-name-col">{{$group->name}}</h2>
                                    <div class="col-12 section-description-col">{{$group->description}}</div>
                                    <div class="col-12 form-element">
                                        <button type="button" class="btn btn-sm btn-warning btn-icon edit-section mt-5 mb-5 me-1" style="border-radius: 50%"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger btn-icon delete-section mt-5 mb-5" style="border-radius: 50%"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="question-container pt-7" style="display:{{count($data->question_groups) > 0 ? 'block' : 'none'}};">
                                @foreach($group->questions as $question)
                                    <div class="row question" id="question_{{$question->id}}" {{@$question->parent_id ? 'data-parent-id='.$question->parent_id : ''}} {{@$question->answer_id ? 'data-answer-id='.$question->answer_id : ''}} data-id="{{$question->id}}">
                                        <div class="col-12">
                                            <div class="row mb-2">
                                                <div class="col-7 question-col">
                                                    <h4 class="mt-2">{{$question->content}} {!! $question->is_required == 1 ? '<small class="text-danger">*</small>' : ''!!}</h4>
                                                    @if($question->parent_id)
                                                    <span class="badge badge-info form-element mb-2 me-1">Child {{config('dynamic-survey.question')}} of: {{$question->parent->content}}</span>
                                                    <span class="badge badge-success form-element mb-2">{{config('dynamic-survey.answer')}} Trigger: {{$question->answer->content}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-5 form-element" align="right">
                                                    <button type="button" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius:50%">
                                                        <i class="fas fa-ellipsis-v fs-4"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if(in_array($question->answer_type,App\Models\SOP\Answer::getMultipleList()))
                                                            <li><a class="dropdown-item create-answer" href="#"><i class="fas fa-plus text-dark me-2"></i> Create {{config('dynamic-survey.answer')}}</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item bulk-create-answer" data-question-id="{{$question->id}}" href="#"><i class="fas fa-list-check text-dark me-2"></i> Bulk Create {{config('dynamic-survey.answer')}}</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                        @endif
                                                        <li><a class="dropdown-item edit-question" href="#"><i class="fas fa-edit text-dark me-2"></i> Edit {{config('dynamic-survey.question')}}</a></li>
                                                        <li><a class="dropdown-item delete-question" href="#"><i class="fas fa-trash text-dark me-2"></i> Delete {{config('dynamic-survey.question')}}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row answer-container">
                                                @if($question->answer_type == 'text')
                                                    {{ 
                                                        Form::textInput('answer['.$question->id.']',null,['useLabel' => false,'labelText' => 'Answer','elOptions' => ['id' => 'answer_'.$question->id]])
                                                    }}
                                                @else
                                                    @if($question->answers)
                                                        @forelse($question->answers as $answer)
                                                            <div class="col-12 pb-5 answer-group" data-id="{{$answer->id}}" data-show-freetext="{{$answer->show_freetext}}" data-required="{{$answer->is_required}}">
                                                                <div class="form-check form-check-custom form-check-solid">
                                                                    <button type="button" class="btn btn-sm btn-icon btn-light-warning edit-answer form-element me-2" style="width:21px;height:21px;" data-id="{{$answer->id}}"><i class="fas fa-edit fs-8"></i></button>
                                                                    <button type="button" class="btn btn-sm btn-icon btn-light-danger delete-answer form-element me-2" style="width:21px;height:21px;" data-id="{{$answer->id}}"><i class="fas fa-trash fs-8"></i></button>
                                                                    <input class="form-check-input answer" name="answer[{{$question->id}}][]" type="checkbox" value="{{$answer->content}}" data-id="{{$answer->id}}" id="checkbox_answer_{{$answer->id}}"/>
                                                                    <label class="form-check-label" for="checkbox_answer_{{$answer->id}}">
                                                                        {{$answer->content}} {!!$answer->is_trigger == 1 ? '<span class="badge badge-warning mx-1 form-element">Trigger</span>' : ''!!}{!!$answer->is_required == 1 ? '<span class="badge badge-primary mx-1 form-element">Mandatory</span>' : ''!!}
                                                                    </label>
                                                                </div>
                                                                @if($answer->show_freetext == 1)
                                                                <div class="form-group mt-5 mb-2 freetext" id="answer_freetext_{{$answer->id}}" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <input class="form-control form-control-solid" id="freetext_{{$answer->id}}" placeholder="Please enter {{$answer->content}} here" name="freetext[{{$question->id}}]" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        @empty
                                                            <div class="form-group mb-2">
                                                                No {{config('dynamic-survey.answer')}}(s) Defined
                                                            </div>
                                                        @endforelse
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-md btn-info btn-md create-question form-element mt-2" style="width: 100%;">
                                <i class="fas fa-plus"></i> Create {{config('dynamic-survey.question')}}
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-md btn-primary form-element mb-5" onclick="createSection()" style="width:100%"><i class="fas fa-plus"></i> Create {{config('dynamic-survey.question_group')}}</button>
                <button type="button" class="btn btn-md btn-primary btn-submit mb-5" style="display:none;width: 100%;">Lanjutkan</button>
            </div>
        </div>
        <div class="row">
            <hr style="border: 1px dashed #ccc">
            <div class="col-12 d-flex justify-content-center navigator-container">
                @if($data->question_groups) 
                    <ul class="pagination pagination-circle pagination-outline mb-5 pagination-section">
                    @foreach($data->question_groups as $key => $group)
                        <li class="page-item {{$key == 0 ? 'active' : ''}}" id="page_item_{{$group->id}}">
                            <a class="page-link" id="page_link_{{$group->id}}" data-id="{{$group->id}}" href="#">{{$key+1}}</a>
                        </li>
                    @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endcomponent

    @include('sop.survey.modal')

@endsection

@push('additional-js')

<script type="text/javascript">
    $(document).ready(function(){
        @if($data->privacy == 1)
            previewMode('force')
        @endif

        localStorage.removeItem('active_section');

        if($('#show_freetext').is(':checked')) $('#show_freetext').click();
        if($('#edit_show_freetext').is(':checked')) $('#edit_show_freetext').click();
    });

    function renderSection(data) {
        var el = '<div class="section pb-5" id="section_'+data.id+'" data-id="'+data.id+'" style="display:block;">'+
            '<div align="center">'+
                '<div class="row">'+
                    '<h2 class="text-info section-name-col">'+data.name+'</h2>'+
                    '<div class="col-12 section-description-col section-description-col">'+(data.description ?? '')+'</div>'+
                    '<div class="col-12 form-element">'+
                        '<button type="button" class="btn btn-sm btn-warning btn-icon edit-section mt-5 mb-5 me-1" style="border-radius: 50%"><i class="fas fa-edit"></i></button>'+
                        '<button type="button" class="btn btn-sm btn-danger btn-icon delete-section mt-5 mb-5" style="border-radius: 50%"><i class="fas fa-trash"></i></button>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            '<div class="question-container pt-7" style="display:none"></div>'+
            '<button type="button" class="btn btn-md btn-info btn-md create-question form-element mt-2" style="width: 100%;">'+
                '<i class="fas fa-plus"></i> Create {{config('dynamic-survey.question')}}'+
            '</button>'+
        '</div>';

        $('.section').hide();
        $('.section-container').prepend(el);

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

        $('.edit-section').on('click',function(){
            var id = $(this).closest('.section').data('id');
            $('#modal_edit_section').find('#name').val($(this).closest('.row').find('.section-name-col').text());
            $('#modal_edit_section').find('#description').val($(this).closest('.row').find('.section-description-col').text());
            $('#modal_edit_section').find('#id').val(id);
            $('#modal_edit_section').modal('show');
        })

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
        
        refreshPagination(data.id)
        renderQuestion(data.id)
    }

    function refreshPagination(id) {
        $.ajax({
            type: "POST",
            url:  '{{route('question-group.list')}}',
            data: {survey_id:'{{$data->id}}'},
            beforeSend: function()
            {   
                // $('#modal_create_question_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
            },
            success: function (result) {
                if(result.success){
                    // swaling({'text': result.message, 'icon': 'success'})
                    // renderQuestion(result.data)
                    var el = '<ul class="pagination pagination-circle pagination-outline mt-5 pagination-section">';
                    $.each(result.data,function(key,item){
                        el += '<li class="page-item '+(item.id == id ? 'active' : '')+'" id="page_item_'+item.id+'">'+
                            '<a class="page-link" id="page_link_'+item.id+'" data-id="'+item.id+'" href="#">'+(key + 1)+'</a>'+
                        '</li>';
                    });
                    el += '</ul>';

                    $('.navigator-container').html(el);
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
            $('.page-link').on('click',function(e){
                e.preventDefault();

                var id = $(this).data('id');
                $('.section').hide();
                $('#section_'+id).show();

                localStorage.setItem('active_section',id);

                $('.page-item').removeClass('active');
                $(this).parent().addClass('active');
            })
        })
    }

    function renderQuestion(id) {
        $.ajax({
            type: "POST",
            url:  '{{route('question.list')}}',
            data: {question_group_id:id},
            beforeSend: function()
            {   
                // $('#modal_create_question_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
            },
            success: function (result) {
                if(result.success){
                    var multipleTypes = {!! json_encode(App\Models\SOP\Answer::getMultipleList()) !!}
                    $('#section_'+id+' .question-container').html('');
                    $.each(result.data,function(key,item){
                        var el = '<div class="row question" id="question_'+item.id+'" '+(item.parent_id != null ? 'data-parent-id="'+item.parent_id+'"' : "" )+' '+(item.answer_id != null ? 'data-answer-id="'+item.answer_id+'"' : "" )+' data-id="'+item.id+'">'+
                                    '<div class="col-12">'+
                                        '<div class="row mb-2">'+
                                            '<div class="col-7 question-col">'+
                                                '<h4 class="mt-2">'+item.content+' '+(item.is_required == 1 ? '<small class="text-danger">*</small>' : '' )+'</h4>';

                                            if(item.parent_id != null){
                                                el += '<span class="badge badge-info form-element mb-2 me-1">Child {{config('dynamic-survey.question')}} of: '+item.parent.content+'</span><span class="badge badge-success form-element mb-2">{{config('dynamic-survey.answer')}} Trigger: '+item.answer.content+'</span>'
                                            }


                                            el += '</div>'+
                                            '<div class="col-5 form-element" align="right">'+
                                                '<button type="button" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius:50%">'+
                                                    '<i class="fas fa-ellipsis-v fs-4"></i>'+
                                                '</button>'+
                                                '<ul class="dropdown-menu">';

                                                    if(multipleTypes.includes(item.answer_type)){
                                                        el += '<li><a class="dropdown-item create-answer" href="#"><i class="fas fa-plus text-dark me-2"></i> Create {{config('dynamic-survey.answer')}}</a></li>'+
                                                            '<li><hr class="dropdown-divider"></li>'+
                                                            '<li><a class="dropdown-item bulk-create-answer" data-question-id="'+item.id+'" href="#"><i class="fas fa-list-check text-dark me-2"></i> Bulk Create {{config('dynamic-survey.answer')}}</a></li>'+
                                                            '<li><hr class="dropdown-divider"></li>';
                                                    }

                                                    el += '<li><a class="dropdown-item edit-question" href="#"><i class="fas fa-edit text-dark me-2"></i> Edit {{config('dynamic-survey.question')}}</a></li>'+
                                                        '<li><a class="dropdown-item delete-question" href="#"><i class="fas fa-trash text-dark me-2"></i> Delete {{config('dynamic-survey.question')}}</a></li>'+
                                                
                                                '</ul>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-12">'+
                                        '<div class="row answer-container"></div>'+
                                    '</div>'+
                                '</div>';

                        $('#section_'+id+' .question-container').append(el)
                        $('#section_'+id+' .question-container').show()
                        renderAnswer(item);
                    })

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

            $('.create-answer').on('click',function(){
                $.each($('#modal_create_answer_form :input:not([type="hidden"]):not([type="checkbox"])'),function(){
                    if($(this).attr('type') != null){
                        $(this).val('');
                    }
                });

                $('#question_id').val($(this).closest('.question').data('id'))
                $('#modal_create_answer').modal('show');
            })

            $('.bulk-create-answer').on('click',function(){
                $('#bulk_create_question_id').val($(this).data('questionId'))
                $('#modal_bulk_create').modal('show')
            });
        })
    }

    function renderAnswer(question) {
        var multipleTypes = {!! json_encode(App\Models\SOP\Answer::getMultipleList()) !!}
        var el = '';
        
        if(multipleTypes.includes(question.answer_type)){
            $.ajax({
                type: "POST",
                url:  '{{route('answer.list')}}',
                data: {question_id:question.id},
                beforeSend: function()
                {   
                    $('#question_'+question.id+' .answer-container').html('<div class="form-group mb-2">Loading Data...</div>')
                    // $('#modal_create_question_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
                },
                success: function (result) {
                    if(result.success){
                        $('#question_'+question.id+' .answer-container').html('');

                        if(result.data.length > 0){
                            $.each(result.data,function(key,item){
                                if(question.answer_type == 'checkbox'){
                                    el += '<div class="col-12 pb-5 answer-group" data-id="'+item.id+'" data-show-freetext="'+item.show_freetext+'" data-required="'+item.is_required+'>'+
                                                '<div class="form-check form-check-custom form-check-solid">'+
                                                    '<button type="button" class="btn btn-sm btn-icon btn-light-warning edit-answer form-element me-2" style="width:21px;height:21px;" data-id="'+item.id+'"><i class="fas fa-edit fs-8"></i></button>'+
                                                    '<button type="button" class="btn btn-sm btn-icon btn-light-danger delete-answer form-element me-2" style="width:21px;height:21px;" data-id="'+item.id+'"><i class="fas fa-trash fs-8"></i></button>'+
                                                    '<input class="form-check-input answer" name="answer['+item.question_id+'][]" type="checkbox" value="'+item.content+'" data-id="'+item.id+'" id="checkbox_answer_'+item.id+'">'+
                                                    '<label class="form-check-label" for="checkbox_answer_'+item.id+'">'+item.content+''+(item.is_trigger == 1 ? '<span class="badge badge-warning mx-1 form-element">Trigger</span>' : '')+''+(item.is_required == 1 ? '<span class="badge badge-primary mx-1 form-element">Mandatory</span>' : '')+'</label>'+
                                                '</div>';

                                                if(item.show_freetext == 1){
                                                    el += '<div class="form-group mt-5 mb-2 freetext" id="answer_freetext_'+item.id+'" style="display:none">'+
                                                        '<div class="row">'+
                                                            '<div class="col-12">'+
                                                                '<input class="form-control form-control-solid" id="freetext_'+item.id+'" placeholder="Please enter '+item.content+' here" name="freetext['+item.question_id+']" type="text">'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>';
                                                }

                                    el += '</div>';
                                }
                            })

                            $('#question_'+question.id+' .answer-container').append(el)
                        }else{
                            console.log($('#question_'+question.id+' .answer-container'))
                            $('#question_'+question.id+' .answer-container').append('<div class="form-group mb-2">No {{config('dynamic-survey.answer')}}(s) Defined</div>')
                        }

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
                $('.form-check-input').on('click',function(){
                    var id = $(this).data('id');
                    if($(this).is(':checked')){
                        $('#answer_freetext_'+id).show();
                    }else{
                        $('#answer_freetext_'+id).hide();
                    }
                })

                $('.answer').on('click',function(){
                    var answer_id = $(this).data('id');
                    var parent_id = $(this).closest('.question').data('id');
                    if(localStorage.getItem('preview_mode') == 1){
                        if($(this).is(':checked')){
                            $('.question[data-parent-id="'+parent_id+'"][data-answer-id="'+answer_id+'"]').show()
                        }else{
                            $('.question[data-parent-id="'+parent_id+'"][data-answer-id="'+answer_id+'"]').hide() 
                        }
                    }

                })

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
            })
        }else{
            if(question.answer_type == 'text'){
                el += '<div class="form-group mb-2 1">'+
                        '<input class="form-control form-control-solid" placeholder="Please enter Answer here" name="answer['+question.id+']" type="text">'+
                        '<div class="error-container"></div>'+
                    '</div>';
            }
            $('#question_'+question.id+' .answer-container').append(el)
        }

    }

    $('.form-check-input').on('click',function(){
        var id = $(this).data('id');
        if($(this).is(':checked')){
            $('#answer_freetext_'+id).show();
        }else{
            $('#answer_freetext_'+id).hide();
        }
    })

    function previewMode(mode = null) {
        if(mode == 'force'){
            $('.form-element').remove();
            $('.question-col').removeClass('col-7');
            $('.question-col').addClass('col-12');
            $('.btn-submit').show();
        }else{
            if(localStorage.getItem('preview_mode') == 1){
                localStorage.setItem('preview_mode',0);
                $('.preview-btn').removeClass('btn-success');
                $('.preview-btn').addClass('btn-warning');
                $('.alert-editing-mode').attr('style','display:flex !important');
                $('.alert-preview-mode').attr('style','display:none !important');
                $('.form-element').show();
                $('.question-col').removeClass('col-12');
                $('.question-col').addClass('col-7');
                $('.btn-submit').hide();

                $('.question[data-parent-id]').show();
            }else{
                localStorage.setItem('preview_mode',1);
                $('.preview-btn').removeClass('btn-warning');
                $('.preview-btn').addClass('btn-success');
                $('.alert-editing-mode').attr('style','display:none !important');
                $('.alert-preview-mode').attr('style','display:flex !important');
                $('.form-element').hide();
                $('.question-col').removeClass('col-7');
                $('.question-col').addClass('col-12');
                $('.btn-submit').show();

                $('.question[data-parent-id]').hide();
            }
        }
    }

    $('.page-link').on('click',function(e){
        e.preventDefault();

        var id = $(this).data('id');
        $('.section').hide();
        $('#section_'+id).show();

        localStorage.setItem('active_section',id);

        $('.page-item').removeClass('active');
        $(this).parent().addClass('active');
    })

    $('.answer').on('click',function(){
        var answer_id = $(this).data('id');
        var parent_id = $(this).closest('.question').data('id');
        if(localStorage.getItem('preview_mode') == 1){
            if($(this).is(':checked')){
                $('.question[data-parent-id="'+parent_id+'"][data-answer-id="'+answer_id+'"]').show()
            }else{
                $('.question[data-parent-id="'+parent_id+'"][data-answer-id="'+answer_id+'"]').hide() 
            }
        }

    })

    function publishSurvey(text) {
        Swal.fire({
            text: 'Do you want to '+text+' this {{config('dynamic-survey.survey')}}?',
            icon: 'question',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, "+text+" it!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-danger"
            }
        }).then((choice) => {
            if (choice.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url:  '{{route('sop.publish',['id' => encrypt_id($data->id)])}}',
                    beforeSend: function()
                    {   
                        // $('#modal_create_section_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
                    },
                    success: function (result) {
                        if(result.success){
                            // swaling({'text': result.message, 'icon': 'success'})
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
            }else{
                if($('.publish-switch').is(':checked')){
                    $('.publish-switch').prop('checked',false)
                }else{
                    $('.publish-switch').prop('checked',true)
                }
            }
        })
    }

    $('.bulk-create-answer').on('click',function(){
        $('#bulk_create_question_id').val($(this).data('questionId'))
        $('#modal_bulk_create').modal('show')
    });

</script>

@endpush
