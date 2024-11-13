@extends(config('theme.layouts.admin'),[
    'title' => 'Checklist',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'SOP',
            'url' => route('sop.view')
        ],
        ['label' => 'Checklist'],
    ]

])

@push('additional-css')
<style type="text/css">
    .form-element{
        display:none !important;
    }
    .feedback-element{
        display:none;
    }
    .question[data-parent-id]{
        display:none;
    }
    .btn-start{
        position:fixed;
        top:45vh;
        right:0px;
        z-index:999;
        width:80px;
        border-radius:50px 0px 0px 50px;
    }
    .btn-information{
        position:fixed;
        top:53vh;
        right:0px;
        z-index:999;
        width:80px;
        border-radius:50px 0px 0px 50px;
    }
</style>
@endpush

@section('content')
    <button type="button" class="btn btn-md btn-success btn-start mb-5 shadow-sm">Mulai</button>
    <button type="button" class="btn btn-md btn-info btn-information mb-5 shadow-sm">Info</button>
    @component(config('theme.components').'.card',['name' => 'form_creator_card','headerPadding' => 'pt-0','minHeight' => '0px'])
        <div class="row">
            <form id="form_sop" method="POST" action="{{route('checklist.save')}}?id={{encrypt_id($data->id)}}">
                @csrf
                <div class="col-12 section-container">
                    @if($data->question_groups) 
                        @foreach($data->question_groups as $key =>  $group)
                            <div class="section pb-5" id="section_{{$group->id}}" data-id="{{$group->id}}" style="display:{{$key == 0 ? 'block' : 'none'}};">
                                <div align="center">
                                    <div class="row">
                                        <h2 class="text-info">{{$group->name}}
{{--                                             <a href="#" class="feedback-element feedback-question-group" data-id="{{$group->id}}"><i class="fas fa-comment-dots text-warning mx-1"></i>
                                                <input type="hidden" class="feedback-input" name="feedback[question_group][{{$group->id}}]" id="feedback_question_group_{{$group->id}}">
                                            </a> --}}
                                        </h2>
                                        <div class="col-12">{{$group->description}}</div>
                                    </div>
                                </div>

                                <div class="question-container pt-7" style="display:{{count($data->question_groups) > 0 ? 'block' : 'none'}};">
                                    @foreach($group->questions as $question)
                                        <div class="row question" id="question_{{$question->id}}" {{@$question->parent_id ? 'data-parent-id='.$question->parent_id : ''}} {{@$question->answer_id ? 'data-answer-id='.$question->answer_id : ''}} data-id="{{$question->id}}">
                                            <div class="col-12">
                                                <div class="row mb-2">
                                                    <div class="col-12 question-col">
                                                        <h4 class="mt-2">{{$question->content}} {!! $question->is_required == 1 ? '<small class="text-danger">*</small>' : ''!!}
                                                        <a href="#" class="feedback-element feedback-question"><i class="fas fas fa-comment-dots text-warning mx-1"></i>
                                                            <input type="hidden" class="feedback-input" name="feedback[question][{{$question->id}}]" id="feedback_question_{{$question->id}}">
                                                        </a>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row answer-container">
                                                    @if($question->answer_type == 'text')
                                                        {{ 
                                                            Form::textInput('answer['.$question->id.']',null,['useLabel' => false,'labelText' => 'Answer','elOptions' => array_merge(['id' => 'answer_'.$question->id],$question->is_required == 1 ? ['required' => 'required'] : [])])
                                                        }}
                                                    @else
                                                        @if($question->answers)
                                                            @forelse($question->answers as $answer)
                                                                <div class="col-12 pb-5 answer-group" data-id="{{$answer->id}}">
                                                                    <div class="form-check form-check-custom form-check-solid">
                                                                        <input class="form-check-input answer" name="answer[{{$question->id}}][]" type="checkbox" value="{{$answer->content}}" data-required-status="{{$answer->is_required}}" data-id="{{$answer->id}}" id="checkbox_answer_{{$answer->id}}" {{$answer->is_required == 1 ? 'required' : ''}}/>
                                                                        <label class="form-check-label" for="checkbox_answer_{{$answer->id}}">
                                                                            {{$answer->content}}
                                                                            <a href="#" class="feedback-element feedback-answer"><i class="fas fa-comment-dots text-warning mx-2"></i>
                                                                                <input type="hidden" class="feedback-input" name="feedback[answer][{{$answer->id}}]" id="feedback_answer_{{$answer->id}}">
                                                                            </a>
                                                                        </label>
                                                                    </div>
                                                                    @if($answer->show_freetext == 1)
                                                                    <div class="form-group mt-5 mb-2 freetext" id="answer_freetext_{{$answer->id}}" style="display:none">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <input class="form-control form-control-solid" id="freetext_{{$answer->id}}" placeholder="Please enter {{$answer->content}} here" name="freetext[{{$question->id}}][{{$answer->content}}]" type="text" {{$answer->is_required == 1 ? 'required' : ''}}>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            @empty
                                                                <div class="form-group mb-2">
                                                                    No Answer(s) Defined
                                                                </div>
                                                            @endforelse
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-md btn-primary btn-forward mb-5" style="width:100%;display:none">{{$data->frequency == 'routine' ? 'Saya akan laksanakan' : 'Saya mengisi dengan jujur'}}</button>
                    <button type="submit" id="btn_submit" style="display:none"></button>
                </div>
            </form>
        </div>
        @if($data->question_groups && count($data->question_groups) > 1) 
        <div class="row">
            <hr style="border: 1px dashed #ccc">
            <div class="col-12 d-flex justify-content-center navigator-container">
                <ul class="pagination pagination-circle pagination-outline mb-5 pagination-section">
                @foreach($data->question_groups as $key => $group)
                    <li class="page-item {{$key == 0 ? 'active' : ''}}" id="page_item_{{$group->id}}">
                        <a class="page-link" id="page_link_{{$group->id}}" data-id="{{$group->id}}" href="#">{{$key+1}}</a>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
        @endif
    @endcomponent

    <!-- Modal Ajax Form -->
    <div class="modal fade" tabindex="-1" id="information" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="modalContent_information">

                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h3 class="fw-bold modal-title" id="information_modal_title">Informasi Pengisian</h3>
                    <!--end::Modal title-->
                </div>

                <div class="modal-body" style="max-height: 60vh; overflow-y: scroll;">
                    <div class="mx-3 mb-2">
                        <table style="width:100%">
                            <tr>
                                <td style="width:120px" valign="top"><strong>Nama</strong></td>
                                <td style="width:10px" valign="top">:</td>
                                <td valign="top">{{$data->name}}</td>
                            </tr>
                            <tr>
                                <td valign="top"><strong>Tanggal Publish</strong></td>
                                <td valign="top">:</td>
                                <td valign="top">{{Carbon\Carbon::parse($data->published_at)->translatedFormat('d F Y H:i:s')}}</td>
                            </tr>
                            <tr>
                                <td valign="top"><strong>Deskripsi</strong></td>
                                <td valign="top">:</td>
                                <td valign="top">{{@$data->description ?? '-'}}</td>
                            </tr>
                        </table>
                    </div> 
                    <ol>
                        <li>Anda dapat melakukan pengisian dengan cara mengklik tombol <span class="badge badge-success">Mulai</span></li>
                        <li>Jika anda sudah mengklik tombol <span class="badge badge-success me-1">Mulai</span>, maka durasi pengisian akan dimulai secara otomatis dan akan tersimpan kedalam sistem</li>
                        <li>Jika anda sudah memulai pengisian namun anda meninggalkan halaman atau menutup aplikasi, maka durasi pengisian akan terus terhitung sampai anda menyelesaikan pengisian</li>
                        <li>Jika anda melakukan <span class="text-warning fw-bolder">refresh atau keluar dari halaman pengisian</span>, maka <span class="text-danger fw-bolder">isian dan feedback anda akan ter-reset</span></li>
                        <li>Jika anda ingin melakukan feedback terhadap SOP yang sedang anda isi, silahkan berikan feedback dengan cara mengklik icon <i class="fas fa-comment-dots text-warning"></i> disetiap bagian yang tersedia</li>
                        <li>Bagian yang sudah anda berikan feedback akan ada icon <i class="fas fa-comment-dots text-primary"></i></li>
                    </ol>
                    <div class="mx-3 mb-2">
                        <strong>Lampiran</strong>
                    </div>
                    <div class="mx-3">
                        @foreach($data->files as $key => $file)
                            <a href="{{$file->file_path}}" target="_blank" class="btn btn-sm btn-primary my-2 me-2"><i class="fas fa-download"></i> Lihat Lampiran #{{$key+1}}</a>
                        @endforeach
                    </div>
                    @if(@$data->url)
                        <div class="mx-3 mb-2">
                            <a href="{{$data->url}}" target="_blank" class="btn btn-sm btn-primary my-2"><i class="fas fa-external-link"></i> Buka Link</a>
                        </div>
                    @endif
                    <div class="mx-3 mb-2">
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input answer" name="understand_check" type="checkbox" value="1" id="understand_check">
                            <label class="form-check-label text-dark" for="understand_check">
                                Saya telah membaca informasi pengisian diatas dan saya ingin melanjutkan!
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-primary btn-understand" data-bs-dismiss="modal">Ya, saya mengerti!</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ajax Form -->
    <div class="modal fade" tabindex="-1" id="user_feedback" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content" id="modalContent_user_feedback">

                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h3 class="fw-bold modal-title" id="user_feedback_modal_title">User Feedback</h3>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body" style="max-height: 60vh; overflow-y: scroll;">
                    {{-- <div class="row col-12 mb-2">
                        <span class="fw-semibold fs-6">Bagian Yang Ingin Diberikan Masukan:</span>
                        <div class="feedback-content"></div>
                    </div> --}}
                    <form id="form_user_feedback">
                        {{-- <div class="feedback-div"></div> --}}

                        {{
                            Form::textareaInput('feedback',null,[
                                'formAlignment' => 'vertical',
                                'useLabel' => false,
                                'elOptions' => [
                                    'rows' => 3,
                                ]
                            ])
                        }}
                    </form>
                </div>

                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-primary btn-submit-feedback">Simpan</button>
                    <button type="button" class="btn btn-danger btn-reset-feedback me-3">Reset</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('additional-js')

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        var elements = document.getElementsByTagName("INPUT");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("Tidak boleh kosong");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
    })

    $(document).ready(function(){
        localStorage.removeItem('active_section');
        @if(@$data->latestReportByAuth())
            @if(@$data->latestReportByAuth()->ended_at == null)
                $('.btn-start').hide();
                $('.btn-forward').show();
                $('.btn-information').css('top','50vh');
                $('.feedback-element').css('display','inline');
            @else
                $(':input').prop('disabled',true)
                $('.btn-understand').prop('disabled',false);
                $('#information').modal('show');
            @endif
                $('#understand_check').click();
        @else
            $(':input').prop('disabled',true)
            // $('.btn-understand').prop('disabled',false);
            $('#information').modal('show');
        @endif
        $('#understand_check').prop('disabled',false)
        $('.btn-information').prop('disabled',false);
    });

    $('#understand_check').on('click',function(){
        if($(this).is(':checked')){
            $('.btn-understand').prop('disabled',false)
        }else{
            $('.btn-understand').prop('disabled',true)
        }
    })

    $('.btn-information').on('click',function(){
        $('#information').modal('show')
    });

    $('.btn-understand').on('click',function(){
        $('.btn-start').prop('disabled',false)
    });

    $('.btn-start').on('click',function(){
        Swal.fire({
            title: 'Mulai pengisian?',
            text: 'Pastikan anda sudah menyediakan waktu untuk pengisian!',
            icon: 'question',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Ya, mulai!",
            cancelButtonText: "Batalkan",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-danger"
            }
        }).then((choice) => {
            if (choice.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url:  '{{route('checklist.start')}}',
                    data: {id:'{{encrypt_id($data->id)}}'},
                    success: function (result) {
                        if(result.success){
                            $(':input').prop('disabled',false)
                            $('.btn-start').hide();
                            $('.btn-forward').show();
                            $('.feedback-element').css('display','inline');
                        }else{
                            swaling({'text': result.message, 'icon': 'error'})
                            displayErrorInput(formEl, result.errors)
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        toasting()
                    }
                })
            }
        });
    })

    $('.btn-forward').on('click',function(){
        Swal.fire({
            title: 'Selesaikan pengisian?',
            text: 'Pastikan isian anda sudah sesuai!',
            icon: 'question',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Ya, selesaikan!",
            cancelButtonText: "Batalkan",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-danger"
            }
        }).then((choice) => {
            if (choice.isConfirmed) {
                setTimeout(function(){
                    $('#btn_submit').click();
                },500)
            }
        })
    });

    $('.form-check-input').on('click',function(){
        var id = $(this).data('id');
        if($(this).is(':checked')){
            $('#answer_freetext_'+id).show();
        }else{
            $('#answer_freetext_'+id).hide();
        }
    })

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

    $('.feedback-element').on('click',function(e){
        e.preventDefault();
        if(!$(this).hasClass('feedback-question-group')){
            // if($(this).find('.feedback-input').val() == null || $(this).find('.feedback-input').val() == ''){
                Swal.fire({
                    title: 'Lewati pengisian?',
                    // text: 'Pastikan isian anda sudah sesuai!',
                    icon: 'question',
                    showCancelButton: false,
                    showDenyButton: true,
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    confirmButtonText: "Lewati & Berikan Feedback",
                    denyButtonText: 'Tetap Isi & Berikan Feedback',
                    cancelButtonText: "Batalkan",
                    customClass: {
                        confirmButton: "btn btn-danger",
                        denyButton: "btn btn-primary",
                        cancelButton: "btn btn-secondary",
                    }
                }).then((choice) => {
                    if (choice.isConfirmed) {
                        localStorage.setItem('skip_task',1)
                    }else if (choice.isDenied) {
                        localStorage.setItem('skip_task',0)
                    }

                    $('#user_feedback').modal('show');
                    if($(this).find('.feedback-input').val() == null || $(this).find('.feedback-input').val() == ''){
                        $('.btn-reset-feedback').hide();
                    }else{
                        $('.btn-reset-feedback').show();
                    }
                    $('#feedback').val($(this).find('.feedback-input').val());
                    $('.btn-submit-feedback').data('elementId',$(this).find('.feedback-input').attr('id'))
                });
            // }else{
            //     $('#user_feedback').modal('show');
            //     $('#feedback').val($(this).find('.feedback-input').val());
            //     $('.btn-submit-feedback').data('elementId',$(this).find('.feedback-input').attr('id'))
            // }
        }else{
            $('#user_feedback').modal('show');
            $('#feedback').val($(this).find('.feedback-input').val());
            $('.btn-submit-feedback').data('elementId',$(this).find('.feedback-input').attr('id'))
        }
    })

    $('.btn-submit-feedback').on('click',function(){
        if(localStorage.getItem('skip_task') == "1" && ($('#feedback').val() == null || $('#feedback').val() == '')){
            swaling({'text': 'Anda harus mengisi feedback', 'icon': 'error'})
        }else{
            $('#'+$(this).data('elementId')).val($('#feedback').val())
            if($('#feedback').val() == null || $('#feedback').val() == ''){
                $('#'+$(this).data('elementId')).closest('.feedback-element').find('.fa-comment-dots').removeClass('text-primary');
                $('#'+$(this).data('elementId')).closest('.feedback-element').find('.fa-comment-dots').addClass('text-warning');
                if($('#'+$(this).data('elementId')).closest('.question-col').length > 0){
                    $.each($('#'+$(this).data('elementId')).closest('.question').find('.answer'),function(key,item){
                        if($(item).data('requiredStatus') == 1){
                            $(item).prop('required',true);
                        }else{
                            $(item).prop('required',false);
                        }

                        $(item).closest('.form-check').find('.form-check-label .fa-exclamation-triangle').remove();
                    }); 
                }

                if($('#'+$(this).data('elementId')).closest('.answer-group').length > 0){
                    var el = $('#'+$(this).data('elementId')).closest('.form-check').find('.answer')
                    if(el.data('requiredStatus') == 1){
                        el.prop('required',true);
                    }else{
                        el.prop('required',false);
                    }

                    $('#'+$(this).data('elementId')).closest('.form-check-label').find('.fa-exclamation-triangle').remove();
                }
            
            }else{
                $('#'+$(this).data('elementId')).closest('.feedback-element').find('.fa-comment-dots').removeClass('text-warning');
                $('#'+$(this).data('elementId')).closest('.feedback-element').find('.fa-comment-dots').addClass('text-primary');
                if($('#'+$(this).data('elementId')).closest('.question-col').length > 0){
                    $.each($('#'+$(this).data('elementId')).closest('.question').find('.answer'),function(key,item){
                        if(localStorage.getItem('skip_task') == "1"){
                            $(item).prop('required',false);
                            $(item).closest('.form-check').find('.form-check-label .fa-exclamation-triangle').remove();
                            $(item).closest('.form-check').find('.form-check-label').append('<i class="fas fa-exclamation-triangle text-danger"></i>');
                        }else{
                            $(item).prop('required',true);
                            $(item).closest('.form-check').find('.form-check-label .fa-exclamation-triangle').remove();
                        }
                    });
                }

                if($('#'+$(this).data('elementId')).closest('.answer-group').length > 0){
                    if(localStorage.getItem('skip_task') == "1"){
                        $('#'+$(this).data('elementId')).closest('.form-check').find('.answer').prop('required',false);
                        $('#'+$(this).data('elementId')).closest('.form-check-label').find('.fa-exclamation-triangle').remove();
                        $('#'+$(this).data('elementId')).closest('.form-check-label').append('<i class="fas fa-exclamation-triangle text-danger"></i>');
                    }else{
                        $('#'+$(this).data('elementId')).closest('.form-check').find('.answer').prop('required',true);
                        $('#'+$(this).data('elementId')).closest('.form-check-label').find('.fa-exclamation-triangle').remove();
                    }
                }
            }
        }

        $('#feedback').val('');
        $('#user_feedback').modal('hide');
    })

    $('.btn-reset-feedback').on('click',function(){
        $('#feedback').val('');
        $('.btn-submit-feedback').click();
    });
</script>

@endpush
