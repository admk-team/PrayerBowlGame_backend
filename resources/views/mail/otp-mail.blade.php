@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header')
            {{-- Your Logo --}}
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="max-width: 160px;">
        @endcomponent
    @endslot

    {{-- Body --}}
    @component('mail::panel')
        <span style="display: inline-block; margin-bottom: 10px; color: #000;">
            {{ __('Dear') }} {{ $username }}, {{ __('please use the following OTP code to reset your password') }}
        </span>
        <br>
        <div
            style="font-size: 23px; font-weight: 700; color: #4A62B6; border: solid 2px #4A62B6; padding: 10px 15px; display: inline-block; border-radius: 13px; position: relative; left: 50%; transform: translateX(-50%);">
            {{ $code }}
        </div>
    @endcomponent

    @slot('footer')
        @component('mail::footer')
            <p style="color: #000000d5; font-size: 15px; font-weight: 700;">
                <span style="font-weight: 400; font-size: 13px; line-height: 10px; line-height: 18px; margin-top: 4px;">
                    {{ __('© 2024 Prayer Bowl. All rights reserved.') }}
                </span>
            </p>
        @endcomponent
    @endslot
@endcomponent
