<?php /** @noinspection PhpUnused */
namespace castle;
use JetBrains\PhpStorm\NoReturn;

class Response extends Castle
{

    function __construct(string|View $body = '', $status = 200, array $headers = array())
    {
        if (gettype($body) === 'string')
        {
            store_body($body);
        } else {
            store_body($body->render());
        }
        $this->set_status($status);
        array_map(fn($header) => append_header($header[0], $header[1]), $headers);
    }

    static function forge(string|View $body = '', $status = 200, array $headers = array()) : Response
    {
        return new static($body, $status, $headers);
    }

    #[NoReturn]
    static function redirect(string $url = '', bool $is_method_location = true, $redirect_code = 302) : void
    {
        $url_base = static::_value('url_base');
        $path = static::_value('path');
        set_status($redirect_code);
        if (str_contains($url, '://') === false)
        {
            $url = $url_base . _empty_next($url, $path);
        }
        if ($is_method_location)
        {
            append_header('Location', $url);
        }
        else
        {
            append_header('Refresh', '0;url=' . $url);
        }
    }

    public function setStatus(int $status = 200) : Response
    {
        set_status($status);
        return $this;
    }

    public function body(string|bool $value = false) : Response|string
    {
        if ($value === false)
        {
            global $__body;
            return $__body;
        } else {
            store_body($value);
            return $this;
        }
    }
}