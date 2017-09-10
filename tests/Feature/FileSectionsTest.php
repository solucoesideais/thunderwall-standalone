<?php

namespace Tests\Feature;

use App\Models\File;
use Tests\AuthenticatedTestCase;

class FileSectionsTest extends AuthenticatedTestCase
{
    /**
     * @test
     */
    public function a_user_can_list_files()
    {
        $file = create(File::class);

        $this->get('/files')
            ->assertSuccessful()
            ->assertSeeText(e($file->name))
            ->assertSee($file->path('/sections'));
    }

    /**
     * @test
     */
    public function a_user_can_create_a_file()
    {
        $file = make(File::class);

        $this->post('/files', $file->toArray())
            ->assertFound()
            ->assertRedirect('/files/1/sections');

        $this->assertDatabaseHas('files', $file->toArray());
    }
}
