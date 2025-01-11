<?php /** @noinspection PhpUnused */
namespace castle;
class Table extends Castle
{
    protected static ?string $_table_name = NULL;
    protected static string $_primary_key = 'id';
    protected static array $_unique_keys;
    protected static int $_database_index = FRG_DB_INSTANCE_PRIMARY;

    public static function store($column_and_values) : bool
    {
        return database_implement(static::$_database_index)->store(static::_table_name(), static::$_unique_keys, $column_and_values);
    }

    public static function storeRecords($records) : bool
    {
        return database_implement(static::$_database_index)->store_records(static::_table_name(), static::$_unique_keys, $records);
    }

    public static function findByPk(int|string $value) : array
    {
        return static::findOneBy(static::$_primary_key, $value);
    }

    public static function findOneBy(string $column, int|string $value) : array
    {
        return database_implement(static::$_database_index)->find_one_by(static::_table_name(), $column, $value);
    }

    public static function findBy( string $column, string|int $value, string $operator = '=', ?int $limit = NULL, int $offset = 0) : array
    {
        return database_implement(static::$_database_index)->find_by(static::_table_name(), $column, $value, $operator, $limit, $offset);
    }

    public static function _table_name() : string
    {
        if (isset(static::$_table_name))
        {
            return static::$_table_name;
        }
        $class_name = end_of_array(explode('_', get_called_class()));
        return self::_convert_to_snake_case($class_name);
    }
    public static function _convert_to_snake_case(string $class_name): string
    {
        $converted_string = preg_replace('/(?<!^)([A-Z])/', '_$1', $class_name);
        return strtolower($converted_string);
    }
}