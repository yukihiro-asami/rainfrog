<?php
namespace castle;
return function (array &$vals) : string
{
    $vals['phpunit_env_setting_file_path'] = $vals['base_dir'] . 'app/tests/phpunit.json';
    $vals['phpunit_env_setting_json']= file_get_contents($vals['phpunit_env_setting_file_path']);
    $vals['captured_cookie_values'] = [];
    set_credential(new Credential0implement());
    $vals['set_credential'] = 'done';
    echo 'syslog_id: ' . $vals['syslog_id'] . PHP_EOL;
    return 'success';
};