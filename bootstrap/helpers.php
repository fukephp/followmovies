<?php

if(!function_exists('is_multidimensional'))
{
    function is_multidimensional(array $array) {
        return count($array) !== count($array, COUNT_RECURSIVE);
    }
}
