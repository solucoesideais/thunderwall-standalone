<?php

namespace Tests\Fake;

use App\Disk;
use App\Models\File;
use PHPUnit\Framework\Assert as PHPUnit;

class DiskFake extends Disk
{
    /**
     * @var array
     */
    protected $files = [];

    public function write(File $file)
    {
        $this->files[] = $file;
    }

    public function assertFileCreated($path, $content = null)
    {
        PHPUnit::assertInstanceOf(
            File::class,
            $this->searchFile($path, $content),
            "Expected file on [$path] was not created"
        );
    }

    /**
     * @param $path
     * @param $content
     * @return mixed
     */
    private function searchFile($path, $content)
    {
        return collect($this->files)->first(function ($file) use ($path, $content) {
            if (is_null($content)) {
                return $file->path == $path;
            }

            return $file->path == $path && $file->content == $content;
        });
    }
}