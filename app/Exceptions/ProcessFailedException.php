<?php

namespace App\Exceptions;

use Symfony\Component\Process\Exception\ProcessFailedException as Base;

class ProcessFailedException extends Base
{
    use Renderable;
}