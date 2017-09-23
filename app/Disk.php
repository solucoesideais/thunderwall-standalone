<?php

namespace App;

use App\Exceptions\PermissionDeniedException;
use App\Models\File;
use ErrorException;

class Disk
{
    /**
     * Check whether a file can be written in the Disk.
     *
     * @param File $file
     * @return bool
     */
    public function writable(File $file)
    {
        return $this->isWritable($file->path);
    }

    /**
     * Write a file into Disk. Creates if it doesn't exist.
     *
     * @param File $file
     */
    public function write(File $file)
    {
        if (! $this->fileExists($file->path)) {
            $this->touch($file->path);
        }

        $this->put($file->path, $file->content);
    }

    /**
     * Check if the content in the database match the content in the Disk file.
     *
     * @param File $file
     * @return bool
     */
    public function match(File $file)
    {
        return $this->hash($file->path) == $file->checksum;
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
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        } catch (ErrorException $e) {
            throw new PermissionDeniedException($filepath);
        }
    }

    /**
     * Return true if the file or directory exists.
     *
     * @param $path
     * @return bool
     */
    protected function fileExists($path)
    {
        return file_exists($path);
    }

    protected function hash($path)
    {
        if ($this->fileExists($path)) {
            return md5_file($path);
        }

        return md5('');
    }

    protected function isDirectory($path)
    {
        return is_dir($path);
    }

    /**
     * Check if a path is writable.
     *
     * @param string $path
     * @return bool
     */
    protected function isWritable($path)
    {
        // If the file or directory exists, we can just check if it's writable.
        if ($this->fileExists($path)) {
            return is_writable($path);
        }

        // Since it doesn't exist, let's check if we have permission in the parent directory
        $directory = dirname($path);

        return $this->isWritable($directory);
    }
}