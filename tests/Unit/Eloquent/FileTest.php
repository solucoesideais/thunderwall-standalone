<?php

namespace Tests\Unit;

use App\Models\File;
use App\Models\Section;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DatabaseTestCase;
use Tests\TestCase;

class FileTest extends DatabaseTestCase
{
    /**
     * @var File
     */
    protected $file;

    public function setUp()
    {
        parent::setUp();

        $this->file = create(File::class);
    }

    /**
     * @test
     */
    public function a_file_has_a_path()
    {
        $this->assertEquals("/files/{$this->file->id}", $this->file->route());
        $this->assertEquals("/files/{$this->file->id}/something", $this->file->route('/something'));
    }

    /**
     * @test
     */
    public function a_file_has_content()
    {
        create(Section::class, ['content' => 'section 1', 'file_id' => $this->file->id]);
        create(Section::class, ['content' => 'section 2', 'file_id' => $this->file->id]);

        // @TODO: deal with file separator
        $this->assertEquals(
            'section 1' . File::CONTENT_SEPARATOR . 'section 2',
            $this->file->content()
        );
    }

    /**
     * @test
     */
    public function a_file_has_checksum()
    {
        $file = create(File::class);
        $file->sections()->create(['content' => '12345']);

        $this->assertEquals('827ccb0eea8a706c4c34a16891f84e7b', $file->checksum);
    }
}
