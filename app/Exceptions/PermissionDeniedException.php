<?php

namespace App\Exceptions;

use RuntimeException;

class PermissionDeniedException extends RuntimeException
{
    /**
     * PermissionDeniedException constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->message = sprintf('Permission denied for file %s', $path);
    }

    public function render()
    {
        return view('errors.permission', ['message' => $this->message]);
    }
}