<?php
namespace castle;
use Throwable;

return function (array &$vals) : string {
    $path_routes_processing = $vals['path'];
    foreach ($vals['routes'] as $alias => $path) {
        if ($alias === $path_routes_processing)
            $path_routes_processing = $path;
    }
    $vals['path_routes_processed'] = $path_routes_processing;
    if ($vals['is_cms_mode'] === true) {
        $is_ignore = false;
        foreach ($vals['cms_mode_ignore'] as $pattern) {
            if ((bool)preg_match($pattern, $vals['path_routes_processed']) === true) {
                $is_ignore = true;
            }
        }
        if ($is_ignore === false)
        {
            $vals['path_processed'] = $vals['cms_path'] . '/' . urlencode($vals['path_routes_processed']);
        } else {
            $vals['path_processed'] = $vals['path_routes_processed'];
        }
    } else {
        $vals['path_processed'] = $vals['path_routes_processed'];
    }
    $path_array = explode('/', ltrim($vals['path_processed'], '/'));
    array_unshift($path_array, 'controller');
    $vals['controller_array'] = $path_array;
    $vals['controller_path'] = $vals['app_classes_dir'] . implode('/', $path_array) . '.php';
    $class_array = array_map(fn($string) => ucfirst($string), $path_array);
    $vals['controller'] = implode("_", $class_array);
    try {
        if (file_exists($vals['controller_path']))
        {
            include $vals['controller_path'];
            $controller = new $vals['controller']();
            $vals['controller_method'] = strtolower($vals['method']) . '_index';
            $vals['is_controller_callable'] = method_exists($controller, $vals['controller_method']);
        } else {
            $vals['is_controller_callable'] = false;
        }
    }  catch (Throwable $t) {
        $vals['is_controller_callable'] = false;
        throw $t;
    }
    return 'success';
};