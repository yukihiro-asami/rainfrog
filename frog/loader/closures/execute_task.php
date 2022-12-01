<?php
namespace castle;

use PHPUnit\SebastianBergmann\CodeCoverage\Report\PHP;

return function (array &$vals) : string
{
    global $__task_class_name, $__task_param;
    $task_program_path =  $vals['app_classes_dir'] . 'task/'.  mb_strtolower($__task_class_name) . '.php';
    if (file_exists($task_program_path) === true)
    {
        include $task_program_path;
        $task_object = new $__task_class_name();
        if (method_exists($task_object, 'run'))
        {
            $task_object->run($__task_class_name);
        } else {
            return 'fail';
        }
        return 'success';
    } else {
        return 'fail';
    }
};