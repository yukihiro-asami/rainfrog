<?php
namespace castle;
use Throwable;

return function (array &$vals) : string
{
    if ($vals['is_controller_callable'] === false)
    {
        $controller_array = $vals['controller_array'];
        $vals['param_of_controller'] = array_pop($controller_array);
        $vals['controller_with_value_path'] = $vals['app_classes_dir'] . implode('/', $controller_array) . '.php';
        $vals['controller_with_param'] = implode(
            '_',
            array_map(
                fn($string) => ucfirst($string),
                $controller_array
            )
        );
        try {
            if (file_exists($vals['controller_with_value_path']))
            {
                include $vals['controller_with_value_path'];
                $vals['controller_with_value_path_method'] = strtolower($vals['method']) . '_index';
                $controller = new $vals['controller_with_param']();
                $vals['is_controller_with_param_callable'] = method_exists($controller, $vals['controller_with_value_path_method']);
            } else {
                $vals['is_controller_with_param_callable'] = false;
            }
        } /** @noinspection PhpUnusedLocalVariableInspection */ catch (Throwable $t) {
            $vals['is_controller_with_param_callable'] = false;
        }
    }
    return 'success';
};