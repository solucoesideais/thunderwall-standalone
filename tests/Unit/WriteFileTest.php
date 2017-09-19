<?php

namespace Tests\Unit;

use App\Disk;
use Facades\App\Disk as DiskFacade;
use App\Exceptions\PermissionDeniedException;
use App\Models\File;
use Tests\DatabaseTestCase;

class WriteFileTest extends DatabaseTestCase
{
    /**
     * @test
     * @TODO: refactor
     */
    public function writing_a_file_will_create_it()
    {
        // Go back to original Disk implementation.
        DiskFacade::swap(new Disk);

        $path = __DIR__ . '/new-file';
        $this->assertFileNotExists($path);

        $file = File::create(['name' => 'Commit', 'path' => $path]);
        $file->sections()->create(['content' => 'file content']);

        DiskFacade::write($file);

        $this->assertFileExists($file->path);
        $this->assertEquals($file->content(), file_get_contents($file->path));
        unlink($path);
    }

    /**
     * @test
     */
    public function writing_a_file_without_permission_will_throw_exception()
    {
        DiskFacade::swap(new DiskWithoutPermission());

        $this->expectException(PermissionDeniedException::class);

        $file = create(File::class);
        DiskFacade::write($file);
    }
}

class DiskWithoutPermission extends Disk
{
    protected function touch($filepath)
    {
        throw new PermissionDeniedException($filepath);
    }
}