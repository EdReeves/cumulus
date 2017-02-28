<?php

/**
 * @param mixed $key
 * @param array $a
 * @param mixed $default
 * @return mixed
 */
function array_value_default($key, array $a, $default = null)
{
    if (array_key_exists($key, $a))
    {
        return $a[$key];
    }
    else
    {
        return $default;
    }
}