<?php
namespace castle;
function store_body(string $html) : bool
{
    global $__body;
    $__body = $html;
    return true;
}