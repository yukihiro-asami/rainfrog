<?php
namespace castle;
function set_database(Database0implement|NULL $database0implement) : bool
{
    global $__dbs;
    $__dbs[] = $database0implement;
    return true;
}