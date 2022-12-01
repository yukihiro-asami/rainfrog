<?php
namespace castle;
return function (array &$vals) : string
{
    $parsed_uri = parse_url($vals['request_uri']);
    if ($parsed_uri === false)
    {
        $vals['path'] = '';
        $vals['query_string'] = '';
        return 'fail';
    }
    $vals['path'] = isset($parsed_uri['path']) === true ? $parsed_uri['path'] : '';
    if (isset($parsed_uri['query']) === true)
    {
        $vals['query_string'] = $parsed_uri['query'];
        $parsed_query_string = [];
        parse_str($parsed_uri['query'], $parsed_query_string);
        $vals['parsed_query_string'] = $parsed_query_string;
    } else {
        $vals['query_string'] = '';
        $vals['parsed_query_string'] = [];
    }
    return 'success';
};