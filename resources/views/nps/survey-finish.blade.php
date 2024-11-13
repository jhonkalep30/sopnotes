<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThankYou</title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Bootstrap-5 -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

    <!-- custom-styles -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animation.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
</head>
<body>
    <main class="main  thankyou-page">
        <div class="main-wrapper">
            <div class="main-inner">
                <div class="logo">
                    <!-- <div class="logo-icon">
                        <img class="m-logo" src="assets/images/logo.png" alt="">
                    </div> -->
                    <!-- <div class="logo-text">
                        Tribma.
                    </div> -->
                </div>
                <article>
                    <img src="{{ @setting('nps_logo') ?? asset('assets/images/logo.png')}}" alt="" width="50%" style="margin-bottom: 50px;">
                    <br><br>
                    <h1 style="text-transform: none;font-family: arial;"><span>Terima Kasih</span>atas penilaian Anda!</h1>
                    <br><br>
                    <h2 style="padding: 10px;">Yuk isi survey 5 menit untuk undian berhadiah! <br> Klik <a href="{{ @setting('nps_hadiah_link') ?? 'javascript:void(0);' }}">di sini</a></h2>
                </article>
        </div>
    </main>

    <!-- Bootstrap-5 -->
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

    <!-- Jquery -->
    <script src="{{asset('assets/js/jquery-3.6.1.min.js')}}"></script>
</body>
</html>