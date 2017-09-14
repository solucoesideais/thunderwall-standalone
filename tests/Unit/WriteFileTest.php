<?php

namespace Tests\Integration;

use Facades\App\Disk;
use App\Models\File;
use Tests\DatabaseTestCase;

class WriteFileTest extends DatabaseTestCase
{
    /**
     * @test
     */
    public function writing_a_file_will_create_it()
    {
        $path = __DIR__ . '/new-file';
        $this->assertFileNotExists($path);

        $file = File::create(['name' => 'Commit', 'path' => $path]);
        $file->sections()->create(['content' => 'file content']);

        Disk::write($file);

        $this->assertFileExists($file->path);
        $this->assertEquals($file->content(), file_get_contents($file->path));
        unlink($path);
    }
}