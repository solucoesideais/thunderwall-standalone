<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property Collection sections
 * @property string path
 * @property string checksum
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

        // @TODO: move it to FileContent or FileManager class
        return $this->sections->implode('content', static::CONTENT_SEPARATOR);
    }

    public function getChecksumAttribute()
    {
        return md5($this->content());
    }
}
