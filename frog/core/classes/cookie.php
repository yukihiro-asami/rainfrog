<?php /** @noinspection PhpUnused */
namespace castle;
use Throwable;

class Cookie extends Castle
{

    static public function set(string $cookie_name, array|string $value, int $expiration = 3600, string $path = '', string $domain = '') : bool
    {
        return static::_credential_instance()->set_cookie($cookie_name, $value, $expiration, $path, $domain);
    }

    static public function get(?string $name = NULL) : array|string
    {
        return static::_credential_instance()->get_cookie($name);
    }

    private static function _credential_instance(): Credential0implement
    {
        global $__credential;
        return $__credential;
    }
}