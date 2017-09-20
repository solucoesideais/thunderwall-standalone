<?php

namespace App\Exceptions;


trait Renderable
{
    public function render()
    {
        return view('errors.exceptions', ['message' => $this->getMessage()]);
    }

    abstract public function getMessage();
}