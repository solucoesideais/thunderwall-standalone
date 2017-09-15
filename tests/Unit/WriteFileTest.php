<?php

namespace Tests\Unit;

use App\Exceptions\PermissionDeniedException;
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

    /**
     * @test
     */
    public function writing_a_file_without_permission_will_throw_exception()
    {
        Disk::swap(new DiskWithoutPermission());

        $this->expectException(PermissionDeniedException::class);

        $file = create(File::class);
        Disk::write($file);
    }
}

class DiskWithoutPermission extends \App\Disk
{
    protected function touch($path)
    {
        throw new PermissionDeniedException($path);
    }
}