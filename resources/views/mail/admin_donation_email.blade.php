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
        # Dear {{$data->name}},
<p style="font-size: 15px;">
We wanted to inform you that a donation has been made to Prayer Bowl. {{$doner_data->supporter_name ? $doner_data->supporter_name : 'Someone' }} has generously contributed ${{$amount}} on {{ now()->toFormattedDateString() }}.
</p>


Blessings,
<br>
Prayer Bowl Team
<hr style="border-color: rgb(0 0 0 / 8%) !important;">

    @endcomponent

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            {{-- Your Footer Content --}}
            <p style="color: #000000d5; font-size: 15px; font-weight: 700;">
                PRAY FOR SOMEONE <br>
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
