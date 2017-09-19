@auth
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ __('Files') }} <span class="caret"></span>
        </a>

        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="/modules/firewall/edit">{{ __('Firewall') }}</a>
            </li>
        </ul>
    </li>
@endauth