<?php /** @noinspection PhpUnused */
namespace castle;
class Input extends Castle
{
    static public function ip() : string
    {
        return static::_remote_addr();
    }

    static public function user_agent() : string
    {
        return static::_user_agent();
    }

    static public function params(?string $name = NULL) : array|string
    {
        if ($name === null)
            return static::_params();
        return static::_params()[$name];
    }

    static public function uri() : array|string
    {
        return static::_request_uri();
    }
}