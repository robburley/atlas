@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        {{ $header }}
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        {{ $footer }}
    @endslot
@endcomponent
