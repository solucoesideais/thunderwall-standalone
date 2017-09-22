<?php

namespace Tests\Feature\Version;

use Facades\App\Process;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Tests\AuthenticatedTestCase;

class VersionTest extends AuthenticatedTestCase
{
    /**
     * @test
     */
    public function the_update_button_does_not_show_when_there_is_no_update()
    {
        $this->get('/home')
            ->assertDontSeeText('Update');
    }

    /**
     * @test
     */
    public function a_user_can_see_when_there_is_an_update()
    {
        Cache::put('updateAvailable', true, 1);

        $this->get('/home')
            ->assertSeeText('Update')
            ->assertSeeLink('/version');
    }

    /**
     * @test
     */
    public function test_auto_deploy()
    {
        Cache::put('updateAvailable', true, 1);

        $this->post('/version')
            ->assertFound();

        Process::assertExecuted(base_path('/vendor/bin/envoy') . ' run deploy');
        $this->assertEmpty(Cache::get('updateAvailable'));
    }

    /**
     * @test
     */
    public function the_update_page_shows_updated_message()
    {
        $this->get('/version')
            ->assertSuccessful()
            ->assertSeeText('Your application is up to date!');
    }
}