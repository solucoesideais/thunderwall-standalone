<?php

namespace Tests\Unit;

use App\Models\File;
use App\Models\Section;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

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
        $this->assertEquals('/files/1', $this->file->path());
        $this->assertEquals('/files/1/something', $this->file->path('/something'));
    }

    /**
     * @test
     */
    public function a_file_has_many_sections()
    {
        create(Section::class, ['file_id' => $this->file->id]);

        $this->assertInstanceOf(Collection::class, $this->file->sections);
        $this->assertInstanceOf(Section::class, $this->file->sections->first());
    }
}
