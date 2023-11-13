<?php
class credential0db0access extends \castle\RfTestCase
{

    function test_table_users()
    {
        static::_truncate_table('users');
        $user_name = 'hoge1&5';
        $user_data = [
            'name'  => $user_name,
            'password_hash'  => 'hogehoge'
        ];
        $credential0implement = \castle\credential();
        $credential0implement->store_user($user_data);
        $user_data_stored =$credential0implement->_find_user_by_name($user_name);
        $this->assertEquals($user_name, $user_data_stored['name']);
        $this->assertEquals($user_data['password_hash'], $user_data_stored['password_hash']);
        $this->assertEquals(3, $user_data_stored['group']);
    }

    function test_table_sessions()
    {
        static::_truncate_table('sessions');
        $credential0implement = \castle\credential();
        $token = \castle\generate_token();
        $params = [
            'is_logged_in' => 0,
            'user_id' => 0,
            'token' => $token,
            'user_agent' => 'hoge hoge',
            'ip_address' => '1.1.1.1',
            'rotated_at' => time()
        ];
        $credential0implement->_store_session($params);
        $result = $credential0implement->_find_session_by_token($token);
        foreach (['is_logged_in', 'user_id','token', 'user_agent', 'ip_address'] as $key)
        {
            $this->assertEquals($params[$key], $result[$key]);
        }
        $new_token = \castle\generate_token();
        $credential0implement->_update_session($result['id'], ['token' => $new_token]);
        $new_result = $credential0implement->_find_session_by_token($new_token);
        $this->assertEquals($new_token, $new_result['token']);
        echo 'time: ' . time() . PHP_EOL;

        print_r($new_result);

        $credential0implement->delete_session_data();

        $expire = time() - $credential0implement->_session_cookie_expiration_time - 1;
        $credential0implement->_update_session($result['id'], ['rotated_at' => $expire]);

        $result = $credential0implement->_find_session_by_token($new_token);
        $this->assertTrue(isset($result['id']));
        $credential0implement->delete_session_data();
        $result = $credential0implement->_find_session_by_token($new_token);
        $this->assertFalse(isset($result['id']));

        print_r($result);
    }

    function test_table_remember_me()
    {
        static::_truncate_table('remember0me');
        $credential0implement = \castle\credential();
        $token = \castle\generate_token();
        $user_id = 1;
        $ip_address = '111,111,111,111';
        $user_agent = 'hoge hoge hoge';
        $credential0implement->_store_remember_me($token, $user_id, $ip_address, $user_agent);

        $credential0implement->delete_remember_me_data();

        $result = $credential0implement->_find_remember_me_by_token($token);
        $this->assertTrue(isset($result['id']));
        $database0implement = \castle\database_implement(FRG_DB_INSTANCE_PRIMARY);
        $database0implement
            ->store(
                $credential0implement->_remember_me_table_name,
                ['token'],
                [
                    'token'  =>  $token,
                    'created_at_int' => time() - 2419200 -1
                ]
            );

        $credential0implement->delete_remember_me_data();

        $result = $credential0implement->_find_remember_me_by_token($token);
        $this->assertFalse(isset($result['id']));
    }

    function test_table_remember_me_2()
    {
        static::_truncate_table('remember0me');
        $credential0implement = \castle\credential();
        $token = \castle\generate_token();
        $user_id = 1;
        $ip_address = '111,111,111,111';
        $user_agent = 'hoge hoge hoge';
        $credential0implement->_store_remember_me($token, $user_id, $ip_address, $user_agent);
        $result = $credential0implement->_find_remember_me_by_token($token);
        $this->assertTrue(isset($result['id']));
        $credential0implement->_delete_remember_me_by_token($token);
        $result_new = $credential0implement->_find_remember_me_by_token($token);
        $this->assertFalse(isset($result_new['id']));
    }

    function test_remember_me_1()
    {
        static::_truncate_table('remember0me');
        $user_agent = 'hage hoge fuga';
        $ip_address = '1.2.3.4';
        $this->set_global_value('user_agent', $user_agent);
        $this->set_global_value('remote_addr', $ip_address);
        $credential0implement = \castle\credential();
        $credential0implement->_user_id = 3;
        $credential0implement->_is_cookie_encrypted = true;
        $credential0implement->remember_me();
        global $__cookies;
        $value = $__cookies['remember_me']['value'];
        $this->set_global_value('captured_cookie_values', ['remember_me' => $value]);
        $send_token =  $credential0implement->get_cookie('remember_me');
        $database0implement = \castle\database_implement(FRG_DB_INSTANCE_PRIMARY);
        $result =$database0implement->find_by('remember0me', 'id', 1);
        $this->assertEquals($send_token, $result[0]['token']);
        static::_truncate_table('remember0me');
    }

