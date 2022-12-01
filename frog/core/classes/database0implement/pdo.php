<?php /** @noinspection PhpUnused */
namespace castle;
use Exception;
use PDO;

class Database0implement_PDO extends Database0implement
{
    protected string $_dsn;
    protected string $_user;
    protected string $_password;
    protected ?PDO $_pdo = NULL;

    function __construct($dsn, $user, $password)
    {
        $this->_dsn = $dsn;
        $this->_user = $user;
        $this->_password = $password;
    }

    function _connect_db()
    {
        $this->_pdo = new PDO($this->_dsn, $this->_user, $this->_password);
    }

    public function query(string $sql) : Database0implement
    {
        $this->_sql = $sql;
        return $this;
    }

    public function bind(string $name, string|int|float & $value) : Database0implement
    {
        $this->_params[$name] =& $value;
        return $this;
    }

    public function param(string $name, string|int|float $value) : Database0implement
    {
        $this->_params[$name] = $value;
        return $this;
    }

    public function params(array $name_and_values) : Database0implement
    {
        array_map(
            function ($name) use ($name_and_values) {
                if (in_array(gettype($name_and_values[$name]), ['string', 'integer', 'double']))
                    $this->_params[$name] = $name_and_values[$name];
            },
            array_keys($name_and_values)
        );
        return $this;
    }

    /**
     * @throws \Throwable
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function execute() : array
    {
        if ($this->_pdo === NULL)
            $this->_connect_db();
        try
        {
            $pdo_statement = $this->_pdo->prepare($this->_sql);
            $this->_count = $pdo_statement->execute($this->_params);
            $result = $this->_result = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $throwable) {
            $this->_error = $throwable->getMessage();
            $this->_log_and_init_params_and_query();
            throw $throwable;
        }
        $this->_error = implode(' | ', $this->_pdo->errorInfo());
        $this->_log_and_init_params_and_query();
        return $result;
    }

    public function quote(mixed $value) : string
    {
        if (is_string($value) === false)
            return $value;
        if ($this->_pdo === NULL)
            $this->_connect_db();
        return $this->_pdo->quote($value);
    }

    public function start_transaction() : bool
    {
        if ($this->_pdo === NULL)
            $this->_connect_db();
        $detail['result'] = $this->_pdo->beginTransaction();
        store_database_log($this->_database_index,static::START_TRANSACTION, $detail);
        return $detail['result'];
    }

    public function commit_transaction() : bool
    {
        $detail['result'] = $this->_pdo->commit();
        store_database_log($this->_database_index,static::COMMIT_TRANSACTION, $detail);
        return $detail['result'];
    }

    public function rollback_transaction() : bool
    {
        $detail['result'] = $this->_pdo->rollBack();
        store_database_log($this->_database_index, static::ROLLBACK_TRANSACTION, $detail);
        return $detail['result'];
    }

    public function _store_sql(string $table_name, array $unique_keys, array $column_and_values) : string
    {
        return "INSERT INTO `$table_name` (" .
            implode(',',
                array_map(
                    fn($column) => "`$column`",
                    array_keys($column_and_values)
                )
            ) .
            ") VALUES (" .
            implode(', ',
                array_map(
                    fn($value) => $this->quote($value),
                    $column_and_values
                )
            ) .
            ") ON DUPLICATE KEY UPDATE " .
            implode(', ',
                array_map(
                    fn($column_name) => "`$column_name` = VALUES(`$column_name`)",
                    array_diff(array_keys($column_and_values), $unique_keys)
                )
            );
    }

    /**
     * @throws Exception
     */
    public function _store_records_sql(string $table_name, array $unique_keys, array $records): string
    {
        if (count($records) > static::STORE_RECORDS_MAX_COUNT)
            throw new Exception();
        if (isset($records[0]) === true) {
            $column_names = array_keys($records[0]);
        } else {
            throw new Exception();
        }
        return "INSERT INTO `$table_name` (" .
            implode(',',
                array_map(
                    fn($column_name) => "`$column_name`",
                    $column_names
                )
            ) .
            ") VALUES " .
            implode(', ',
                array_map(
                    fn ($record) => '(' . implode(', ', array_map(fn($value) => $this->quote($value), $record)) . ')',
                    $records
                )
            )
        . " ON DUPLICATE KEY UPDATE " .
            implode(', ',
                array_map(
                    fn($column_name) => "`$column_name` = VALUES(`$column_name`)",
                    array_diff($column_names, $unique_keys)
                )
            );
    }

    public function find_by(string $table_name, string $column, string|int $value, string $operator = '=', ?int $limit = NULL, int $offset = 0) : array
    {
        $sql = "SELECT * FROM `$table_name` WHERE `$column` $operator :value"
            . ($limit === NULL ? '' : " limit $limit")
            . ($offset === 0 ? '' : " offset $offset");
        return $this->query($sql)->params(['value'  => $value])->execute();
    }

    public function delete_all_data_and_reset_auto_increment(string $table): bool
    {
        $sql = <<<EOF
DELETE FROM $table;
EOF;
        $this->query($sql)->execute();
        $sql = <<<EOF
ALTER TABLE $table AUTO_INCREMENT = 1;
EOF;
        $this->query($sql)->execute();
        return true;
    }

    public function _update_by_key_sql(string $table_name, int $primary_key, array $fields, string $primary_key_name = 'id'): string
    {
        return "UPDATE `" . $table_name . "` SET " .
            implode(', ',
                array_map(
                    fn($key, $value) => "`$key` = " . $this->quote($value),
                    array_keys($fields),
                    array_values($fields)
                )
            ) .
            " WHERE `$primary_key_name` = " . $primary_key;
    }

    public function _delete_sql(string $table_name, string $column, int|string $value, string $operator = '=') : string
    {
        $value_string = is_string($value) ? "'{$value}'" : $value;
        return "DELETE FROM `{$table_name}` WHERE `{$column}` {$operator} " . $value_string;
    }
}