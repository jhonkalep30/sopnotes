<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Bootstrap-5 -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- custom-styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body>
    <main>
        <div class="inner">
            <header>
                <div class="logo">
                    <div class="logo-icon">
                        <img class="m-logo" src="assets/images/logo.png" alt="Logo Kimia Farma">
                    </div>
                    <!-- <div class="logo-text">
                        Kimia Farma
                    </div> -->
                </div>
                <div class="bar-end">
                    <h3><i class="fa-solid fa-square-phone-flip"></i>Need Help? <span>Call an Support  +62 812 1111 333</span></h3>
                </div>
            </header>
            <div class="container">
                <div class="wrapper">

                    <!-- form -->
                    <form id="steps" class="show-section" method="post" enctype="multipart/form-data">
                        <input require type="hidden" name="email" id="mail-email" value="me@klakklik.id">

                                <!-- step2 -->
                                <section class="steps">
                                    <article>
                                        <div class="main-heading">
                                            Masukan Anda
                                        </div>
                                        <div class="main-text">
                                            Silahkan berikan penilaian Anda pada kolom yang telah Kami Sediakan.
                                        </div>
                                    </article>

                                    <!-- step-2 form -->
                                    <div id="step2" class="form-inner">
                                        <div class="steps-inner lightSpeedIn">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="radio-box">
                                                        <label>
                                                            Seberapa besar anda merekomendasikan layanan lab/klinik Kimia Farma kepada teman anda?
                                                        </label>
                                                        <div class="radio-single">
                                                            <label class="custom-label-radio">
                                                                <input type="radio" name="options" class="bad-value"/>
                                                                <span>0</span>
                                                            </label>
                                                            <label class="custom-label-radio">
                                                                <input type="radio" name="options" class="bad-value"/>
                                                                <span>1</span>
                                                            </label>
                                                            <label class="custom-label-radio">
                                                                <input type="radio" name="options" class="bad-value"/>
                                                                <span>2</span>
                                                            </label>
                                                            <label class="custom-label-radio">
                                                                <input type="radio" name="options" class="bad-value"/>
                                                                <span>3</span>
                                                            </label>
                                                            <label class="custom-label-radio">
                                                                <input type="radio" name="options" class="bad-value"/>
                                                                <span>4</span>
                                                            </label>
                                                            <label class="custom-label-radio">
                                                                <input type="radio" name="options" class="bad-value"/>
                                                                <span>5</span>
                                                            </label>
                                                            <label class="custom-label-radio">
                                                                <input type="radio" name="options" class="bad-value"/>
                                                                <span>6</span>
                                                            </label>
                                                            <label class="custom-label-radio">
                                                                <input type="radio" name="options" class="bad-value"/>
                                                                <span>7</span>
                                                            </label>
                                                            <label class="custom-label-radio">
                                                                <input type="radio" name="options" class="bad-value"/>
                                                                <span>8</span>
                                                            </label>
                                                            <label class="custom-label-radio">
                                                                <input type="radio" name="options" class="good-value"/>
                                                                <span>9</span>
                                                            </label>
                                                            <label class="custom-label-radio">
                                                                <input type="radio" name="options" class="good-value"/>
                                                                <span style="left:-32px">10</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <span class="txt-left txt-f-10">Tidak Merekomendasikan</span>
                                                    <span class="txt-right txt-f-10">Sangat Merekomendasikan</span>
                                                </div>
                                                <div class="col-md-12 top-margin-20" id="box-liked">
                                                    <div class="radio-box">
                                                        <label>
                                                            Apa yang Anda sukai dari layanan Kami?
                                                        </label>
                                                        <div class="radio-single">
                                                            <label class="big-custom-label-radio">
                                                                <input type="radio" name="options"/>
                                                                <span>Cepat</span>
                                                            </label> 
                                                            <label class="big-custom-label-radio">
                                                                <input type="radio" name="options"/>
                                                                <span>Ramah</span>
                                                            </label> 
                                                            <label class="big-custom-label-radio">
                                                                <input type="radio" name="options"/>
                                                                <span>Bersih</span>
                                                            </label> 
                                                            <label class="big-custom-label-radio">
                                                                <input type="radio" name="options"/>
                                                                <span>Lengkap</span>
                                                            </label> 
                                                        </div>
                                                        <div class="radio-single">
                                                            <label class="big-custom-label-radio" style="margin-right: -74px;">
                                                                <input type="radio" name="options" style="width: 95px;"/>
                                                                <span style="left:-95px;">Tidak Sakit</span>
                                                            </label> 
                                                            <label class="big-custom-label-radio" style="margin-right: -74px;">
                                                                <input type="radio" name="options" style="width: 95px;"/>
                                                                <span style="left:-95px;">Tidak Antri</span>
                                                            </label> 
                                                            <label class="big-custom-label-radio" style="margin-right: -74px;">
                                                                <input type="radio" name="options" style="width: 95px;"/>
                                                                <span style="left:-95px;">Lainnya</span>
                                                            </label> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 top-margin-20" id="box-unliked">
                                                    <div class="radio-box">
                                                        <label>
                                                            Apa yang Anda kurang sukai dari layanan Kami?
                                                        </label>
                                                        <div class="radio-single">
                                                            <label class="big-custom-label-radio" style="margin-right: -53px">
                                                                <input type="radio" name="options"/>
                                                                <span>Lambat</span>
                                                            </label> 
                                                            <label class="big-custom-label-radio" style="margin-right: -40px">
                                                                <input type="radio" name="options"/>
                                                                <span>Antri</span>
                                                            </label> 
                                                            <label class="big-custom-label-radio" style="margin-right: -53px">
                                                                <input type="radio" name="options" style="width: 100px;"/>
                                                                <span style="left:-105px;">Kurang Ramah</span>
                                                            </label>
                                                        </div>
                                                        <div class="radio-single">
                                                            <label class="big-custom-label-radio" style="margin-right: -43px">
                                                                <input type="radio" name="options"/>
                                                                <span>Kotor</span>
                                                            </label>
                                                            <label class="big-custom-label-radio" style="margin-right: -96px">
                                                                <input type="radio" name="options" style="width: 100px;"/>
                                                                <span style="left:-105px;">Tidak Lengkap</span>
                                                            </label> 
                                                            <label class="big-custom-label-radio" style="margin-right: -74px;">
                                                                <input type="radio" name="options" style="width: 60px;"/>
                                                                <span style="left:-60px;">Nyeri</span>
                                                            </label> 
                                                        </div>
                                                        <div class="radio-single">
                                                            <label class="big-custom-label-radio" style="margin-right: -154px">
                                                                <input type="radio" name="options" style="width: 170px;"/>
                                                                <span style="left:-170px;">Tidak Diberikan Rujukan</span>
                                                            </label>
                                                            <label class="big-custom-label-radio" style="margin-right: -74px;">
                                                                <input type="radio" name="options" style="width: 95px;"/>
                                                                <span style="left:-95px;">Lainnya</span>
                                                            </label> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" id="box-desc">
                                                    <div class="input-field">
                                                        <label for="description">
                                                            Lainnya (Beri Komentarmu)
                                                        </label>
                                                        <textarea class="textarea" name="description" id="description"></textarea>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <div class="next-prev">
                                                <button type="button" id="step4btn" class="next" onclick="loadHomePage();">Submit<i class="fa-solid fa-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="right-map">
                                        <img src="assets/images/right.png" alt="">
                                    </div>
                                </section>
                    </form>
                </div>
            </div>
            <footer>    
                <ul class="links">
                    <li><a href="#">SOP Notes</a></li>
                </ul>            
            </footer>

        </div>
    </main>

    <div id="error">

    </div>

    <script>
        function loadHomePage() {
            window.location.assign("nps-finish");
        }
    </script>
        
    <!-- Bootstrap-5 -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <!-- Jquery -->
    <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>

    <!-- My js -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>
</html>