<?php

namespace App;

use App\Models\File;

class Disk
{
    public function write(File $file)
    {
        if (!is_file($file->path)) {
            touch($file->path);
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
}