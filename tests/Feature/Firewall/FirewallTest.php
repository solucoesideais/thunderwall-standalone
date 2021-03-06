<?php

namespace Tests\Feature;

use App\Jobs\ProcessFile;
use App\Models\Expressive\Firewall;
use App\Models\File;
use Facades\App\Disk;
use Facades\App\Process;
use Illuminate\Support\Facades\Queue;
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

        Disk::assertFileCreated('/etc/rc.d/rc.firewall');

        Queue::assertPushed(ProcessFile::class);
    }

    /**
     * @test
     */
    public function a_user_can_see_when_firewall_file_is_not_writable()
    {
        Disk::swap(new class extends \App\Disk
        {
            public function isWritable($path)
            {
                return false;
            }
        });

        $this->get('/modules/firewall/edit')
            ->assertSeeText('Permission denied to file');
    }
}
