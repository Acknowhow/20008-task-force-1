<?php
namespace TaskForce\helpers;

function key_compare($key1, $key2)
{
    if ($key1 == $key2)
        return 0;

    else
        return -1;
}
