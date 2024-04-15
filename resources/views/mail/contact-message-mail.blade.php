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
        <h1 style="text-align: center">Contact Message</h1>
        <table>
            <tr>
                <td style="vertical-align: baseline; min-width: 90px;"><strong>First Name:</strong></td>
                <td>{{ $contactMessage->first_name }}</td>
            </tr>
            <tr>
                <td style="vertical-align: baseline; min-width: 90px;"><strong>Last Name:</strong></td>
                <td>{{ $contactMessage->last_name }}</td>
            </tr>
            <tr>
                <td style="vertical-align: baseline; min-width: 90px;"><strong>Email:</strong></td>
                <td>{{ $contactMessage->email }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="vertical-align: baseline;"><strong>Message:</strong></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">{{ $contactMessage->message }}</td>
            </tr>
        </table>
    @endcomponent

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            {{-- Your Footer Content --}}
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
