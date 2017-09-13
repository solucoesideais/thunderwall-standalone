<?php

namespace Tests\Integration;

use App\FileManager;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommitFileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function committing_a_file_will_create_it()
    {
        $path = __DIR__ . '/committed';
        $this->assertFileNotExists($path);

        $file = File::create(['name' => 'Commit', 'path' => $path]);
        $file->sections()->create(['content' => 'file content']);

        (new FileManager($file))->commit();

        $this->assertFileExists($file->path);
        $this->assertEquals($file->content(), file_get_contents($file->path));
        unlink($path);
    }
}