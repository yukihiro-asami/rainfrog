<?php
namespace castle;
function _base64_encode_url_safe(string $subject) : string
{
     return strtr(
        base64_encode($subject),
        [
            '='  =>  '',
            '+'  =>  '-',
            '/'  =>  '_',
        ]
    );
}