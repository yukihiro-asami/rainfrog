<?php /** @noinspection PhpUnused */
namespace castle;

abstract class Database0implement extends Castle
{
    protected int $_database_index;
    protected string $_sql = '';
    protected array $_params = [];
    protected int $_count = 0;
    protected array $_result = [];
    protected string $_error = '';

    const STORE_RECORDS_MAX_COUNT = 1000;
    const EXECUTE_QUERY = 'execute_query';
    const START_TRANSACTION = 'start_transaction';
    const COMMIT_TRANSACTION = 'commit_transaction';
    const ROLLBACK_TRANSACTION = 'rollback_transaction';

    function _log_and_init_params_and_query() : void
    {
        /** @noinspection DuplicatedCode */
        store_database_log(
            $this->_database_index,
            self::EXECUTE_QUERY,
            [
                'sql'  =>  $this->_sql,
                'params'  => $this->_params,
                'count'  =>  $this->_count,
                'result' => $this->_result,
                'error'  => $this->_error
            ]
        );
        $this->_sql = '';
        $this->_params = [];
        $this->_count = 0;
        $this->_result = [];
        $this->_error = '';
    }

    function set_database_index(int $database_index)
    {
        $this->_database_index = $database_index;
    }

    abstract public function query(string $sql) : Database0implement;

    abstract public function bind(string $name, string|int|float & $value) : Database0implement;

    abstract public function param(string $name, string|int|float $value) : Database0implement;

    abstract public function params(array $name_and_values) : Database0implement;

    abstract public function execute() : array;

    abstract public function quote(mixed $value) : string;

    abstract public function start_transaction() : bool;

    abstract public function rollback_transaction() : bool;

    public function store(string $table_name, array $unique_keys, array $column_and_values) : bool
    {
        $this->query($this->_store_sql($table_name, $unique_keys,$column_and_values))
            ->execute();
        return true;
    }

    abstract public function _store_sql(string $table_name, array $unique_keys, array $column_and_values) : string;

    abstract public function find_by(string $table_name, string $column, string|int $value, string $operator = '=', ?int $limit = NULL, int $offset = 0) : array;

    abstract public function delete_all_data_and_reset_auto_increment(string $table) : bool;

    public function store_records(string $table_name, array $unique_keys, array $records) : bool
    {
        $this->query($this->_store_records_sql($table_name, $unique_keys, $records))
            ->execute();
        return true;
    }

    abstract public function _store_records_sql(string $table_name, array $unique_keys, array $records) : string;

    public function find_one_by(string $table_name, string $column, string|int $value) : array
    {
        $result = static::find_by($table_name, $column, $value, '=', 1);
        if (count($result) === 1)
            return $result[0];
        return [];
    }

    public function update_by_key(string $table_name, int $primary_key, array $fields, string $primary_key_name = 'id') : bool
    {
        $sql = $this->_update_by_key_sql($table_name, $primary_key, $fields);
        $this->query($sql)
            ->execute();
        return true;
    }

    abstract public function _update_by_key_sql(string $table_name, int $primary_key, array $fields, string $primary_key_name = 'id') : string;

    public function delete(string $table_name, string $column, string|int $value, string $operator = '=') : bool
    {
        $sql = $this->_delete_sql($table_name, $column, $value, $operator);
        $this->query($sql)
            ->execute();
        return true;
    }

    abstract public function _delete_sql(string $table_name, string $column, string|int $value, string $operator = '=') : string;
}