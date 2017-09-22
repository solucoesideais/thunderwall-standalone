<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class RedirectsTest extends DatabaseTestCase
{
    /**
     * @test
     */
    public function unauthenticated_users_get_redirected_to_login_page()
    {
        $this->get('/files')
            ->assertFound()
            ->assertRedirect('/login');

        $this->get('/anything')
            ->assertFound()
            ->assertRedirect('/login');

    }

    /**
     * @test
     */
    public function authenticated_users_get_redirected_to_home_page()
    {
        $this->signIn()
            ->get('/login')
            ->assertRedirect('/home');

        $this->get('/anything')
            ->assertFound()
            ->assertRedirect('/home');
    }
}
