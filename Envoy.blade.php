@servers(['localhost' => '127.0.0.1'])

@task('deploy', ['on' => 'localhost'])

    @if ($tag)
        php artisan down
        git fetch --tags
        git checkout {{ $tag }}
        php artisan migrate
        php artisan up
    @endif

@endtask