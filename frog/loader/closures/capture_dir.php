<?php
namespace castle;
return function (array &$vals) : string
{
    $dir_array = explode(DIRECTORY_SEPARATOR, __DIR__);
    array_shift($dir_array);
    array_pop($dir_array);
    array_pop($dir_array);
    $base_dir = DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $dir_array) . DIRECTORY_SEPARATOR;
    $vals['base_dir'] = $base_dir;
    $vals['core_classes_dir'] = $base_dir . 'core/classes/';
    $vals['app_classes_dir'] = $base_dir . 'app/classes/';
    $vals['middleware_classes_dir'] = $base_dir . 'spawn/classes/';
    $vals['views_dir'] = $base_dir . 'app/views/';
    $vals['config_dir'] = $base_dir . 'app/config/';
    $vals['syslog_dir'] = $base_dir . 'loader/syslog/';
    return 'success';
};