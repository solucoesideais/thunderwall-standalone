<?php

namespace App\Http\Controllers;

use App\Support\GitHub;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Process;

class VersionController extends Controller
{
    public function index(GitHub $gitHub)
    {
        $release = $gitHub->latestRelease();

        return view('app.version.index', compact('release'));
    }

    public function update()
    {
        $version = '0.0.1';
        $envoy = sprintf(' run deploy --version=%s', $version);
        $command = base_path('/vendor/bin/envoy') . $envoy;

        $status = (new Process($command))->run();

        Cache::forget('updateAvailable');

        if ($status == 0) {
            return redirect('/version')->with('success', __('Application successfully updated!'));
        }

        return redirect('/version')->withErrors(['error' => __('Update failed')]);
    }
}
