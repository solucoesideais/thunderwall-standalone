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

    protected function touch($path)
    {
        try {
            touch($path);
        } catch (\ErrorException $e) {
            throw new PermissionDeniedException($path);
        }
    }
}