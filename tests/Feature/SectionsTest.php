<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\Section;
use Tests\AuthenticatedTestCase;

class SectionsTest extends AuthenticatedTestCase
{

    /**
     * @var File
     */
    protected $file;

    protected function setUp()
    {
        parent::setUp();

        $this->file = create(File::class);
    }

    /**
     * @test
     */
    public function a_user_can_create_multiple_sections_in_a_file()
    {
        $sections = [
            ['content' => 'first section'],
            ['content' => 'second section'],
            ['content' => 'third section']
        ];

        $this->post($this->file->route('/sections'), ['sections' => $sections])
            ->assertFound();

        foreach ($sections as $section) {
            $this->assertDatabaseHas('sections', $section + ['file_id' => $this->file->id]);
        }
    }

    /**
     * @test
     */
    public function a_user_can_see_the_whole_file()
    {

        $sections = create(Section::class, ['file_id' => $this->file->id], 3);

        $response = $this->get($this->file->route('/sections'))
            ->assertSuccessful()
            ->assertSeeLink($this->file->route('/sections/edit'));

        foreach ($sections as $section) {
            $response->assertSeeText(e($section->content));
        }
    }

    /**
     * @test
     */
    public function show_notice_when_file_is_empty()
    {
        $this->get($this->file->route('/sections'))
            ->assertSuccessful()
            ->assertSeeText('It appears this file is still empty');
    }

    /**
     * @test
     */
    public function a_user_can_see_the_section_editor()
    {
        $section = create(Section::class, ['file_id' => $this->file->id]);

        $this->get($this->file->route('/sections/edit'))
            ->assertSuccessful()
            ->assertSeeText($section->content)
            ->assertSeeInput('sections[0][content]')
            ->assertSeeInput('sections[1][content]');
    }
}
