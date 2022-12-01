<?php
namespace castle;
use Throwable;
function secret_box(string $message, string $key) : string
{
    try {
        $key_decoded = _base64_decode_url_safe($key);
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $secret_box = sodium_crypto_secretbox($message, $nonce, $key_decoded);
        return _base64_encode_url_safe($nonce . $secret_box);
    } /** @noinspection PhpUnusedLocalVariableInspection */ catch (Throwable $t) {
        return '';
    }
}