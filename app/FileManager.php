<?php

namespace App;

use App\Models\File;

class FileManager
{
    /**
     * @var File
     */
    protected $file;

    /**
     * CommitFile constructor.
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function commit()
    {
        if (!is_file($this->file->path)) {
            touch($this->file->path);
            file_put_contents($this->file->path, $this->file->content());
        }
    }
}