    /** @noinspection DuplicatedCode */
    function test_remember_me_2()
    {
        static::_truncate_table('remember0me');
        static::_truncate_table('sessions');
        $user_agent = 'hage hoge fuga';
        $ip_address = '1.2.3.4';
        $this->set_global_value('user_agent', $user_agent);
        $this->set_global_value('remote_addr', $ip_address);
        $credential0implement = \castle\credential();

        $credential0implement->_user_id = 3;
        $credential0implement->remember_me();
        global $__cookies;
        $value = $__cookies['remember_me']['value'];

        $__cookies = [];

        \castle\set_credential(new \castle\Credential0implement());
        $credential0implement = \castle\credential();
        $credential0implement->issue_session_id();

        $session_info_cookie_value = $__cookies['session_info']['value'];

        $this->set_global_value('captured_cookie_values', ['remember_me' => $value, 'session_info' => $session_info_cookie_value]);
        \castle\set_credential(new \castle\Credential0implement());

        $credential0implement = \castle\credential();
        $result = $credential0implement->_check_remember_me();
        $this->assertTrue($result);
        $database0implement = \castle\database_implement(FRG_DB_INSTANCE_PRIMARY);
        $result = $database0implement->find_by('sessions', 'id', 1);
        $this->assertEquals($ip_address, $result[0]['ip_address']);
        $this->assertEquals($user_agent, $result[0]['user_agent']);
        static::_truncate_table('remember0me');
        static::_truncate_table('sessions');
    }

    function test_remember_me_3()
    {
        static::_truncate_table('remember0me');
        static::_truncate_table('sessions');
        $user_agent = 'hage hoge fuga';
        $ip_address = '1.2.3.4';
        $this->set_global_value('user_agent', $user_agent);
        $this->set_global_value('remote_addr', $ip_address);
        $credential0implement = \castle\credential();

        $credential0implement->_user_id = 3;
        $credential0implement->remember_me();
        global $__cookies;
        $value = $__cookies['remember_me']['value'];

        $__cookies = [];

        \castle\set_credential(new \castle\Credential0implement());
        $credential0implement = \castle\credential();
        $credential0implement->issue_session_id();

        $session_info_cookie_value = $__cookies['session_info']['value'];

        $this->set_global_value('captured_cookie_values', ['remember_me' => $value, 'session_info' => $session_info_cookie_value]);
        \castle\set_credential(new \castle\Credential0implement());

        $ip_address_2 = '1.0.0.0';
        $this->set_global_value('remote_addr', $ip_address_2);
        \castle\set_credential(new \castle\Credential0implement());

        $credential0implement = \castle\credential();
        $result = $credential0implement->_check_remember_me();
        $this->assertFalse($result);
    }

    function test_remember_me_4()
    {
        static::_truncate_table('remember0me');
        static::_truncate_table('sessions');
        $user_agent = 'hage hoge fuga';
        $ip_address = '1.2.3.4';
        $this->set_global_value('user_agent', $user_agent);
        $this->set_global_value('remote_addr', $ip_address);
        $credential0implement = \castle\credential();

        $credential0implement->_user_id = 3;
        $credential0implement->remember_me();
        global $__cookies;
        $value = $__cookies['remember_me']['value'];

        $__cookies = [];

        \castle\set_credential(new \castle\Credential0implement());
        $credential0implement = \castle\credential();
        $credential0implement->issue_session_id();

        $session_info_cookie_value = $__cookies['session_info']['value'];

        $this->set_global_value('captured_cookie_values', ['remember_me' => $value, 'session_info' => $session_info_cookie_value]);
        \castle\set_credential(new \castle\Credential0implement());

        $user_agent_2 = 'hoge hoge hoge';
        $this->set_global_value('user_agent', $user_agent_2);
        \castle\set_credential(new \castle\Credential0implement());

        $credential0implement = \castle\credential();
        $result = $credential0implement->_check_remember_me();
        $this->assertFalse($result);
    }

    function test_dont_remember_me()
    {
        static::_truncate_table('remember0me');
        static::_truncate_table('sessions');
        $user_agent = 'hage hoge fuga';
        $ip_address = '1.2.3.4';
        $this->set_global_value('user_agent', $user_agent);
        $this->set_global_value('remote_addr', $ip_address);
        $credential0implement = \castle\credential();

        $credential0implement->_user_id = 3;
        $credential0implement->remember_me();
        global $__cookies;
        $value = $__cookies['remember_me']['value'];

        $__cookies = [];

        \castle\set_credential(new \castle\Credential0implement());
        $credential0implement = \castle\credential();
        $credential0implement->issue_session_id();

        $session_info_cookie_value = $__cookies['session_info']['value'];

        $this->set_global_value('captured_cookie_values', ['remember_me' => $value, 'session_info' => $session_info_cookie_value]);
        \castle\set_credential(new \castle\Credential0implement());

        $credential0implement = \castle\credential();
        $credential0implement->dont_remember_me();

        global $__cookies;
        $this->assertEquals(3600,  time() - $__cookies['remember_me']['expires']);

        $database0implement = \castle\database_implement(FRG_DB_INSTANCE_PRIMARY);
        $result = $database0implement->find_by('remember0me', 'id', 1);

        $this->assertEquals(0, count($result));

        static::_truncate_table('remember0me');
        static::_truncate_table('sessions');
    }
    public static function _truncate_table(string $table_name) : void
    {
        $sql = <<<EOF
TRUNCATE TABLE `$table_name`;
EOF;
        Db::query($sql)->execute();
    }

}