<?php
namespace castle;
class Castle
{
    static protected function _log_info(\Throwable|string $message) : void
    {
        static::_log($message, '__INFO__');
    }

    static protected function _log(\Throwable|string $message, string $label) : void
    {
        if ($message instanceof \Throwable)
        {
            $logging_message = $message->getMessage() . ' s_id:' . static::_value('syslog_id') . PHP_EOL
            . 'throwed at file ' . $message->getFile() . ' at line ' . $message->getLine() . PHP_EOL;
        } else {
            $logging_message = $message . ' s_id:' . static::_value('syslog_id') . PHP_EOL;
        }
        \castle\log(\castle\date_formatted() . ' '. $label . ' ' . $logging_message, static::_value('_log_file_path'));
    }

    protected static function _request_uri() : string
    {
        return static::_value(__FUNCTION__);
    }

    protected static function _url_base() : string
    {
        return static::_value(__FUNCTION__);
    }

    protected static function _path() : string
    {
        return static::_value(__FUNCTION__);
    }

    protected static function _views_dir() : string
    {
        return static::_value(__FUNCTION__);
    }

    protected static function _castle_environment_value() : string
    {
        return static::_value(__FUNCTION__);
    }

    protected static function _params() : array
    {
        return static::_value(__FUNCTION__);
    }

    protected static function _cookie_setting() : array
    {
        return static::_value(__FUNCTION__);
    }

    protected static function _captured_cookie_values() : array
    {
        return static::_value(__FUNCTION__);
    }

    protected static function _credential() : array
    {
        return static::_value(__FUNCTION__);
    }

    protected static function _remote_addr() : string
    {
        return trim(static::_value(__FUNCTION__));
    }

    protected static function _user_agent() : string
    {
        return trim(static::_value(__FUNCTION__));
    }

    protected static function _value(string $key_or_file_name) : string|array
    {
        $key = str_starts_with($key_or_file_name, '_') === true ? substr($key_or_file_name, 1) : $key_or_file_name;
        global $__vals;
        return $__vals[$key];
    }
}