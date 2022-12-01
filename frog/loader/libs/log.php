<?php
namespace castle;
use Throwable;
const MESSAGE_TYPE = 3;
function log(string $message, $path) : bool
{
    try {
        error_log($message, MESSAGE_TYPE, $path);
        return true;
    } /** @noinspection PhpUnusedLocalVariableInspection */ catch (Throwable $t) {
        return false;
    }
}