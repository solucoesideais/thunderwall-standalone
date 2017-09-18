<?php

namespace App\Http\Controllers;

use App\Support\GitHub;

class VersionController extends Controller
{
    public function index(GitHub $gitHub)
    {
        $release = $gitHub->latestRelease();

        return view('app.version.index', compact('release'));
    }

    public function update()
    {

    }
}
