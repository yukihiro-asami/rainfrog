<?php /** @noinspection PhpUnused */
namespace castle;
use \PHPUnit\Framework\TestCase;
class RfTestCase extends TestCase
{

    static function set_global_value(string $key, mixed $value) : void
    {
        global $__vals;
        $__vals[$key] = $value;
    }

    static function store_syslog()
    {
        global $__vals;
        file_put_contents($__vals['syslog_dir'] . $__vals['syslog_id'] . '.json', json_encode($__vals, JSON_PRETTY_PRINT));
    }

}