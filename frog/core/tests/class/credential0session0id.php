<?php /** @noinspection DuplicatedCode */

class Credential0session0id extends \castle\RfTestCase
{

    public $user_data = [
        'hoge01' =>
            [
                'password' => '8ovRmeBQaa11',
                'user_agent' =>  'hogehoge UserAagent',
                'ip_address' =>  '1.2.3.4',
                'session_info' =>  '',
                'remember_me' =>  ''
            ]
    ];

    function test_session_id()
    {
        static::_clean_up();
        $setting = $this->get_user_setting('hoge01');
        $this->set_user_env($setting);
        $credential0implement = $this->new_credential();
        $credential0implement->issue_session_id();
        $expect = $credential0implement->_session_id;
        $result = $credential0implement->get_session_id();
        $this->assertEquals($expect, $result);
        $result2 = Auth::session_id();
        $this->assertEquals($expect, $result2);
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