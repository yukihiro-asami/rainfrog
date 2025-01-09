<?php
namespace castle;
function set_table_constraints_manager(TableConstraintsManager $table_constraints_manager) : bool
{
    global $__table_constraints_manager;
    $__table_constraints_manager = $table_constraints_manager;
    return true;
}