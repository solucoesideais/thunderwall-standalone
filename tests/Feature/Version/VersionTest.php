<?php

namespace Tests\Feature\Version;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Tests\AuthenticatedTestCase;

class VersionTest extends AuthenticatedTestCase
{
    /**
     * @test
     */
    public function a_user_can_see_when_there_is_an_update()
    {
        Config::set('app.version', '0.0.0');
        Cache::put('updateAvailable', '0.0.1', 1);

        $this->get('/home')
            ->assertSeeText('Update')
            ->assertSeeLink('/version');
    }

    /**
     * @test
     */
    public function the_update_button_does_not_show_when_there_is_no_update()
    {
        $this->get('/home')
            ->assertDontSeeText('Update');
    }
}