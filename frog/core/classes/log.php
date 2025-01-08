<?php /** @noinspection PhpUnused */
namespace castle;
use Throwable;

class Log extends Castle
{
    const LOG_LEVELS = [
        FRG_LOG_LEVEL_EMERGENCY => '__EMERGENCY__',
        FRG_LOG_LEVEL_ALERT => '__ALERT__',
        FRG_LOG_LEVEL_CRITICAL => '__CRITICAL__',
        FRG_LOG_LEVEL_ERROR => '__ERROR__',
        FRG_LOG_LEVEL_WARNING => '__WARNING__',
        FRG_LOG_LEVEL_NOTICE => '__NOTICE__',
        FRG_LOG_LEVEL_INFO => '__INFO__',
        FRG_LOG_LEVEL_DEBUG => '__DEBUG__',
    ];

    static public function emergency(\Stringable|String $message, array $context = []): void
    {
        self::log(FRG_LOG_LEVEL_EMERGENCY, $message, $context);
    }

    static public function alert(\Stringable|String $message, array $context = []): void
    {
        self::log(FRG_LOG_LEVEL_ALERT, $message, $context);
    }

    static public function critical(\Stringable|String $message, array $context = []): void
    {
        self::log(FRG_LOG_LEVEL_CRITICAL, $message, $context);
    }

    static public function error(\Stringable|String $message, array $context = []): void
    {
        self::log(FRG_LOG_LEVEL_ERROR, $message, $context);
    }

    static public function warning(\Stringable|String $message, array $context = []): void
    {
        self::log(FRG_LOG_LEVEL_WARNING, $message, $context);
    }

    static public function notice(\Stringable|String $message, array $context = []): void
    {
        self::log(FRG_LOG_LEVEL_NOTICE, $message, $context);
    }

    static public function info(\Stringable|String $message, array $context = []): void
    {
        self::log(FRG_LOG_LEVEL_INFO, $message, $context);
    }

    static public function debug(\Stringable|String $message, array $context = []): void
    {
        self::log(FRG_LOG_LEVEL_DEBUG, $message, $context);
    }

    static public function log(int|string $level, \Stringable|String $message, $context = []) : void
    {
        $message_string = $message->__toString();
        $level_string = is_int($level) === true ? self::LOG_LEVELS[$level] : $level;
        $message_string_with_context = self::_convertToString($message_string, $context);
        static::_log($message_string_with_context, $level_string);
    }

    static public function _convertToString(String $message, $context = []): string
    {
        /** @noinspection DuplicatedCode */
        foreach ($context as $key => $value) {
            $placeholder = '{' . $key . '}';
            if (str_contains($message, $placeholder) === true) {
                if (is_object($value) && method_exists($value, '__toString')) {
                    $value = (string)$value;
                } elseif (is_array($value)) {
                    $value = json_encode($value);
                } elseif (!is_scalar($value)) {
                    $value = gettype($value);
                }
                $message = str_replace($placeholder, $value, $message);
            }
        }
        return $message;
    }
}