<?php /** @noinspection PhpUnused */
namespace castle;
class Input extends Castle
{
    static public function ip() : string
    {
        return static::_remote_addr();
    }

    static public function userAgent() : string
    {
        return static::_user_agent();
    }

    static public function params(?string $name = NULL) : array|string
    {
        if ($name === null)
            return static::_params();
        return array_key_exists($name, static::params()) ? static::_params()[$name] : '';
    }

    static public function uri() : array|string
    {
        return static::_path();
    }

    static public function header() : array
    {
        return static::_value('captured_raw_header');
    }

    static public function server(string $index = null) : string|array
    {
        $server = static::_value('captured_server_value');
        if ($index === null)
        {
            return $server;
        }
        if (array_key_exists($index, $server) === false)
        {
            return '';
        }
        return $server[$index];
    }
}