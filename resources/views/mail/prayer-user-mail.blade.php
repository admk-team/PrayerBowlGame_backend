@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header')
            {{-- Your Logo --}}
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="max-width: 160px;">
            {{-- <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="max-width: 160px;"> --}}
        @endcomponent
    @endslot

    {{-- Body --}}
    # Dear {{ $recieverName }},

    I hope this message finds you in good spirits. We wanted to reach out and share that {{ $senderName }} is keeping you
    in their prayers at this very moment.

    Blessings,
    Prayer Bowl Team

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            {{-- Your Footer Content --}}
            <p style="color: #000000d5; font-size: 15px; font-weight: 700;">
                PRAY FOR SOMEONE <br>
                <span style="font-weight: 400; font-size: 13px; line-height: 10px; line-height: 18px; margin-top: 4px;">
                    {{ $message }}
                </span>
            </p>
            <a href="{{ $iosLink }}">
                <img src="{{ asset('images/applestore.png') }}" alt="playstore" style="max-width: 146px;">
            </a>
            <a href="{{ $androidLink }}">
                <img src="{{ asset('images/playstore.png') }}" alt="playstore" style="max-width: 160px;">
            </a>
        @endcomponent
    @endslot
@endcomponent
