<?php
namespace castle;

use function PHPUnit\Framework\isEmpty;

return function (array &$vals) : string
{
    $DB_TYPE_TO_CLASS = [
        'pdo_mariadb'  => 'Database0implement_PDO_Mariadb',
        'pdo_mysql'  => 'Database0implement_PDO_Mysql'
    ];
    foreach (range(FRG_DB_INSTANCE_PRIMARY, FRG_DB_INSTANCE_8TH) as $db_instance_id)
    {
        if (isset($vals['dbs'][$db_instance_id]) === false)
        {
            set_database(NULL);
            continue;
        }
        $setting = $vals['dbs'][$db_instance_id];
        $obj = new $DB_TYPE_TO_CLASS[$setting['type']]($setting['dsn'], $setting['username'], $setting['password']);
        $obj->set_database_index($db_instance_id);
        set_database($obj);
    }
    $table_content_manager = new $vals['table_content_manager']();
    set_table_constraints_manager($table_content_manager);
    return 'success';
};