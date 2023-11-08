<?php
namespace castle;

return function (array &$vals) : string
{
    $vals['captured_cookie_values'] = $_COOKIE;
    return 'success';
};