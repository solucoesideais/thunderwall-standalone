<?php

namespace App;

use App\Exceptions\PermissionDeniedException;
use App\Models\File;
use ErrorException;

class Disk
{
    /**
     * Write a file into Disk. Creates if it doesn't exist.
     *
     * @param File $file
     */
    public function write(File $file)
    {
        if (!is_file($file->path)) {
            $this->touch($file->path);
        }

        $this->put($file->path, $file->content());
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
            $this->recursiveMakeDirectory($filepath);
            touch($filepath);
        } catch (ErrorException $e) {
            throw new PermissionDeniedException($filepath);
        }
    }

    /**
     * Put the content into the file.
     *
     * @param $path
     * @param $content
     */
    protected function put($path, $content)
    {
        file_put_contents($path, $content);
    }

    /**
     * Create directories recursively for a given file.
     *
     * @param $filepath
     */
    protected function recursiveMakeDirectory($filepath)
    {
        try {
            $directory = dirname($filepath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        } catch (ErrorException $e) {
            throw new PermissionDeniedException($filepath);
        }
    }
}