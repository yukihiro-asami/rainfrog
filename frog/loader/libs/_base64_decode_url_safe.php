<?php
namespace castle;
function _base64_decode_url_safe(string $subject) : string
{
    return base64_decode(
        strtr(
            $subject,
            [
                '-'  =>  '+',
                '_'  =>  '/'
            ]
        )
    );
}