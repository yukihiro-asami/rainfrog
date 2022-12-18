<?php
namespace castle;

return function (array &$vals) : string
{
    if (in_array(mode(), [FRG_MODE_PHPUNIT, FRG_MODE_TASK]))
    {
        $vals['captured_cookie_values'] = [];
    } else{
        $vals['captured_cookie_values'] = $_COOKIE;
    }
    return 'success';
};