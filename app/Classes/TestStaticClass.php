<?php

namespace App\Classes;

class TestStaticClass
{

    public int $count = 0;
    public static $counter = 0;

    public static function foo()
    {
        return 'foo';
    }


}
