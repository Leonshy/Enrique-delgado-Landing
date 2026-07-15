@props(['btn'])
<a href="{{ $btn['href'] }}"
   @if($btn['target'] === '_blank') target="_blank" rel="noopener" @endif
   {{ $attributes->class(['cta-btn-whatsapp' => $btn['whatsapp_style'] ?? false]) }}>{!! $btn['icon_svg'] !!}{{ $btn['label'] }}</a>
