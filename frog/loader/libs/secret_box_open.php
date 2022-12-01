<?php
namespace castle;
use Throwable;
function secret_box_open(string $encrypted, string $key) : string
{
    try {
        $decoded = _base64_decode_url_safe($encrypted);
        if (mb_strlen($decoded, '8bit') < (SODIUM_CRYPTO_SECRETBOX_NONCEBYTES + SODIUM_CRYPTO_SECRETBOX_MACBYTES))
            return '';
        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
        $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
        $plain = sodium_crypto_secretbox_open(
            $ciphertext,
            $nonce,
            _base64_decode_url_safe($key)
        );
        if ($plain === false)
            return '';
        sodium_memzero($ciphertext);
        sodium_memzero($key);
        return $plain;
    } /** @noinspection PhpUnusedLocalVariableInspection */ catch (Throwable $t) {
        return '';
    }
}