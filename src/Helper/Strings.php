<?php


namespace App\Helper;


trait Strings
{

    public function strToDatabase($msg){
        return strtolower($msg);
    }
}