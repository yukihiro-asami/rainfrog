<?php
namespace castle;
return function (array &$vals) : string
{
    $class_name = 'RfTestCase';
    $base_path =& $vals['core_classes_dir'];
    $path = mb_strtolower(str_replace('_', '/', $class_name));
    include($base_path . $path . '.php');
    class_alias('\\castle\\' . ucfirst($class_name), '\\' . ucfirst($class_name));
    $vals['phpunit_env_setting_file_path'] = $vals['base_dir'] . 'app/tests/phpunit.json';
    $vals['phpunit_env_setting_json'] = file_get_contents($vals['phpunit_env_setting_file_path']);
    $vals['phpunit_env_setting_array'] =json_decode($vals['phpunit_env_setting_json'], true);
    $vals['captured_server_value'] = $vals['phpunit_env_setting_array']['captured_server_value'] ?? [];
    $vals['captured_raw_header'] = $vals['phpunit_env_setting_array']['captured_raw_header'] ?? '';
    $vals['accept_language'] = $vals['phpunit_env_setting_array']['accept_language'] ?? '';
    $vals['host'] = $vals['phpunit_env_setting_array']['host'] ?? '';
    $vals['castle_environment_value'] = $vals['phpunit_env_setting_array']['castle_environment_value'] ?? '';
    $vals['user_agent'] = $vals['phpunit_env_setting_array']['user_agent'] ?? '';
    $vals['content_type'] = $vals['phpunit_env_setting_array']['content_type'] ?? '';
    $vals['remote_addr'] = $vals['phpunit_env_setting_array']['remote_addr'] ?? '';
    $vals['request_uri'] = $vals['phpunit_env_setting_array']['request_uri'] ?? '';
    $vals['request_method'] = $vals['phpunit_env_setting_array']['request_method'] ?? '';
    $vals['server_protocol'] = $vals['phpunit_env_setting_array']['server_protocol'] ?? '';
    $vals['https'] = $vals['phpunit_env_setting_array']['https'] ?? '';
    $vals['method'] = $vals['phpunit_env_setting_array']['method'] ?? '';
    $vals['is_https_on'] = $vals['phpunit_env_setting_array']['is_https_on'] ?? '';
    $vals['url_base'] = $vals['phpunit_env_setting_array']['url_base'] ?? '';
    $vals['files'] = $vals['phpunit_env_setting_array']['files'] ?? '';
    $vals['captured_cookie_values'] = [];
    set_credential(new Credential0implement());
    $vals['set_credential'] = 'done';
    return 'success';
};