<?php
namespace castle;
return function (array &$vals) : string
{
    global $__protocol;
    $__protocol = _empty_next($vals['server_protocol'], $__protocol);
    register_shutdown_function(
        function () use ($vals)
        {
            global $__body, $__cookies;
            send_status_line();
            send_headers();
            array_map(
                function ($cookie_name, $cookie_values) use ($vals) {
                    setcookie($cookie_name, $cookie_values['value'], [
                        'expires'  => $cookie_values['expires'],
                        'path'     => $cookie_values['path'],
                        'domain'   => $cookie_values['domain'],
                        'secure'   => true,
                        'httponly' => true,
                        'samesite' => 'Lax',
                    ]);
                },
                array_keys($__cookies),
                array_values($__cookies)
            );
            echo $__body;
        }
    );
    return 'success';
};