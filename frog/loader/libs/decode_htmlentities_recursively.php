<?php
namespace castle;
function decode_htmlentities_recursively(
    array $subjects,
    int $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5,
    ?string $encoding = null,
) : array
{
    return _process_recursively(
        function ($value) use ($flags, $encoding)
        {
            if(gettype($value) === 'string')
            {
                return html_entity_decode($value, $flags, $encoding);
            } else {
                return $value;
            }
        },
        $subjects
    );
}