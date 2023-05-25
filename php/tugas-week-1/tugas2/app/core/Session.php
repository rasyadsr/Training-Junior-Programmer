<?php

namespace App\Core;

class Session extends Auth
{

    public function regenerate()
    {
        self::$credential;
    }
}
