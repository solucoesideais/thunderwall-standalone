<?php

namespace Tests\Integration;

use Facades\App\Disk;
use App\Models\File;
use Tests\DatabaseTestCase;

class IntegrityFileTest extends DatabaseTestCase
{
    /**
     * @test
     */
    public function test_file_checksum()
    {
        $file = create(File::class);
        $file->sections()->create(['content' => '12345']);

        $this->assertEquals('827ccb0eea8a706c4c34a16891f84e7b', $file->checksum);
    }

    /**
     * @test
     */
    public function test_disk_file_checksum()
    {
        $file = create(File::class, ['path' => __DIR__ . '/stub/integrity']);

        $this->assertEquals('827ccb0eea8a706c4c34a16891f84e7b', Disk::checksum($file));
    }

    /**
     * @test
     */
    public function test_file_matches_disk_content()
    {
        $file = create(File::class, ['path' => __DIR__ . '/stub/integrity']);
        $file->sections()->create(['content' => '12345']);

        $this->assertTrue(Disk::match($file));
    }
}