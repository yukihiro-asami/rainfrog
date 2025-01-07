<?php
namespace castle;
function class_name_to_filename(string $class_name) : string
{
    return implode(
        DIRECTORY_SEPARATOR,
        array_slice(explode('\\', $class_name), 1)
    ) . '.php';
}