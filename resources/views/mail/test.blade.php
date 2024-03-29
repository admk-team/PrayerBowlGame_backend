@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header')
            {{-- Your Logo --}}
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="max-width: 160px;">
        @endcomponent
    @endslot

    {{-- Body --}}
    # Dear [Recipient's Name],

    I hope this message finds you in good spirits. We wanted to reach out and share that [Name] is keeping you in their prayers at this very moment. Blessings Prayer Bowl Team

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            {{-- Your Footer Content --}}
            <p style="color: #000000d5;">
                If you wish to offer prayers for someone special or curate your personalized prayer list, we invite you to download our complimentary Prayer Bowl App, available on both Android and Apple platforms. You can find the download link below.
            </p>
        @endcomponent
    @endslot
@endcomponent
