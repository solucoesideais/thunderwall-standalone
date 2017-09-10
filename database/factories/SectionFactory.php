<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Section::class, function (Faker $faker) {
    return [
        'file_id' => factory(\App\Models\File::class),
        'content' => $faker->paragraph
    ];
});
