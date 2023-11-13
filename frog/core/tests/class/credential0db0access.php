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

    public static function _truncate_table(string $table_name) : void
    {
        $sql = <<<EOF
TRUNCATE TABLE `$table_name`;
EOF;
        Db::query($sql)->execute();
    }

}