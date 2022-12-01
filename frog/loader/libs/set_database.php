<?php
namespace castle;
function set_database(Database0implement $database0implement) : bool
{
    global $__dbs;
    $__dbs[] = $database0implement;
    return true;
}