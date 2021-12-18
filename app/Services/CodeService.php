<?php


namespace App\Services;


use Illuminate\Support\Str;

class CodeService implements \App\Interfaces\CodeInterface
{

    public function getCode()
    {
        return Str::random(6);
    }
}
