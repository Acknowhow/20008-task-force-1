<?php
function generateUniqueRandomNumber($min, $max, $current)
{
    while ($number = rand($min, $max)) {
        if ($number !== $current) {
            break;
        }
    }
    return $number;
}
