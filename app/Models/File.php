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
    const CONTENT_SEPARATOR = PHP_EOL . PHP_EOL;

    protected $fillable = ['name', 'path'];

    public function route($subroute = null)
    {
        return sprintf('/files/%s%s', $this->id, $subroute);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function content()
    {
        $this->loadMissing('sections');

        return $this->sections->implode('content', static::CONTENT_SEPARATOR);
    }
}
