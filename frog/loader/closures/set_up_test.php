<?php
namespace castle;
return function (array &$vals) : string
{
    set_credential(new Credential0implement());
    $vals['set_credential'] = 'done';
    return 'success';
};