<?php

namespace App\Http\Controllers;

use App\Support\GitHub;
use Facades\App\Process;
use Illuminate\Support\Facades\Cache;

class VersionController extends Controller
{
    public function index(GitHub $gitHub)
    {
        $release = $gitHub->latestRelease();

        if ($release['tag_name'] == config('app.version')) {
            Cache::forget('updateAvailable');
        }

        return view('app.version.index', compact('release'));
    }

    public function update()
    {
        Cache::forget('updateAvailable');

        $output = Process::deploy();

        return redirect('/version')->with('output', $output);
    }

}
