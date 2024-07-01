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
    @component('mail::layout')
        # {{__('Dear') }} {{ $recieverName }},
<p style="font-size: 15px;">
{{ __('I hope this message finds you in good spirits. We wanted to reach out and share that') }} {{ __('is keeping you in their prayers at this very moment.', ['senderName' => $senderName]) }}
</p>


{{ __('Blessings') }},
<br>
{{ __('Prayer Bowl Team') }}
<hr style="border-color: rgb(0 0 0 / 8%) !important;">
{{-- Display Content --}}
@if ($content)
<p style="font-size: 15px;">{{ $content }}</p>
@endif
{{-- Display Banner --}}
@if ($banner)

<a href="{{$bannerUrl}}" target="_blank">
<img src="{{ asset('admin_assets/banner_ad/' . $banner) }}" alt="Banner">
</a>

@endif
    @endcomponent

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            {{-- Your Footer Content --}}
            <p style="color: #000000d5; font-size: 15px; font-weight: 700;">
                {{ __('PRAY FOR SOMEONE') }} <br>
                @if ($message != '')
                    <span style="font-weight: 400; font-size: 13px; line-height: 10px; line-height: 18px; margin-top: 4px;">
                        {{ $message }}
                    </span>
                @endif
            </p>
            @if ($iosLink != '')
                <a href="{{ $iosLink }}" style="text-decoration: none;">
                    <img src="{{ asset('images/applestore.png') }}" alt="playstore" style="max-width: 146px;">
                </a>
            @endif
            @if ($androidLink != '')
                <a href="{{ $androidLink }}" style="text-decoration: none;">
                    <img src="{{ asset('images/playstore.png') }}" alt="playstore" style="max-width: 160px;">
                </a>
            @endif
        @endcomponent
    @endslot
@endcomponent
