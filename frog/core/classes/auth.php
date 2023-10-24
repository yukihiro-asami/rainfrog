<?php /** @noinspection PhpUnused */
namespace castle;
class Auth extends Castle
{
    static function login(string $user_name = '', string $password = '') : bool
    {
        return static::_credential_implement()->login($user_name, $password);
    }

    static function logout() : bool
    {
        return static::_credential_implement()->logout();
    }

    static function check() : bool
    {
        return static::_credential_implement()->check();
    }

    static function get_user_id() : int|bool
    {
        return static::_credential_implement()->get_user_id();
    }

    static function anti_csrf_token() :string
    {
        return static::_credential_implement()->anti_csrf_token();
    }

    static function validate_anti_csrf_token(string $token) : bool
    {
        return static::_credential_implement()->validate_anti_csrf_token($token);
    }

    static function issue_session_id() : bool
    {
        return static::_credential_implement()->issue_session_id();
    }

    static function delete_session_data() : bool
    {
        return static::_credential_implement()->delete_session_data();
    }

    static function store_user(array $params) : void
    {
        static::_credential_implement()->store_user($params);
    }

    static function password_hash(string $password) : string|bool
    {
        return static::_credential_implement()->password_hash($password);
    }

    static function _credential_implement() : Credential0implement
    {
        global $__credential;
        return $__credential;
    }
}