<?php
namespace castle;
function database_implement(int $database_index) : Database0implement|NULL
{
    global $__dbs;
    return $__dbs[$database_index];
}