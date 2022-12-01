<?php
namespace castle;
function _process_recursively(callable $callback, array $subjects) : array
{
    foreach ($subjects as $key => $subject)
    {
        if (is_array($subject))
        {
            $subjects[$key] = _process_recursively($callback, $subject);
        } else {
            $subjects[$key] = $callback($subject);
        }
    }
    return $subjects;
}