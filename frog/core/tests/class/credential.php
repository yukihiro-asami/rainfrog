<?php
class Test_Class_Credential extends TestCase
{

    function test_is_ip_addresses_identical_01()
    {
        $credential0implement = new \castle\Credential0implement();
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.0.0.1000', 32);
        $this->assertFalse($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.1000', '0.0.0.0', 32);
        $this->assertFalse($result);
        $result = $credential0implement->_is_ip_addresses_identical('a', 'a', 32);
        $this->assertFalse($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.0.0.0', 32);
        $this->assertTrue($result);
        $result = $credential0implement->_is_ip_addresses_identical('255.255.255.255', '255.255.255.255', 32);
        $this->assertTrue($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.0.0.1', 32);
        $this->assertFalse($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.0.0.0', 24);
        $this->assertTrue($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.0.0.1', 24);
        $this->assertTrue($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.0.1.1', 24);
        $this->assertfalse($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.0.0.0', 16);
        $this->assertTrue($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.0.1.1', 16);
        $this->assertTrue($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.0.0.0', 16);
        $this->assertTrue($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.1.1.1', 16);
        $this->assertFalse($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.0.0.0', 8);
        $this->assertTrue($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.0.1.1', 8);
        $this->assertTrue($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '0.1.1.1', 8);
        $this->assertTrue($result);
        $result = $credential0implement->_is_ip_addresses_identical('0.0.0.0', '1.1.1.1', 8);
        $this->assertFalse($result);
    }

    function test_password_hash()
    {
        $credential0implement = new \castle\Credential0implement();
        $pw_1 = 'hagehage';
        $pw_hash_1 = $credential0implement->_password_hash($pw_1);
        $result = $credential0implement->_verify_password_hash($pw_hash_1, $pw_1);
        $this->assertTrue($result);
        $result = $credential0implement->_verify_password_hash($pw_hash_1, $pw_1 . 'a');
        $this->assertFalse($result);
        $result = $credential0implement->_verify_password_hash($pw_hash_1 . 'hoge', $pw_1);
        $this->assertFalse($result);
        $pw_2 = 'ほげほげ';
        $pw_hash_2 = $credential0implement->_password_hash($pw_2);
        $this->assertFalse($pw_hash_2);
        $pw_3 = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $pw_hash_3 = $credential0implement->_password_hash($pw_3);
        $is_string = is_string($pw_hash_3);
        $this->assertFalse($is_string);
        $pw_4 = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        echo $pw_hash_4 = $credential0implement->_password_hash($pw_4);
        $is_string_2 = is_string($pw_hash_4);
        $this->assertTrue($is_string_2);
    }

    function test_cookie()
    {
        global $__vals;
        $__vals['captured_cookie_values'] = ['hoge'  =>  'hogehoge'];
        $credential0implement = new \castle\Credential0implement();
        echo $credential0implement->get_cookie('hoge') . PHP_EOL;
    }

    function test_init_session()
    {
        global $__vals;
        $__vals['captured_cookie_values'] = ['session_info'  =>  'hogehoge'];
        $credential0implement = new \castle\Credential0implement();
        echo $credential0implement->_current_session_token . PHP_EOL;
    }

    function test_session_store_and_find()
    {
        $token = 'hogehoge';
        $fields = ['token' => $token, 'is_logged_in' => 1, 'user_id' => 10, 'rotated_at' => time()];
        $credential0implement = new \castle\Credential0implement();
        $credential0implement->_store_session($fields);
        $result = $credential0implement->_find_session_by_token($token);
        print_r($result);
        $fields_2 = ['token' => $token, 'is_logged_in' => 0, 'user_id' => 0, 'rotated_at' => 0];
        $credential0implement->_store_session($fields_2);
        $result = $credential0implement->_find_session_by_token($token);
        print_r($result);
        $token_2 = 'hagehage';
        $fields_3 = ['token' => $token_2, 'is_logged_in' => 1, 'user_id' => 10, 'rotated_at' => time()];
        $credential0implement->_update_session($result['id'], $fields_3);
        $result = $credential0implement->_find_session_by_token($token_2);
        print_r($result);
    }

    function test_3()
    {
        $name = 'hogehoge';
        $credential0implement = new \castle\Credential0implement();
        $params = [
           'name' => $name,
           'password_hash' =>  'hagehage'
        ];
        $credential0implement->_store_user($params);
        $user = $credential0implement->_find_user_by_name($name);
        print_r($user);
        $name = $name . '1';
        $params = [
            'name' => $name,
            'password_hash' =>  'hagehage2'
        ];
        $credential0implement->_update_user($user['id'], $params);
        $user = $credential0implement->_find_user_by_name($name);
        print_r($user);
    }

    function test_user()
    {
        $name = 'hogehoge';
        $pass_word = 'hoge1234';
        $credential0implement = new \castle\Credential0implement();
        $params = [
            'name' => $name,
            'password_hash' =>  $credential0implement->_password_hash($pass_word)
        ];

        /** @noinspection DuplicatedCode */
        $credential0implement->_store_user($params);
        $user = $credential0implement->_find_user_by_name($name);
        $result_1 = $credential0implement->_verify_password_hash($user['password_hash'], $pass_word);
        $this->assertTrue($result_1);
        $result_2 = $credential0implement->_verify_password_hash($user['password_hash'] . 'hage', $pass_word);
        $this->assertFalse($result_2);
    }

    function test_validate_user()
    {
        $name = 'hogehoge';
        $pass_word = 'hoge1234';
        $credential0implement = new \castle\Credential0implement();
        $params = [
            'name' => $name,
            'password_hash' =>  $credential0implement->_password_hash($pass_word)
        ];

        /** @noinspection DuplicatedCode */
        $credential0implement->_store_user($params);

        $result_1 = $credential0implement->validate_user($name, $pass_word);
        $this->assertIsArray($result_1);
        $result_2 = $credential0implement->_verify_password_hash($name . 'hage', $pass_word);
        $this->assertFalse($result_2);
        $result_3 = $credential0implement->_verify_password_hash($name, $pass_word  . 'hage');
        $this->assertFalse($result_3);
    }

    function test_delete_session_data()
    {
        $credential0implement = new \castle\Credential0implement(false);
        print_r($credential0implement);
        $credential0implement->delete_session_data();
    }

    function test_store_rm_cookie()
    {
        $credential0implement = new \castle\Credential0implement(false);
        $credential0implement->_store_remember_me('hogehoge', 11, '1.1.1.1', 'hoge hage ua', );
        $result = $credential0implement->_find_remember_me_by_token('hogehoge');
        print_r($result);
        $result = $credential0implement->_find_remember_me_by_token('hogehoge1');
        print_r($result);
    }

    function test_anti_()
    {
        $salt = 'hogehoge';
        $user_id = 11;
        $session_id = 144;
        $expire = 3;
        $credential0implement = new \castle\Credential0implement(false);
        $token = $credential0implement->_generate_anti_csrf_token($salt, $user_id, $session_id, $expire);
        list($is_ok, $message) = $credential0implement->_validate_anti_csrf_token($salt, $user_id, $session_id, $token);
        $this->assertTrue($is_ok);
        list($is_ok, $message) = $credential0implement->_validate_anti_csrf_token($salt, $user_id, $session_id, $token . 'hoge');
        $this->assertFalse($is_ok);
        echo $message . PHP_EOL;
        list($is_ok, $message) = $credential0implement->_validate_anti_csrf_token($salt, 2, $session_id, $token);
        $this->assertFalse($is_ok);
        echo $message . PHP_EOL;
        list($is_ok, $message) = $credential0implement->_validate_anti_csrf_token($salt, $user_id, 1, $token);
        $this->assertFalse($is_ok);
        echo $message . PHP_EOL;
        sleep(10);
        list($is_ok, $message) = $credential0implement->_validate_anti_csrf_token($salt, $user_id, $session_id, $token);
        $this->assertFalse($is_ok);
        echo $message . PHP_EOL;
    }


    function test_hoge()
    {
        try {
            $credential0implement = new \castle\Credential0implement(true);
        } catch (Throwable $t) {
            print_r($t->getTraceAsString());
        }
        print_r($credential0implement);
        $credential0implement->issue_session_id();
    }
}