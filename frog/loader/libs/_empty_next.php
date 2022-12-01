<?php
namespace castle;
function _empty_next(?string ...$values) : string
{
    foreach ($values as $value)
    {
        if (isset($value) === false OR $value=== '')
            continue;
        return $value;
    }
    return '';
}