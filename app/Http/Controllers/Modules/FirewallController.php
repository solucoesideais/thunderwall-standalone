<?php

namespace App\Http\Controllers\Modules;

use App\Jobs\ProcessFile;
use Facades\App\Process;
use Facades\App\Disk;
use App\Http\Controllers\Controller;
use App\Models\Expressive\Firewall;
use Illuminate\Http\Request;

class FirewallController extends Controller
{
    public function edit()
    {
        $file = Firewall::first();

        return view('app.modules.firewall.edit', compact('file'));
    }

    public function update(Request $request, Firewall $firewall)
    {
        $firewall->sections()->first()->update([
            'content' => $request->get('firewall')
        ]);

        // @TODO: should this be an event on File instead? Write every file as soon as they change.
        Disk::write($firewall);

        dispatch(new ProcessFile($firewall));

        return redirect('/module/firewalls/edit')->with('success', __('Your changes will be applied in a few seconds'));
    }
}