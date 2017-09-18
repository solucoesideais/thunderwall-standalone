<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirewallRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $file = \App\Models\File::create([
            'name' => 'Firewall Settings',
            'path' => \App\Models\Expressive\Firewall::FILTER['path']
        ]);

        $file->sections()->create(['content' => '# Your firewall settings.']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
