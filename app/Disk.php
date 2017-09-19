<?php

namespace App;

use App\Exceptions\PermissionDeniedException;
use App\Models\File;

class Disk
{
    public function write(File $file)
    {
        if (!is_file($file->path)) {
            $this->touch($file->path);
            file_put_contents($file->path, $file->content());
        }
    }

    public function checksum(File $file)
    {
        if (is_file($file->path)) {
            return md5_file($file->path);
        }

        return md5('');
    }

    public function match(File $file)
    {
        return $this->checksum($file) == $file->checksum;
    }

    protected function touch($filepath)
    {
        try {
            $this->makeFoldersForFile($filepath);
            touch($filepath);
        } catch (\ErrorException $e) {
            throw new PermissionDeniedException($filepath);
        }
    }

    protected function makeFoldersForFile($filepath)
    {
        try {
            $directory = dirname($filepath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        } catch (\ErrorException $e) {
            throw new PermissionDeniedException($filepath);
        }
    }
}