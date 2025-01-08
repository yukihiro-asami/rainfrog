<?php
namespace castle;
return function (array &$vals) : string
{
    $base_path =& $vals['middleware_classes_dir'];
    foreach ($vals['middleware'] as $middleware_class_name)
    {
        include($base_path . class_name_to_filename($middleware_class_name));
    }
    return 'success';
};