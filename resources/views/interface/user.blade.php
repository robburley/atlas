

<li class="dropdown user-profile">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="/assets/images/user-4.png" alt="user-image" class="img-circle img-inline userpic-32" width="28" />

        <span>
            {{ auth()->user()->name }}

            <i class="fa fa-fw fa-angle-down"></i>
        </span>
    </a>

    <ul class="dropdown-menu user-profile-menu list-unstyled">
        <li>
            <a href="javascript:;" onclick="jQuery('#faq-create').modal('show', {backdrop: 'fade'});">
                <i class="fa  fa-question-circle"></i>
                Ask a question
            </a>
        </li>

        <li class="last">
            <a href="/logout">
                <i class="fa fa-fw fa-lock"></i> Log out
            </a>
        </li>
    </ul>
</li>
