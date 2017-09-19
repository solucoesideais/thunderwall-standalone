<?php

namespace Tests\Fake;

use App\Disk;

class FakeDisk extends Disk
{
    protected function touch($filepath)
    {
        // Remove the trailing '/'
        $filepath = ltrim($filepath, '/');

        // Store the file in local storage/tests folder
        $filepath = storage_path("tests/$filepath");

        parent::touch($filepath);
    }
}