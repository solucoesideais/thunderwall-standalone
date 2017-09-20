<?php

namespace App\Exceptions;

use RuntimeException;

class PermissionDeniedException extends RuntimeException
{
    use Renderable;

    /**
     * PermissionDeniedException constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->message = sprintf('Permission denied for file %s', $path);
    }
}