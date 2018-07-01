<head>
    {{-- Google analytics tracking code --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111736331-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		window.ga = window.ga || function () {
			(ga.q = ga.q || []).push(arguments);
		};
		ga.l = +new Date();
		function gtag() {
			dataLayer.push(arguments);
		}

		// Autotrack Modules
		ga("require", "eventTracker");
		ga("require", "outboundLinkTracker");
		ga("require", "urlChangeTracker");
		ga("require", "maxScrollTracker");
		ga("require", "pageVisibilityTracker");
		ga("require", "socialWidgetTracker");
		ga("require", "impressionTracker", {
			elements: ['slogan', 'newsletter', 'timeline', 'insight-product', 'main-content', 'master_nav']
		});
		ga("send", "pageview");
		gtag('config', 'UA-111736331-1');
    </script>
    <script async src="{{ asset('js/libraries/autotrack.js') }}"></script>

    {{-- Facebook Analytics tracking code--}}
    <script>
		window.fbAsyncInit = function () {
			FB.init({
				appId: '153472498701777',
				cookie: true,
				xfbml: true,
				version: 'v2.12'
			});
			FB.AppEvents.logPageView();
		};

		(function (d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {
				return;
			}
			js = d.createElement(s);
			js.id = id;
			js.src = "https://connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
    </script>

    {{-- Site Metadata--}}
    <link rel="alternate" href="https://integrasafe.net/" hreflang="en-us"/>
    <meta property="og:title" content="IntegraSafe, Inc"/>
    <meta property="og:url" content="https://integrasafe.net"/>
    <meta property="og:image" content="https://integrasafe.net/img/integrasafe-logo-enchanted.png"/>
    <meta property="og:image:secure_url" content="https://integrasafe.net/img/integrasafe-logo-enchanted.png"/>
    <meta property="og:description"
          content="We are a start-up with the mission of delivering data-driven products and services."/>

    {{-- Page Metadata --}}
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width,initial-scale=1.0" name="viewport">
    <meta content="follow,index" name="robots">
    <meta name="google-signin-client_id"
          content="1094558923056-6catogigq6bqej22kevv9pqdsa147tes.apps.googleusercontent.com">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    {{-- Device Icons --}}
    {{--<link rel="apple-touch-icon" sizes="57x57" href="/images/icons/apple-touch-icon-57x57.png?v=1">--}}
    {{--<link rel="apple-touch-icon" sizes="60x60" href="/images/icons/apple-touch-icon-60x60.png?v=1">--}}
    {{--<link rel="apple-touch-icon" sizes="72x72" href="/images/icons/apple-touch-icon-72x72.png?v=1">--}}
    {{--<link rel="apple-touch-icon" sizes="76x76" href="/images/icons/apple-touch-icon-76x76.png?v=1">--}}
    {{--<link rel="apple-touch-icon" sizes="114x114" href="/images/icons/apple-touch-icon-114x114.png?v=1">--}}
    {{--<link rel="apple-touch-icon" sizes="120x120" href="/images/icons/apple-touch-icon-120x120.png?v=1">--}}
    {{--<link rel="apple-touch-icon" sizes="144x144" href="/images/icons/apple-touch-icon-144x144.png?v=1">--}}
    {{--<link rel="apple-touch-icon" sizes="152x152" href="/images/icons/apple-touch-icon-152x152.png?v=1">--}}
    {{--<link rel="apple-touch-icon" sizes="180x180" href="/images/icons/apple-touch-icon-180x180.png?v=1">--}}
    {{--<link rel="icon" type="image/png" href="/images/icons/favicon-32x32.png?v=1" sizes="32x32">--}}
    {{--<link rel="icon" type="image/png" href="/images/icons/favicon-96x96.png?v=1" sizes="96x96">--}}
    {{--<link rel="icon" type="image/png" href="/images/icons/favicon-16x16.png?v=1" sizes="16x16">--}}

    {{-- Favicon --}}
    <link href="{{ asset('/img/integrasafe-logo-enchanted.png') }}" sizes="32x32" type="image/png" rel="icon">

    {{-- Sitemap --}}
    <link href="sitemap.xml" title="Sitemap" type="application/xml" rel="sitemap">

    {{-- CSS Styles --}}
    <link href="{{ asset('css/source/main.css') }}" rel="stylesheet">

    {{-- if App_env if "production" call the compressed.css.php file else call the unminified files. --}}
    @if(App::environment() === "production")
        <link href="{{ asset('css/stage/style.min.css') }}" type="text/css" rel="stylesheet">
    @else
        <link href="{{ asset('css/source/materialize.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('css/libraries/material-components-web.min.css') }}" type="text/css"
              rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Playfair+Display:700,900|Fira+Sans:400,400italic'
              rel='stylesheet' type='text/css'>
        <link href="{{ asset('css/source/milestone.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('css/source/integrasafe.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('css/libraries/bootstrap.3.3.7.css') }}" type="text/css" rel="stylesheet">
    @endif

    {{-- Get the App theme --}}
    <link href="{{ asset('css/themes/white.css') }}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    {{-- Javascript files --}}
    <script src="{{ asset('js/libraries/material-components-web.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libraries/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript" async></script>
    <script src="{{ asset('js/newsletter.js') }}" type="text/javascript" async></script>
    <script src="{{ asset('js/materialize.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/milestone.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>

    {{--[if lt IE 9]--}}
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    {{--[endif]--}}

    {{-- Facebook Pixel tracking code --}}
    <script>
		!function (f, b, e, v, n, t, s) {
			if (f.fbq) return;
			n = f.fbq = function () {
				n.callMethod ?
					n.callMethod.apply(n, arguments) : n.queue.push(arguments)
			};
			if (!f._fbq) f._fbq = n;
			n.push = n;
			n.loaded = !0;
			n.version = '2.0';
			n.queue = [];
			t = b.createElement(e);
			t.async = !0;
			t.src = v;
			s = b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t, s)
		}(window, document, 'script',
			'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '1252731021495187');
		fbq('track', 'PageView');
		fbq('track', 'Lead');
		fbq('track', 'ViewContent');
    </script>
    <noscript>
        <img height="1" width="1" src="https://www.facebook.com/tr?id=1252731021495187&ev=PageView&noscript=1"/>
    </noscript>

</head>
