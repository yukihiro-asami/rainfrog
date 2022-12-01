<?php
namespace castle;
function store_database_log(int $database_index, string $operation, array $detail) : bool
{
    global $__db_logs;
    $__db_logs[$database_index][] = [
        'operation'  =>  $operation,
        'detail'  =>  $detail
    ];
    return true;
}