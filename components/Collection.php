<?php

class Collection extends CComponent {
    static public function cutString($string, $len){
        if(strlen($string) < $len){
            return $string;
        }
        return mb_substr($string, 0, $len, 'utf-8') . '...';
    }
}