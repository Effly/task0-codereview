<?php


namespace App\Services;


use App\Interfaces\CodeInterface;
use Illuminate\Support\Str;

class CodeService implements CodeInterface
{

    public function getCode()
    {
        return Str::random(6);
    }
}
