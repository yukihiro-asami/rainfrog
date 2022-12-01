<?php
namespace castle;
function set_credential(Credential0implement $credential0implement) : bool
{
    global $__credential;
    $__credential = $credential0implement;
    return true;
}