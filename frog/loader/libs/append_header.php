<?php
namespace castle;
function append_header(string $name, string $value) : bool
{
    global $__headers;
    $__headers[$name] = $value;
    return true;
}