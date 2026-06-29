<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! $seo->renderTags() !!}

    <link rel="icon" href="{{ \App\Helpers\SettingsHelper::get('favicon') ? asset('storage/'.\App\Helpers\SettingsHelper::get('favicon')) : asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Analytics --}}
    @if($integrations['ga_enabled'] && $integrations['ga_id'])
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $integrations['ga_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $integrations['ga_id'] }}');
    </script>
    @endif

    {{-- Meta Pixel --}}
    @if($integrations['pixel_enabled'] && $integrations['pixel_id'])
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $integrations['pixel_id'] }}');
        fbq('track', 'PageView');
    </script>
    @endif

    {{-- Custom head scripts --}}
    @if($integrations['head_scripts'])
        {!! $integrations['head_scripts'] !!}
    @endif
</head>
<body class="bg-white text-brand-dark">

    @include('landing.partials.navbar')

    @yield('content')

    @include('landing.partials.footer')

    {{-- Custom body scripts --}}
    @if($integrations['body_scripts'])
        {!! $integrations['body_scripts'] !!}
    @endif

</body>
</html>
