@component('vendor.mail.html.message')
    @slot('header')
        @component('mail::header', ['url' => 'https://winwincr.co.uk'])
            Win Win Management
        @endcomponent
    @endslot

    <div class="div">
        <p>For the attention of {{ $contact->full_name }}</p>

        <p>Please see attached for your Win Win mobile proposal.</p>

        <p>If you are happy to proceed, please reply to this email and we will get the ball rolling.</p>

        <p>{{ $message }}</p>

        <p>Kind regards</p>

        <p>
            <strong>
                {{ $user->name }}<br>
                Win Win Management
            </strong>
        </p>

        <img src="https://atlas.winwincr.co.uk/images/winwin-logo.png">

        <p>
            T: 01270 440140 | F: 08448 010760<br>
            E: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a> | <a href="www.winwincr.co.uk">www.winwincr.co.uk</a>
        </p>

        <p>Oak Bank Business Centre, Mickley Hall Lane, Broomhall, Nantwich, Cheshire, CW5 8AH</p>

        <p>
            <small>
                This message and any attachments to it are private and confidential. It may contain information which is
                privileged and confidential within the meaning of applicable law. If you have received this message in
                error, and/or are not the intended recipient of this email message, you must neither take any action
                based upon its contents, nor copy or show it to anyone. Please contact the sender and remove it from
                your system as soon as possible. Any views or opinions expressed in this email are solely those of the
                author and do not necessarily represent those of Win Win Management (UK) Ltd or any of its associated
                companies. Win Win Management (UK) Ltd may monitor email traffic data and the content of the email for
                the purposes of security and staff training in line with the Telecommunications (Lawful Business
                Practice) Regulations 2000. <br> “Win Win” and “Win Win Management” are trading styles of Win Win
                Management (UK) Ltd, a company registered in England and Wales. Registered number: 09162798. Registered
                address: Oak Bank Business Centre, Mickley Hall Lane, Broomhall, Nantwich, Cheshire, CW5 8AH.
            </small>
        </p>
    </div>


    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} Win Win Management. All rights reserved.
        @endcomponent
    @endslot

@endcomponent