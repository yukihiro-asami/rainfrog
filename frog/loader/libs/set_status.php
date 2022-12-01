<?php
namespace castle;
function set_status(int $status) : bool
{
    global $__status;
    $__status = $status;
    return true;
}