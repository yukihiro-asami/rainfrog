<?php /** @noinspection PhpUnused */
namespace castle;
use Throwable;

class DB extends Castle
{
    protected Database0implement $_db;

    function __construct(int $database_index = FRG_DB_INSTANCE_PRIMARY)
    {
        global $__dbs;
        $this->_db = $__dbs[$database_index];
    }

    static function query($sql, int $database_index = FRG_DB_INSTANCE_PRIMARY): DB
    {
        $instance = new static($database_index);
        $instance->_set_query($sql);
        return $instance;
    }

    function _set_query($sql)
    {
        $this->_db->query($sql);
    }

    public function bind(string $name, string|int|float &$value): DB
    {
        $this->_db->bind($name, $value);
        return $this;
    }

    public function param(string $name, string|int|float $value): DB
    {
        $this->_db->param($name, $value);
        return $this;
    }

    public function params(array $name_and_values): DB
    {
        $this->_db->params($name_and_values);
        return $this;
    }

    /**
     * @throws Throwable
     */
    public function execute(): array
    {
        return $this->_db->execute();
    }

    public function quote(string $string): string
    {
        return $this->_db->quote($string);
    }

    static function start_transaction(int $database_index = FRG_DB_INSTANCE_PRIMARY): bool
    {
        return static::_db_instance($database_index)->start_transaction();
    }

    static function commit_transaction(int $database_index = FRG_DB_INSTANCE_PRIMARY): bool
    {
        return static::_db_instance($database_index)->commit_transaction();
    }

    static function rollback_transaction(int $database_index = FRG_DB_INSTANCE_PRIMARY): bool
    {
        return static::_db_instance($database_index)->rollback_transaction();
    }

    private static function _db_instance(int $database_index): Database0implement
    {
        global $__dbs;
        return $__dbs[$database_index];
    }

}