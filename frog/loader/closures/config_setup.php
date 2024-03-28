<?php
namespace castle;
const EXCLUDE_FILES = ['.', '..'];
return function (array &$vals) : string
{
    $config = [];
    foreach (scandir($vals['config_dir']) as $file_name)
    {
        if (in_array($file_name, EXCLUDE_FILES) === false)
        {
            $config[explode('.', $file_name)[0]] = json_decode(file_get_contents($vals['config_dir'] . $file_name), true);
        }
    }
    $vals['captured_config'] = $config;
    $vals['log_file_path'] = $config['castle']['log_file_path'];
    $vals['is_cms_mode'] = $config['castle']['is_cms_mode'] ?? false;
    $vals['cms_mode_ignore'] = $config['castle']['cms_mode_ignore'] ?? false;
    $vals['cms_path'] = $config['castle']['cms_path'] ?? '/path';
    $vals['is_syslog_enabled'] = $config['castle']['is_syslog_enabled'];
    $vals['routes'] = $config['routes'] ?? [];
    $vals['dbs'] = $config['dbs'] ?? [];
    $vals['cookie_setting'] = $config['cookie'] ?? [];
    $vals['credential'] = $config['credential'] ?? [];
    $vals['upload'] = $config['upload'] ?? [];
    return 'success';
};