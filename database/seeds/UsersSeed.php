<?php

use Illuminate\Database\Seeder;

class UsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // @TODO: maybe add username and use it instead of email during login.
        \App\Models\User::insert([
            ['name' => 'Admin', 'email' => 'admin@thunderwall.com', 'password' => bcrypt('admin')]
        ]);
    }
}
