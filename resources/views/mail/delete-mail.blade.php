@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header')
            {{-- Your Logo --}}
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="max-width: 160px;">
        @endcomponent
    @endslot

    {{-- Panel Content --}}
    @slot('subcopy')
        {{ __('Dear') }} {{ $data['name'] }},

        {{ __('We have received your request to delete your account. If you initiated this request, please proceed by clicking
        the button below:') }}

        @component('mail::button', ['url' => $deleteAccountUrl])
            {{ __('Confirm Account Deletion') }}
        @endcomponent
    @endslot

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            {{-- Your Footer Content --}}
        @endcomponent
    @endslot
@endcomponent
