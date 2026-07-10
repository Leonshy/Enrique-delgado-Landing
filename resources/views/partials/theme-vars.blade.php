@if($googleFontsHref = \App\Helpers\FontHelper::googleFontsHref())
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="{{ $googleFontsHref }}" rel="stylesheet">
@endif

<style>
    @foreach(['heading', 'body'] as $slot)
    @php($customFont = \App\Helpers\FontHelper::customFont($slot))
    @if($customFont)
    @font-face {
        font-family: '{{ $customFont['family'] }}';
        src: url('{{ asset('storage/'.$customFont['path']) }}') format('{{ $customFont['format'] }}');
        font-weight: 100 900;
        font-style: normal;
        font-display: swap;
    }
    @endif
    @endforeach

    :root {
        @foreach(\App\Helpers\ThemeHelper::resolvedColors() as $var => $value)
        {{ $var }}: {{ $value }};
        @endforeach
        @foreach(\App\Helpers\FontHelper::cssVars() as $var => $value)
        {{ $var }}: {!! $value !!};
        @endforeach
    }
    html {
        font-size: {{ \App\Helpers\FontHelper::rootFontSize() }};
    }
</style>
