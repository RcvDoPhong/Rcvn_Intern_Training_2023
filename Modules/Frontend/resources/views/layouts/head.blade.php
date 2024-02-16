<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="Ansonika">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta content='yes' name='apple-mobile-web-app-capable'/>
<meta content='yes' name='mobile-web-app-capable'/>

<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>Frontend Web</title>

<!-- Favicons-->
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

<!-- GOOGLE WEB FONT -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

<!-- Manifest file-->
<link rel="manifest" crossorigin="use-credentials" href="{{ asset('manifest.json') }}">

<!-- BASE CSS -->
<link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

<!-- SPECIFIC CSS -->
<link href="{{ asset('frontend/css/home_1.css') }}" rel="stylesheet">
<link href= "{{ asset('frontend/css/listing.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/product_page.css') }}" rel="stylesheet">


<link href="{{ asset('frontend/css/cart.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/checkout.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/leave_review.css') }}" rel="stylesheet">

<!-- Custom CSS -->

<link rel="stylesheet" href="{{ asset('css/shipping.css') }}">
<link rel="stylesheet" href="{{ asset('css/product.css') }}">


@yield('css')
