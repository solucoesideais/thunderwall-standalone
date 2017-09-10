<?php

namespace Tests\Feature;

use App\Models\File;
use Tests\AuthenticatedTestCase;

class SectionsTest extends AuthenticatedTestCase
{
    /**
     * @test
     */
    public function a_user_can_create_multiple_sections_in_a_file()
    {
        $file = create(File::class);
        $sections = [
            ['content' => 'first section'],
            ['content' => 'second section'],
            ['content' => 'third section']
        ];

        $this->post($file->path('/sections'), ['sections' => $sections])
            ->assertFound();

        foreach ($sections as $section) {
            $this->assertDatabaseHas('sections', $section + ['file_id' => $file->id]);
        }
    }
}
