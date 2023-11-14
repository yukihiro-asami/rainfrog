<?php /** @noinspection DuplicatedCode */

class credential0multi0users extends \castle\RfTestCase
{

    public $user_data = [
        'hoge01' =>
            [
                'password' => '8ovRmeBQaa11',
                'user_agent' =>  'hogehoge UserAagent',
                'ip_address' =>  '1.2.3.4',
                'session_info' =>  '',
                'remember_me' =>  ''
            ],
        'hoge02' =>
            [
                'password' => '1ovRmeBQaa11',
                'user_agent' =>  'hogehoge UserAgenat',
                'ip_address' =>  '1.2.3.5',
                'session_info' =>  '',
                'remember_me' =>  ''
            ],
        'hagehoge123' =>
            [
                'password' => '1ovRmeBQaa22',
                'user_agent' =>  'hogehoge UserAgen2t',
                'ip_address' =>  '0.2.3.6',
                'session_info' =>  '',
                'remember_me' =>  ''
            ],
        'hoge011' =>
            [
                'password' => '8ovRmeBQaa11',
                'user_agent' =>  'hogehoge UserAagent',
                'ip_address' =>  '0.2.3.4',
                'session_info' =>  '',
                'remember_me' =>  ''
            ],
        'hoge022' =>
            [
                'password' => '1ovRmeBQaa11',
                'user_agent' =>  'hogehoge UserAgenat',
                'ip_address' =>  '0.2.3.5',
                'session_info' =>  '',
                'remember_me' =>  ''
            ],
        'hagehoge1233' =>
            [
                'password' => '1ovRmeBQaa22',
                'user_agent' =>  'hogehoge UserAgen2t',
                'ip_address' =>  '0.2.3.6',
                'session_info' =>  '',
                'remember_me' =>  ''
            ]
    ];
    function test_table_users_1()
    {
        static::_clean_up();
        $setting = $this->get_user_setting('hoge01');
        $this->set_user_env($setting);
        $credential0implement = $this->new_credential();
        $credential0implement->issue_session_id();
        $user_data = [
            'name' => 'hoge01',
            'password_hash' => $credential0implement->password_hash($setting['password'])
        ];
        $credential0implement->store_user($user_data);
        $this->store_cookie_setting('hoge01');
        $setting = $this->get_user_setting('hoge01');
        $this->set_user_env($setting);
        $credential0implement = $this->new_credential();
        $result = $credential0implement->login('hoge01', $setting['password']);
        $this->assertTrue($result);

        $setting = $this->get_user_setting('hoge01');
        $this->set_user_env($setting);
        $credential0implement = $this->new_credential();
        $result = $credential0implement->check();
        $this->assertTrue($result);
        $credential0implement->logout();

        $setting = $this->get_user_setting('hoge01');
        $this->set_user_env($setting);
        $credential0implement = $this->new_credential();
        $result = $credential0implement->check();
        $this->assertFalse($result);

    }

    function test_2()
    {
        static::_clean_up();
        foreach ($this->user_data as $name => $setting)
        {
            $setting = $this->get_user_setting($name);
            $this->set_user_env($setting);
            $credential0implement = $this->new_credential();
            $credential0implement->issue_session_id();
            $user_data = [
                'name' => $name,
                'password_hash' => $credential0implement->password_hash($setting['password'])
            ];
            $credential0implement->store_user($user_data);
            $this->store_cookie_setting($name);
        }

        foreach ($this->user_data as $name => $setting)
        {
            $setting = $this->get_user_setting($name);
            $this->set_user_env($setting);
            $credential0implement = $this->new_credential();
            $result = $credential0implement->login($name, $setting['password']);
            $this->assertTrue($result);
        }

        foreach ($this->user_data as $name => $setting)
        {
            $setting = $this->get_user_setting($name);
            $this->set_user_env($setting);
            $credential0implement = $this->new_credential();
            $result = $credential0implement->check($name, $setting['password']);
            $this->assertTrue($result);
        }

        foreach ($this->user_data as $name => $setting)
        {
            $setting = $this->get_user_setting($name);
            $this->set_user_env($setting);
            $credential0implement = $this->new_credential();
            $result = $credential0implement->logout($name, $setting['password']);
            $this->assertTrue($result);
        }

        foreach ($this->user_data as $name => $setting)
        {
            $setting = $this->get_user_setting($name);
            $this->set_user_env($setting);
            $credential0implement = $this->new_credential();
            $result = $credential0implement->check($name, $setting['password']);
            $this->assertFalse($result);
        }
    }

    function test_3()
    {
        static::_clean_up();
        foreach ($this->user_data as $name => $setting) {
            $setting = $this->get_user_setting($name);
            $this->set_user_env($setting);
            $credential0implement = $this->new_credential();
            $credential0implement->issue_session_id();
            $user_data = [
                'name' => $name,
                'password_hash' => $credential0implement->password_hash($setting['password'])
            ];
            $credential0implement->store_user($user_data);
            $this->store_cookie_setting($name);
        }

        foreach ($this->user_data as $name => $setting) {
            $setting = $this->get_user_setting($name);
            $this->set_user_env($setting);
            $credential0implement = $this->new_credential();
            $credential0implement->login($name, $setting['password']);
            $credential0implement->remember_me();
            $this->store_cookie_setting($name);
        }

        $database0implement = \castle\database_implement(FRG_DB_INSTANCE_PRIMARY);
        $database0implement->delete('sessions', 'id', 0, '>');

        foreach ($this->user_data as $name => $setting) {
            $setting = $this->get_user_setting($name);
            $this->set_user_env($setting);
            $credential0implement = $this->new_credential();
            $credential0implement->issue_session_id();
            $this->store_cookie_setting($name);
        }

        foreach ($this->user_data as $name => $setting)
        {
            $setting = $this->get_user_setting($name);
            $this->set_user_env($setting);
            $credential0implement = $this->new_credential();
            $result = $credential0implement->check();
            $this->assertTrue($result);
        }

    }

    function test_clean_up()
    {
        $this->_clean_up();
    }
    function new_credential() : \castle\Credential0implement
    {
        \castle\set_credential(new \castle\Credential0implement());
        return \castle\credential();
    }

    function set_user_env(array $setting)
    {
        $this->set_global_value('user_agent', $setting['user_agent']);
        $this->set_global_value('remote_addr', $setting['ip_address']);
        $cookie_values = [];
        if ($setting['session_info'] !== '')
            $cookie_values['session_info'] = $setting['session_info'];
        if ($setting['session_info'] !== '')
            $cookie_values['remember_me'] = $setting['remember_me'];
        $this->set_global_value('captured_cookie_values', $cookie_values);
    }

    function get_user_setting(string $name)
    {
        return $this->user_data[$name];
    }

    function store_cookie_setting($name)
    {
        global $__cookies;
        if (isset($__cookies['session_info']) === true)
            $this->user_data[$name]['session_info'] = $__cookies['session_info']['value'];
        if (isset($__cookies['remember_me']) === true)
            $this->user_data[$name]['remember_me'] = $__cookies['remember_me']['value'];
        $__cookies = [];
    }

    function set_user_setting(string $name, string $key, string $value)
    {
        $this->user_data[$name][$key] = $value;
    }

    static function _clean_up()
    {
        static::_truncate_table('sessions');
        static::_truncate_table('remember0me');
        static::_truncate_table('users');
    }
    public static function _truncate_table(string $table_name) : void
    {
        $sql = <<<EOF
TRUNCATE TABLE `$table_name`;
EOF;
        Db::query($sql)->execute();
    }

}