<?php

namespace App\Models\Expressive;

use App\Models\File;

class Firewall extends File
{
    use HasParentModel;

    const FILTER = ['path' => '/etc/rc.d/rc.firewall'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('firewall', function ($builder) {
            $builder->where(self::FILTER);
        });
    }
}
