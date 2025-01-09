<?php
namespace castle;
function table_constraints_manager(int $database_index) : TableConstraintsManager|NULL
{
    global $__table_constraints_manager;
    return $__table_constraints_manager;
}