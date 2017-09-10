<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property Collection sections
 */
class File extends Model
{
    protected $fillable = ['name', 'path'];

    public function path($path = null)
    {
        return sprintf('/files/%s%s', $this->id, $path);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
