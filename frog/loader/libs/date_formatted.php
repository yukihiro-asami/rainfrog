<?php
namespace castle;
function date_formatted(string $format = 'Y-m-d H:i:s') : string
{
    return  date($format);
}