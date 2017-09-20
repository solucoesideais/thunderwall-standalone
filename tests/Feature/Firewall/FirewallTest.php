<?php

namespace Tests\Feature;

use App\Models\Expressive\Firewall;
use Facades\App\Process;
use Tests\AuthenticatedTestCase;

class FirewallTest extends AuthenticatedTestCase
{
    /**
     * @test
     */
    public function a_user_can_see_the_firewall_form()
    {
        $this->get('/modules/firewall/edit')
            ->assertSuccessful()
            ->assertSeeInput('firewall');
    }

    /**
     * @test
     */
    public function a_user_can_change_the_firewall_settings()
    {
        $file = Firewall::first();
        $content = 'Firewall settings changed.';

        $this->put('/modules/firewall/' . $file->id, ['firewall' => $content])
            ->assertFound()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('sections', ['file_id' => $file->id, 'content' => $content]);
        Process::assertExecuted('/etc/rc.d/rc.firewall');
    }
}
