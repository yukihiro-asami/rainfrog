<?php
namespace castle;
function class_name_to_filename(string $class_name) : string
{
    return implode(
        DIRECTORY_SEPARATOR,
        array_map(
            'mb_strtolower',
            explode('_', $class_name)
        )
    ) . '.php';
}