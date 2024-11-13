<!--begin::Head-->
<head>
	<title>{{ @setting('website_name') ?? env('APP_NAME', 'Lumina') }} - {{ @setting('website_description') ?? env('APP_DESCRIPTION', 'Laravel Automation Project') }}</title>
	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	{{-- CSRF Token --}}
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="{{ @setting('website_name') ?? env('APP_NAME', 'Lumina') }} - {{ @setting('website_description') ?? env('APP_DESCRIPTION', 'Laravel Automation Project') }}" />
	<meta property="og:url" content="" />
	<meta property="og:site_name" content="{{ @setting('website_name') ?? env('APP_NAME', 'Lumina') }} | {{ @setting('website_description') ?? env('APP_DESCRIPTION', 'Laravel Automation Project') }}" />
	<link rel="canonical" href="" />
	<link rel="shortcut icon" href="{{ @setting('website_favicon') ?? asset(config('theme.assets.back-office').'media/logos/favicon.ico') }}" />
	<!--begin::Fonts(mandatory for all pages)-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Vendor Stylesheets(used for this page only)-->
	{{-- <link href="{{asset(config('theme.assets.back-office').'plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" /> --}}
	<!--end::Vendor Stylesheets-->
	<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
	<link href="{{asset(config('theme.assets.back-office').'plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset(config('theme.assets.back-office').'css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->

	@yield('select2-css')
	@yield('additional-css')
	@stack('additional-css')

	<!--begin::CSS Customize-->
	<link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" />


</head>
<!--end::Head-->