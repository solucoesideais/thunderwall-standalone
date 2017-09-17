<?php

namespace App\Support;

use Zttp\Zttp;

class GitHub
{
    protected $url = 'https://api.github.com/repos/solucoesideais/thunderwall-standalone/releases/latest';

    public function latestVersion()
    {
        $response = $this->latestRelease();

        return $response['tag_name'];
    }

    public function latestRelease()
    {
        return Zttp::get($this->url)->json();
    }
}