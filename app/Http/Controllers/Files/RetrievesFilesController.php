<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class RetrievesFilesController extends Controller
{
    public function index()
    {
        return view('app.files.retrieve');
    }

    public function store(Request $request)
    {
        // @TODO: Validate it's a file.
        $path = $request->get('path');
        $file = last(explode('/', $path));
        $content = file_get_contents($path);

        $file = File::create(['name' => $file, 'path' => $path]);
        $file->sections()->create(['content' => $content]);

        return redirect(sprintf('/files/%s/sections/edit', $file->id));
    }
}
