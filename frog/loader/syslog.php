<?php
include('libs/load.php');
$commands = [
    'capture_server',
    'capture_dir',
    'process_request_uri',
    'retrieve_syslog'
];
$__results = [];
$__vals = [];
$__body = '';
foreach ($commands as $command)
{
    $closure = include('closures/' . $command . '.php');
    $__results[$command] = $closure($__vals);
}