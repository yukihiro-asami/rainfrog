<?php
include('libs/load.php');

$commands = <<<EOF
capture_dir
config_setup
capture_server
process_cookie
register_shutdown_function
test_bench
EOF;

/** @noinspection DuplicatedCode */
$__results = [];
$__vals = [];
$__body = '';
$__protocol = 'HTTP/1.1';
$__status = FRG_HTTP_STATUS_CODE_200_OK;
$__headers = [];
$__cookies = [];
$__dbs = [];
$__db_logs = [];

foreach (explode(PHP_EOL, $commands) as $command)
{
    /** @noinspection PhpIncludeInspection */
    $closure = include('closures/' . $command . '.php');
    $__results[$command] = $closure($__vals);
}