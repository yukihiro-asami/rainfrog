<?php
namespace castle;
class Controller extends Castle
{
    protected string $_view_filename;

    function __construct()
    {
        $class_array = explode('_', get_class($this));
        array_shift($class_array);
        $this->_view_filename = implode('/',
            array_map(
                fn ($string) => mb_strtolower($string),
                $class_array
            )
        )
        . '.php';
    }
}