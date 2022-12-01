<?php
namespace castle;
function secret_box_key_generate() : string
{
    return _base64_encode_url_safe(
        sodium_crypto_secretbox_keygen()
    );
}