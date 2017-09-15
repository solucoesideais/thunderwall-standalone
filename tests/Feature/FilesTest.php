<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\Section;
use Facades\App\Disk;
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
            ->assertRedirect('/files/1/sections');

        $this->assertDatabaseHas('files', $file->toArray());
    }

    /**
     * @test
     */
    public function a_user_can_commit_a_file()
    {
        $path = __DIR__ . '/my-file';
        $file = create(File::class, ['path' => $path]);
        create(Section::class, ['content' => 'my file content', 'file_id' => $file->id]);

        $this->post('/files/1/commit')
            ->assertFound()
            ->assertSessionHas('success', 'File successfully written!');

        $this->assertFileExists($path);
        Disk::match($file);
        @unlink($file->path);
    }
}
