<?php
namespace castle;

return function (array &$vals) : string
{
    if (in_array(mode(), [CSL_MODE_PHPUNIT, CSL_MODE_TASK]))
    {
        $vals['captured_cookie_values'] = [];
    } else{
        $vals['captured_cookie_values'] = $_COOKIE;
    }
    return 'success';
};