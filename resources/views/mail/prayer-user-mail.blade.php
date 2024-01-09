@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header')
            {{-- Your Logo --}}
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="max-width: 160px;">
        @endcomponent
    @endslot

    {{-- Body --}}
    # Dear {{ $recieverName }},

    I hope this message finds you in good spirits. We wanted to reach out and share that {{ $senderName }} is keeping you
    in their prayers at this very moment. Blessings Prayer Bowl Team

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            {{-- Your Footer Content --}}
            <p style="color: #000000d5; font-size: 15px; font-weight: 700;">
                PRAY FOR SOMEONE <br>
                <span style="font-weight: 400; font-size: 13px; line-height: 10px; line-height: 18px; margin-top: 4px;">
                    If you wish to offer prayers for someone special or curate your personalized prayer list, we invite you to download
                our complimentary Prayer Bowl App, available on both Android and Apple platforms. You can find the download link
                below.
                </span>
            </p>
            <p style="color: #000000d5;">
                Android: <a style="color: #0055F2;" href="https://www.youtube.com/">playerstore@prayerbowl.com</a>
                <br>
                IOS: <a style="color: #0055F2;" href="https://www.youtube.com/">applestore@prayerbowl.com</a>
            </p>
            <p style="color: #000000d5;">© 2024 Prayer Bowl. All rights reserved.</p>
        @endcomponent
    @endslot
@endcomponent
