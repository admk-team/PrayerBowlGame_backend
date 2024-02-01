@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    <p>Thank you, {{ $donation->name_on_card }}, for your generous donation of {{ $donation->donation_amount }} USD.</p>

    {{-- Thank You Message for Donor --}}
    @component('mail::subcopy')
        @if ($donation->email)
            You will receive an email confirmation shortly. Thank you for your support!
        @else
            We were unable to send you a confirmation email. Please contact us for further assistance.
        @endif
    @endcomponent

    {{-- Dear Super Admin Message --}}
    @component('mail::subcopy')
        <p>Dear Super Admin,</p>
        <p>A new donation has been received. Details:</p>
        <ul>
            <li>Name: {{ $donation->name_on_card }}</li>
            <li>Amount: {{ $donation->donation_amount }}</li>
            <li>Country: {{ $donation->country }}</li>
            <li>Donation Type: {{ $donation->donation_type }}</li>
            <li>Card Expiry Date: {{ $donation->expiry_date }}</li>
        </ul>
    @endcomponent

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
