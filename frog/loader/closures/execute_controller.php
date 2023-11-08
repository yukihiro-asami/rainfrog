<?php
namespace castle;
return function (array &$vals) : string
{
    if ($vals['is_controller_callable'])
    {
        set_credential(new Credential0implement());
        $controller = new $vals['controller']();
        $function = array($controller, $vals['controller_method']);
        $function();
    } elseif ($vals['is_controller_with_param_callable']) {
        set_credential(new Credential0implement());
        $controller = new $vals['controller_with_param']();
        $function = array($controller, $vals['controller_with_value_path_method']);
        $function($vals['param_of_controller']);
    } else {
        set_status(FRG_HTTP_STATUS_CODE_404_NOT_FOUND);
        $path = $vals['views_dir'] . 'castle/__404__.php';
        echo view([], $path);
    }
    return 'success';
};