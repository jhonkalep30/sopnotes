<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Bootstrap-5 -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

    <!-- custom-styles -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animation.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

    <style>
        input[type="checkbox"] {
          display: none;
        }

        input[type="checkbox"] + label {
          font-size: 18px;
          cursor: pointer;
          border-radius: 50px;
          background-color: #fff;
          border:solid 2px #1FBED6;
          color:#1FBED6;
          padding: 0.25rem 1rem;
          display: inline-block;
          -moz-user-select: -moz-none;
          -webkit-user-select: none;
          -ms-user-select: none;
          user-select: none;
          white-space: nowrap;
          font-size:10px;
        }


        input[type="checkbox"]:checked + label {
          background-color: #1FBED6;
          color: white;
          border-color:#1FBED6;
          white-space: nowrap;
          font-size:10px;
        }

        .custom-label-radio > span {
            cursor: pointer !important;
        }

    </style>

</head>
<body>
    <main>
        <div class="inner">

            <header class="{{-- d-lg-flex d-none --}}">
                <div class="logo">
                    <div class="logo-icon">
                        <img class="m-logo" src="{{ @setting('nps_logo') ?? asset('assets/images/logo.png')}}" alt="Logo Kimia Farma">
                    </div>
                    <!-- <div class="logo-text">
                        Kimia Farma
                    </div> -->
                </div>
                <div class="bar-end">
                    <h3><i class="fa-solid fa-square-phone-flip"></i>Bantuan? {!! @setting('nps_nomor_bantuan') ?? '1500 255' !!}</h3>
                </div>
            </header>

            {{-- <div class="d-lg-none d-block align-items-center" style="text-align:center;">
                <div class="">
                    <div class="logo-icon">
                        <img style="margin-top: 20px;" class="m-logo" src="{{ @setting('nps_logo') ?? asset('assets/images/logo.png')}}" alt="Logo Kimia Farma">
                    </div>
                    
                </div>
                <div class="bar-end mt-4">
                    <h3><i class="fa-solid fa-square-phone-flip"></i>Bantuan? {!! @setting('nps_nomor_bantuan') ?? '1500 255' !!}</h3>
                </div>
            </div> --}}

            <div class="container">
                <div class="wrapper my-4">

                    <!-- form -->
                    <form id="steps" class="show-section" method="post" enctype="multipart/form-data" action="{{route('nps.survey.save')}}?id_transaksi={{$id_transaksi}}">

                        <input require type="hidden" name="email" id="mail-email" value="me@klakklik.id">

                                <!-- step2 -->
                                <section class="steps pt-4">
                                    <!-- <article>
                                        <div class="main-heading">
                                            Masukan Anda
                                        </div>
                                        <div class="main-text">
                                            Silahkan berikan penilaian Anda pada kolom yang telah Kami Sediakan.
                                        </div>
                                    </article> -->

                                    @php
                                        $scoringTags = App\Models\NPS\ScoringTag::all();
                                        $scoringValues = App\Models\NPS\ScoringValue::all();
                                    @endphp

                                    <!-- step-2 form -->
                                    <div id="step2" class="form-inner">

                                        <div class="steps-inner mt-0">

                                            <div style="text-align: center;">
                                                <img src="{{ asset('assets/images/image-survey.jpeg') }}" style="max-width: 180px !important;" class="mb-4">
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <div class="radio-box">
                                                        <label style="text-align:center">
                                                            <h3>Berdasarkan kunjungan terakhir, seberapa besar kemungkinan Anda merekomendasikan kami kepada teman atau rekan kerja?</h3>
                                                            <br>
                                                            <i style="color:grey;">Based on recent visit, how likely are you to recommend us to a friend or colleague?</i>
                                                            <br><br>
                                                        </label>
                                                        <div class="radio-single">
                                                            <div class="col-12 col-md-12">
                                                                <div class="row">
                                                                    @foreach($scoringValues as $key => $item)
                                                                    <div class="col-1">
                                                                        <label class="custom-label-radio">
                                                                            <input type="radio" name="scoring_value" class="{{strtolower($item->level)}}" value="{{$item->value}}" />
                                                                            <span {!! ($key+1) == $scoringValues->count() ? "style='left: -3px;'" : '' !!}>{{$item->value}}</span>
                                                                        </label>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <span style="font-weight: bold;" class="txt-left txt-f-10">Sangat Tidak Mungkin</span>
                                                    <span style="font-weight: bold;" class="txt-right txt-f-10">Sangat Mungkin</span>
                                                    <br>
                                                    <span style="font-weight: bold;" class="txt-left txt-f-10">Very Unlikely</span>
                                                    <span style="font-weight: bold;" class="txt-right txt-f-10">Very Likely</span>
                                                </div>

                                                @foreach($scoringTags->groupBy('level') as $level => $items)
                                                    @php
                                                        $word = 'sukai';
                                                        if($level != 'Promoters') $word = 'kurang sukai';
                                                    @endphp
                                                    <div class="col-md-12 top-margin-20 feedback" id="box-{{strtolower($level)}}" style="display: none;">
                                                        <div class="radio-box" align="center">
                                                            <label>
                                                                Apa yang Anda {{$word}} dari layanan Kami?
                                                            </label>
                                                            <div class="radio-single">
                                                                <div class="col-md-12">
                                                                    {{-- <div class="row"> --}}
                                                                        @foreach($items as $item)
                                                                        {{-- <div class="col-3"> --}}
                                                                            <input type="checkbox" name="scoring_tags[]" id="scoring_tags_{{$item->id}}" value="{{$item->value}}" data-show-freetext="{{$item->show_freetext}}"/>
                                                                            <label for="scoring_tags_{{$item->id}}">{{$item->label}}</label>
                                                                        {{-- </div> --}}
                                                                        @endforeach
                                                                    {{-- </div> --}}
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="col-md-12" id="box-desc" style="display: none;margin-top: 50px;">
                                                    <div class="input-field">
                                                        <label for="description">
                                                            Lainnya (Beri Komentarmu)
                                                        </label>
                                                        <textarea class="textarea" name="notes" id="notes"></textarea>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <div class="next-prev">
                                                 <button type="submit" id="step4btn" class="next" style="width: 100%;">Kirim</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="right-map">
                                        <img src="assets/images/right.png" alt="">
                                    </div> -->
                                </section>
                    </form>
                </div>
            </div>

            {{-- <div class="d-lg-none d-block align-items-center" style="text-align:center; margin-top: 30px;">
                <div class="bar-end">
                    <h3><i class="fa-solid fa-square-phone-flip"></i>Bantuan? {!! @setting('nps_nomor_bantuan') ?? '1500 255' !!}</h3>
                </div>
            </div> --}}

            <footer>    
                <!-- <ul class="links">
                    <li><a href="#">SOP Notes</a></li>
                </ul>             -->
            </footer>

        </div>
    </main>

    <div id="error">

    </div>

    <!-- Bootstrap-5 -->
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

    <!-- Jquery -->
    <script src="{{asset('assets/js/jquery-3.6.1.min.js')}}"></script>
        
    <script>
        @foreach($scoringTags->groupBy('level') as $level => $items)
            $('.{{strtolower($level)}}').on('change',function(){
                var tagClass = $(this).attr('class');
                $('input[name="scoring_tags[]"]').prop('checked',false);
                $('.feedback').hide();
                $('#box-desc').hide();
                $('#notes').val('');
                $('#box-'+tagClass).show();

                $('#box-'+tagClass+' input[name="scoring_tags[]"]').on('change',function(){
                    var showFreeText = $('#box-'+tagClass+' input[name="scoring_tags[]"][data-show-freetext="1"]:checked');
                    if(showFreeText.length > 0){
                        $('#box-desc').show();
                    }else{
                        $('#box-desc').hide();
                    }
                })
            })

        @endforeach
    </script>

    <!-- My js -->
    {{-- <script src="{{asset('assets/js/custom.js')}}"></script> --}}
</body>
</html>