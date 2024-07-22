<?php

use Laravolt\Avatar\Facade as Avatar;

if (!function_exists('createAvatar')) {
    function createAvatar($name)
    {
        return Avatar::create($name)->toBase64();
    }
}