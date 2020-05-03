<?php


namespace App\Helper;


trait Dates
{

    public function strYMD2strDMY($datum){
        return date('d/m/Y', strtotime($datum));
    }
}