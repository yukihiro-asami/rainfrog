<?php /** @noinspection PhpUnused */
namespace castle;
use Throwable;

class Log extends Castle
{

    static public function info(Throwable|String $message) : void
    {
        static::_log_info($message);
    }

    static public function error(Throwable|String $message) : void
    {
        static::_log_error($message);
    }
}