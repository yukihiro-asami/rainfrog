<?php
namespace castle;
use Throwable;
function generate_token(string $salt = 'z9KapBR85ofNWiRl', int $length = 32, string $algo = 'sha512') : string
{
    try {
        return substr(_base64_encode_url_safe(hash($algo, $salt . bin2hex(random_bytes(64)), true)), 0, $length);
    } /** @noinspection PhpUnusedLocalVariableInspection */ catch (Throwable $t) {
        return '';
    }
}