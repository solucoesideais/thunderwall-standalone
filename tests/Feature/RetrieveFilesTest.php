<?php

namespace Tests\Feature;

use App\Models\File;
use Tests\AuthenticatedTestCase;

class RetrieveFilesTest extends AuthenticatedTestCase
{
    /**
     * @test
     * @group f
     */
    public function a_user_can_list_files()
    {
        $path = realpath(__DIR__ . '/stub/retrieve.stub');

        $this->post('/files/retrieve', ['path' => $path])
            ->assertFound()
            ->assertRedirect('/files/1/sections/edit');

        $this->assertDatabaseHas('files', ['path' => $path]);
        $this->assertDatabaseHas('sections', ['content' => file_get_contents($path)]);
    }
}
