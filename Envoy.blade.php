@servers(['localhost' => '127.0.0.1'])

@task('deploy', ['on' => 'localhost'])

    @if ($tag)
        php artisan down
        git pull
        composer install --no-dev --no-interaction
        php artisan migrate
        php artisan up
    @endif

@endtask