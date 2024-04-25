<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class Config extends Settings
{
    public int $port;

    public static function group(): string
    {
        return 'config';
    }
}
