<?php
namespace castle;
return function (array &$vals) : string
{
    $vals['captured_php_input'] = file_get_contents('php://input');
    if(str_contains($vals['content_type'], CSL_MEDIA_TYPE_APPLICATION_JSON))
    {
        $vals['parsed_php_input'] = json_decode($vals['captured_php_input'], true);
    } else {
        parse_str($vals['captured_php_input'], $parsed_php_input);
        $vals['parsed_php_input'] = $parsed_php_input;
    }
    return 'success';
};