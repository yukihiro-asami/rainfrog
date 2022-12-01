<?php
namespace castle;
function _explode_recursively( array $separators, $subject) : array
{
    $result = [];
    foreach (explode($separators[0], $subject) as $string)
    {
        if (isset($separators[1]))
        {
            $new_separators = $separators;
            array_shift($new_separators);
            $result[] = _explode_recursively($new_separators, $string);
        } else {
            $result[] = $string;
        }
    }
    return $result;
}