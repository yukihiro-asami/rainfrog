<?php
namespace castle;
function store_cookie(
    string $name,
    string|array $value = "",
    int $expires_or_options = 0,
    string $path = "",
    string $domain = ""
) : bool
{
    global $__cookies;
    $__cookies[$name] = [
        'value'  =>  $value,
        'expires'  =>  $expires_or_options,
        'path'  =>  $path,
        'domain'  =>  $domain
    ];
    return true;
}