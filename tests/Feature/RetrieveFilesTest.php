<?php

namespace Tests\Feature;

use App\Models\File;
use Tests\AuthenticatedTestCase;

class RetrieveFilesTest extends AuthenticatedTestCase
{
    /**
     * @test
     */
    public function a_user_can_retrieve_a_file_from_the_hard_drive()
    {
        $path = realpath(__DIR__ . '/stub/retrieve.stub');

        $this->post('/files/retrieve', ['path' => $path])
            ->assertFound()
            ->assertRedirect('/files/1/sections/edit');

        $this->assertDatabaseHas('files', ['path' => $path]);
        $this->assertDatabaseHas('sections', ['content' => file_get_contents($path)]);
    }

//    /**
//     * @test
//     * @group f
//     */
//    public function test_file_does_not_exist()
//    {
//        $this->post('/files/retrieve', ['path' => __DIR__ . '/not-a-file'])
//            ->assertFound()
//            ->assertSessionHasErrorsIn();
//    }

    /**
     * @test
     * @group f
     */
    public function a_user_can_see_the_form_for_retrieving_existing_file()
    {
        $this->get('/files/retrieve')
            ->assertSuccessful()
            ->assertSeeInput('path');
    }
}
