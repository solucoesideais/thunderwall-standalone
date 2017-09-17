@auth
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ __('Files') }} <span class="caret"></span>
        </a>

        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="/files">{{ __('List') }}</a>
            </li>
            <li>
                <a href="/files/create">{{ __('New') }}</a>
            </li>
            <li>
                <a href="/files/retrieve">{{ __('Retrieve from Disk') }}</a>
            </li>
        </ul>
    </li>
@endauth