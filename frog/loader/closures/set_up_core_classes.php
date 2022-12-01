<?php
namespace castle;
return function (array &$vals) : string
{
    $base_path =& $vals['core_classes_dir'];
    $class_names = <<<EOF
Castle
Auth
Cookie
Controller
Credential0implement
Input
Response
View
Database0implement
Database0implement_PDO
DB
Table
EOF;

    foreach (explode(PHP_EOL, $class_names) as $class_name)
    {
        $path = mb_strtolower(str_replace('_', '/', $class_name));
        /** @noinspection PhpIncludeInspection */
        include($base_path . $path . '.php');
        class_alias('\\castle\\' . ucfirst($class_name), '\\' . ucfirst($class_name));
    }
    return 'success';
};