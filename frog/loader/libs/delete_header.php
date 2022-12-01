<?php
namespace castle;
function delete_header(string $name) : bool
{
    global $__headers;
    unset($__headers[$name]);
    return true;
}