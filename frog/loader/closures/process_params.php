<?php
namespace castle;
return function (array &$vals) : string
{
    if ($vals['method'] === 'GET')
    {
        $vals['params'] = $vals['parsed_query_string'];
    } else {
        $vals['params'] = $vals['parsed_php_input'];
    }
    $vals['sanitized_params'] = encode_htmlentities_recursively($vals['params']);
    return 'success';
};