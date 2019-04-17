@component('vendor.mail.html.message')
    @slot('header')
        @component('mail::header', ['url' => 'https://winwincr.co.uk'])
            Win Win Management
        @endcomponent
    @endslot

    <div class="div">
        <p>For the attention of {{ $supplier->name }}</p>

        <p>Please complete the tender request for hardware required by Win Win Management for the coming week.</p>

        <p>This tender will expire on {{ $invitation->tender->expires_at->format('d/m/Y H:i') }}.</p>

        @component('vendor.mail.html.button', ['url' => $invitation->link()])
            Tender
        @endcomponent

        <p>Kind regards</p>

        <p>
            <strong>
                Win Win Management
            </strong>
        </p>

        <img src="https://atlas.winwincr.co.uk/images/winwin-logo.png">

        <p>
            T: 01270 440140 | F: 08448 010760<br>
            <a href="www.winwincr.co.uk">www.winwincr.co.uk</a>
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