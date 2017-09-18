<?php

namespace Tests\Feature;

use Tests\AuthenticatedTestCase;

class FirewallTest extends AuthenticatedTestCase
{
    /**
     * @test
     * @group f
     */
    public function a_user_can_see_the_firewall_form()
    {
        $this->get('/module/firewall/edit')
            ->assertSuccessful()
            ->assertSeeInput('firewall');
    }
}
