<?php
namespace castle;
function send_headers() : bool
{
    global $__headers;
    foreach ($__headers as $name => $value)
    {
        header("$name: $value");
    }
    return true;
}