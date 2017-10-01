<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\File::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'path' => storage_path('files/') . $faker->unique()->word,
        'process' => $faker->sentence
    ];
});
