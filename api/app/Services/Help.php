<?php

namespace App\Services;

class Help{
    public static function getClassName($name){
        $name = "App\{$name}";
        $name = str_replace('{', '', $name);
        $name = str_replace('}', '', $name);
        return $name;
    }
}