<?php
/** @noinspection DuplicatedCode */
include('libs/load.php');
$commands = <<<EOF
get_syslog_id
capture_dir
config_setup
set_up_core_classes
process_cookie
register_app_auto_loader
set_up_database
set_up_test
store_syslog
EOF;
global $__mode, $__results, $__vals, $__body, $__protocol, $__status, $__headers, $__cookies, $__dbs, $__credential;
$__mode = FRG_MODE_PHPUNIT;
$__results = [];
$__vals = [];
$__body = '';
$__protocol = 'HTTP/1.1';
$__status = FRG_HTTP_STATUS_CODE_200_OK;
$__headers = [];
$__cookies = [];
$__dbs = [];
$__db_logs = [];
$__credential = NULL;
foreach (explode(PHP_EOL, $commands) as $command)
{
    $closure = include('closures/' . $command . '.php');
    $__results[$command] = $closure($__vals);
}
/** @noinspection PhpIgnoredClassAliasDeclaration */
class_alias('PHPUnit\Framework\TestCase', 'TestCase');
