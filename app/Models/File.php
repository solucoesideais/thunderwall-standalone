<?php

namespace App\Models;

use Facades\App\Disk;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property Collection sections
 * @property string path
 * @property string checksum
 * @property string content
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
        return $this->hasMany(Section::class, 'file_id');
    }

    public function getContentAttribute()
    {
        $this->loadMissing('sections');

        // @TODO: move it to FileContent or FileManager class
        return $this->sections->implode('content', static::CONTENT_SEPARATOR);
    }

    public function getChecksumAttribute()
    {
        // @TODO: Maybe improve performance by adding a checksum column to the file table and keeping it up to date with content change
        // instead of recalculating it real time.
        return md5($this->content);
    }

    public function getSynchronizedAttribute()
    {
        return Disk::match($this);
    }
}
