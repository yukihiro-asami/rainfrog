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
                    setcookie($cookie_name, $cookie_values['value'], $cookie_values['expires'], $cookie_values['path'], $cookie_values['domain']);
                },
                array_keys($__cookies),
                array_values($__cookies)
            );
            echo $__body;
        }
    );
    return 'success';
};