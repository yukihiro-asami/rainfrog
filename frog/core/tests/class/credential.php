<?php
class Test_Class_Credential extends \castle\RfTestCase
{

    function test_log_credential()
    {
        $credential0implement = \castle\credential();
        $credential0implement->_log_credential('hoge hoge');
    }

    function test_password_hash()
    {
        $credential0implement = \castle\credential();
        $pw_1 = 'hagehage';
        $pw_hash_1 = $credential0implement->password_hash($pw_1);
        $result = $credential0implement->_verify_password_hash($pw_hash_1, $pw_1);
        $this->assertTrue($result);
        $result = $credential0implement->_verify_password_hash($pw_hash_1, $pw_1 . 'a');
        $this->assertFalse($result);
        $result = $credential0implement->_verify_password_hash($pw_hash_1 . 'hoge', $pw_1);
        $this->assertFalse($result);
        $pw_2 = 'ほげほげ';
        $pw_hash_2 = $credential0implement->password_hash($pw_2);
        $this->assertFalse($pw_hash_2);
        $pw_3 = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $pw_hash_3 = $credential0implement->password_hash($pw_3);
        $is_string = is_string($pw_hash_3);
        $this->assertFalse($is_string);
        $pw_4 = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        echo $pw_hash_4 = $credential0implement->password_hash($pw_4);
        $is_string_2 = is_string($pw_hash_4);
        $this->assertTrue($is_string_2);
    }

    function test_is_ip_addresses_identical()
    {
        $credential0implement = \castle\credential();
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

    function test_anti_csrf_token_expire()
    {
        $credential0implement = \castle\credential();
        $token = $credential0implement->_generate_anti_csrf_token('TRobKwZPIecwV6ffeDDMUye7viHUhh5S', 1, 1, 25);

        $result = $credential0implement->_validate_anti_csrf_token('TRobKwZPIecwV6ffeDDMUye7viHUhh5S', 1, 1, $token);
        $this->assertTrue($result[0]);

        sleep(26);

        $result = $credential0implement->_validate_anti_csrf_token('TRobKwZPIecwV6ffeDDMUye7viHUhh5S', 1, 1, $token);
        $this->assertFalse($result[0]);
        $this->assertEquals('expired', $result[1]);
    }

    function test_anti_csrf_token_sleep()
    {
        $credential0implement = \castle\credential();
        $token = $credential0implement->_generate_anti_csrf_token('TRobKwZPIecwV6ffeDDMUye7viHUhh5S', 1, 1, 25);

        $result = $credential0implement->_validate_anti_csrf_token('TRobKwZPIecwV6ffeDDMUye7viHUhh5S', 1, 1, $token);
        $this->assertEquals([true, ''], $result);
        $result = $credential0implement->_validate_anti_csrf_token('TRobKwZPIecwV6ffeDDMUye7viHUhh5S', 1, 1, $token . 'a');
        $this->assertEquals([false, 'invalid token'], $result);
        $result = $credential0implement->_validate_anti_csrf_token('TRobKwZPIecwV6ffeDDMUye7viHUhh5S', 1, 1, 'hagea');
        $this->assertEquals([false, 'invalid token'], $result);
        $result = $credential0implement->_validate_anti_csrf_token('TRobKwZPIecwV6ffeDDMUye7viHUhh5S', 1, 2, $token);
        $this->assertEquals([false, 'invalid token'], $result);
        $result = $credential0implement->_validate_anti_csrf_token('TRobKwZPIecwV6ffeDDMUye7viHUhh5S', 2, 1, $token);
        $this->assertEquals([false, 'invalid token'], $result);
    }

    function test_anti_csrf_token_2()
    {
        $credential0implement = \castle\credential();
        $credential0implement->_user_id = 1;
        $credential0implement->_session_id = 1;
        $credential0implement->_anti_csrf_token_expire = 10;
        $token = $credential0implement->anti_csrf_token();
        $result = $credential0implement->validate_anti_csrf_token($token);
        $this->assertTrue($result);

        $credential0implement->_user_id = 2;
        $credential0implement->_session_id = 1;
        $credential0implement->_anti_csrf_token_expire = 10;
        $result = $credential0implement->validate_anti_csrf_token($token);
        $this->assertFalse($result);

        $credential0implement->_user_id = 1;
        $credential0implement->_session_id = 2;
        $credential0implement->_anti_csrf_token_expire = 10;
        $result = $credential0implement->validate_anti_csrf_token($token);
        $this->assertFalse($result);

        $credential0implement->_user_id = 1;
        $credential0implement->_session_id = 1;
        $credential0implement->_anti_csrf_token_expire = 10;
        $result = $credential0implement->validate_anti_csrf_token($token);
        $this->assertTrue($result);
        sleep(11);
        $result = $credential0implement->validate_anti_csrf_token($token);
        $this->assertFalse($result);
    }

    function test_set_cookie_encrypt()
    {
        global $__vals;
        $cookie_encrypt_key = $__vals['cookie_setting']['encrypt_key'];
        $cookie_name = 'cookie_key_test';
        $cookie_value = 'cookie message';
        $credential0implement = \castle\credential();
        $credential0implement->_is_cookie_encrypted = true;
        $credential0implement->set_cookie($cookie_name, $cookie_value);
        global $__cookies;
        $message = \castle\secret_box_open($__cookies[$cookie_name]['value'], $cookie_encrypt_key);
        $this->assertEquals($cookie_value, $message);
    }

    function test_set_get_cookie_encrypt_array()
    {
        global $__vals;
        $cookie_name = 'cookie_key_test';
        $sending_cookie_value = ['cookie message' => 'hoge'];
        $credential0implement = \castle\credential();
        $credential0implement->_is_cookie_encrypted = true;
        $credential0implement->set_cookie($cookie_name, $sending_cookie_value);
        global $__cookies;
        $processed_cookie_value = $__cookies[$cookie_name]['value'];
        $__vals['captured_cookie_values'][$cookie_name] = $processed_cookie_value;
        $recieved_cookie_value = $credential0implement->get_cookie($cookie_name);
        $this->assertEquals($sending_cookie_value, $recieved_cookie_value);
    }

    function test_set_cookie()
    {
        $cookie_name = 'cookie_key_test';
        $cookie_value = 'cookie message';
        $expire = 100;
        $credential0implement = \castle\credential();
        $credential0implement->set_cookie($cookie_name, $cookie_value, $expire);
        global $__cookies;
        $message = $__cookies[$cookie_name]['value'];
        $expire_actual = $__cookies[$cookie_name]['expires'] - time();
        $this->assertEquals($expire, $expire_actual);
    }

    function test_delete_cookie()
    {
        $cookie_name = 'cookie_key_test';
        $credential0implement = \castle\credential();
        $credential0implement->delete_cookie($cookie_name);
        global $__cookies;
        $delete_sec = $__cookies[$cookie_name]['expires'] - time();
        $this->assertEquals(-$credential0implement::COOKIE_DELETE_SEC, $delete_sec);
    }
}