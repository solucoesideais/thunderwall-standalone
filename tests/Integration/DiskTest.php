<?php

namespace Tests\Integration;

use App\Models\File;
use Facades\App\Disk;
use Tests\DatabaseTestCase;

class DiskTest extends DatabaseTestCase
{
    /**
     * @var string
     */
    protected $path;

    protected function setUp()
    {
        parent::setUp();

        $this->path = base_path('tests/Integration/file');

        Disk::swap(new \App\Disk);
    }

    /**
     * @test
     */
    public function file_is_writable()
    {
        $file = $this->createFileRecord($this->path, 'content');

        $this->assertTrue(Disk::writable($file));
    }

    /**
     * This test creates a file and leave it in the disk.
     *
     * @test
     */
    public function create_new_file()
    {
        @unlink($this->path);

        $file = $this->createFileRecord($this->path, 'my file.');

        Disk::write($file);

        $this->assertFileExists($this->path, "Failed to create file at [$this->path]");

        $this->assertTrue(Disk::match($file), "Failed to assert [$file->path] contains [$file->content]");
    }

    /**
     * This test uses the file created by the previous test to modify it and then remove it.
     *
     * @test
     * @depends create_new_file
     */
    public function change_existing_file()
    {
        $this->assertFileExists($this->path, "Missing pre-arranged file at [$this->path]");

        $file = $this->createFileRecord($this->path, 'this file has been changed.');

        Disk::write($file);

        $this->assertFileExists($this->path);

        $this->assertTrue(Disk::match($file));

        @unlink($this->path);
    }

    /**
     * @param $path
     * @param $content
     * @return File
     */
    protected function createFileRecord($path, $content)
    {
        $file = create(File::class, ['path' => $path]);

        $file->sections()->create(['content' => $content]);

        return $file;
    }
}