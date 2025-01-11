<?php /** @noinspection PhpUnused */
namespace castle;
use \PHPUnit\Framework\TestCase;
class RfTestCase extends TestCase
{

    static function setGlobalValue(string $key, mixed $value): void
    {
        global $__vals;
        $__vals[$key] = $value;
    }

    static function getGlobalValue(string $key): string|array
    {
        global $__vals;
        return $__vals[$key];
    }

    static function storeSyslog(): void
    {
        global $__vals;
        file_put_contents($__vals['syslog_dir'] . $__vals['syslog_id'] . '.json', json_encode($__vals, JSON_PRETTY_PRINT));
    }

}