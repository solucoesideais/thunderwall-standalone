<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 */
class File extends Model
{
    protected $fillable = ['name', 'path'];

    public function path($path = null)
    {
        return sprintf('/files/%s%s', $this->id, $path);
    }
}
