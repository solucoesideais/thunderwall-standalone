<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Models\File;
use Facades\App\Disk;
use Illuminate\Http\Request;

class CommitsFileController extends Controller
{
    public function commit(File $file)
    {
        Disk::write($file);

        return redirect('/files')->with('success', __('File successfully written!'));
    }
}
