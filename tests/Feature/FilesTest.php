<?php

namespace Tests\Feature;

use App\Models\File;
use Tests\AuthenticatedTestCase;

class FilesTest extends AuthenticatedTestCase
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
            ->assertSeeText($file->path)
            ->assertSeeLink($file->route('/sections'));
    }

    /**
     * @test
     */
    public function a_user_can_see_the_files_form()
    {
        $this->get('/files/create')
            ->assertSuccessful()
            ->assertSeeInput('name')
            ->assertSeeInput('path');
    }

    /**
     * @test
     */
    public function a_user_can_create_a_file()
    {
        $file = make(File::class);

        $this->post('/files', $file->toArray())
            ->assertFound()
            ->assertRedirect('/files/1/sections/create');

        $this->assertDatabaseHas('files', $file->toArray());
    }
}
