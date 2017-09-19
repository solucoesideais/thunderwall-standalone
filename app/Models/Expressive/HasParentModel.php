<?php

namespace App\Models\Expressive;

use Illuminate\Support\Str;
use ReflectionClass;

/**
 * Note: This is a preview of an upcoming package from Tighten.
 **/
trait HasParentModel
{
    public function getParentClass()
    {
        static $parentClassName;

        return $parentClassName ?: $parentClassName = (new ReflectionClass($this))->getParentClass()->getName();
    }

    public function getTable()
    {
        if (!isset($this->table)) {
            return str_replace('\\', '', Str::snake(Str::plural(class_basename($this->getParentClass()))));
        }

        return $this->table;
    }

    public function getForeignKey()
    {
        return Str::snake(class_basename($this->getParentClass())) . '_' . $this->primaryKey;
    }

    public function joiningTable($related)
    {
        $models = [
            Str::snake(class_basename($related)),
            Str::snake(class_basename($this->getParentClass())),
        ];
        sort($models);

        return strtolower(implode('_', $models));
    }
}