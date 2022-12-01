<?php
namespace castle;
function encode_htmlentities_recursively(
    array $subjects,
    int $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5,
    ?string $encoding = null,
    bool $double_encode = true
) : array
{
    return _process_recursively(
        function ($value) use ($flags, $encoding, $double_encode)
        {
            if(gettype($value) === 'string')
            {
                return htmlentities($value, $flags, $encoding, $double_encode);
            } else {
                return $value;
            }
        },
        $subjects
    );
}