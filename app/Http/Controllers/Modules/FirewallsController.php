<?php

namespace App\Http\Controllers\Modules;

use Facades\App\Disk;
use App\Http\Controllers\Controller;
use App\Models\Expressive\Firewall;
use Illuminate\Http\Request;

class FirewallsController extends Controller
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

        return redirect('/module/firewalls/edit')->with('success', 'Your firewall settings has been updated!');
    }
}