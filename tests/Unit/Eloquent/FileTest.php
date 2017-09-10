<?php

namespace Tests\Unit;

use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_file_has_a_path()
    {
        $file = create(File::class);

        $this->assertEquals('/files/1', $file->path());
        $this->assertEquals('/files/1/something', $file->path('/something'));
    }
}
