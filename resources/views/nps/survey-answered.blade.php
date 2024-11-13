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
                    <form id="steps" class="show-section" method="post" enctype="multipart/form-data" action="#">

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

                                    <!-- step-2 form -->
                                    <div id="step2" class="form-inner">

                                        <div class="steps-inner mt-4 mb-4">

                                            <div style="text-align: center;">
                                                <img src="{{ asset('assets/images/image-answered.jpeg') }}" style="max-width: 180px !important; margin-bottom: 30px;">
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <div class="radio-box">
                                                        <label style="text-align:center">
                                                            <h3>Terima kasih. Survey Anda telah diisi. Semoga sehat selalu!</h3>
                                                        </label>
                                                        
                                                    </div>
                                                    
                                                </div>


                                               
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
        

    <!-- My js -->
    {{-- <script src="{{asset('assets/js/custom.js')}}"></script> --}}
</body>
</html>