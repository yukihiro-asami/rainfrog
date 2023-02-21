<?php
namespace castle;
return function (array &$vals) : string
{
    if ($vals['method'] === 'GET')
    {
        $vals['params'] = $vals['parsed_query_string'];
    } else if ($vals['method'] === 'POST' AND str_contains($vals['content_type'], FRG_MEDIA_TYPE_MULTIPART_FORM_DATA)) {
        $vals['post_request'] = $_REQUEST;
        $vals['post_params'] = $_POST;
        $vals['params'] = $vals['post_params'];
    } else {
        $vals['params'] = $vals['parsed_php_input'];
    }
    $vals['sanitized_params'] = encode_htmlentities_recursively($vals['params']);
    return 'success';
};