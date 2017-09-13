<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\Section;
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

        $this->post($file->route('/sections'), ['sections' => $sections])
            ->assertFound();

        foreach ($sections as $section) {
            $this->assertDatabaseHas('sections', $section + ['file_id' => $file->id]);
        }
    }

    /**
     * @test
     * @group f
     */
    public function a_user_can_see_the_whole_file()
    {
        $file = create(File::class);
        $sections = create(Section::class, ['file_id' => $file->id], 3);

        $response = $this->get($file->route('/sections'))
            ->assertSuccessful()
            ->assertSeeLink($file->route('/sections/edit'));

        foreach ($sections as $section) {
            $response->assertSeeText(e($section->content));
        }
    }
}
