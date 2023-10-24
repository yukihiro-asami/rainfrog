<?php /** @noinspection PhpUnused */
namespace castle;
use PHPUnit\phpDocumentor\Reflection\Types\Null_;
use Throwable;

class Credential0implement extends Castle
{
    CONST COOKIE_DELETE_SEC = 3600;
    CONST MAX_PASSWORD_LENGTH = 128;
    CONST DEFAULT_COOKIE_PATH = '/';
    public bool $_logging = false;
    public string $_user_table_name;
    public string $_session_table_name;
    public string $_session_cookie_name;
    public int $_session_rotation_time;
    public string $_session_cookie_expiration_time;
    public bool $_session_match_ip;
    public int $_session_ip_mask;
    public bool $_remember_me_enabled;
    public string $_remember_me_table_name;
    public string $_remember_me_cookie_name;
    public int $_remember_me_expiration;
    public bool $_remember_me_match_ip;
    public bool $_remember_me_match_ip_mask;
    public bool $_is_cookie_encrypted;
    public ?int $_user_id = NULL;
    public ?string $_current_session_token = NULL;
    public ?int $_session_id = NULL;
    public ?array $_remember_me = NULL;
    public ?Database0implement $_database0implement = NULL;
    public ?string $_received_session_token = NULL;
    public ?string $_session_token = NULL;
    public ?string $_ip_address_must_be = NULL;
    public ?string $_user_agent_must_be = NULL;
    public ?string $_received_remember_me_token = NULL;
    public string $_anti_csrf_token_salt;
    public int $_anti_csrf_token_expire;

    function __construct(bool $is_web_access = true)
    {
        if ($is_web_access === false)
            return;
        $this->_logging = static::_credential()['logging'];
        $this->_user_table_name = static::_credential()['user_table_name'];
        $this->_session_table_name = static::_credential()['session_table_name'];
        $this->_session_cookie_name = static::_credential()['session_cookie_name'];
        $this->_session_rotation_time = (int) static::_credential()['session_rotation_time'];
        $this->_session_cookie_expiration_time = static::_credential()['session_cookie_expiration_time'];
        $this->_session_match_ip = static::_credential()['session_match_ip'];
        $this->_session_ip_mask = static::_credential()['session_ip_mask'];
        $this->_is_cookie_encrypted = static::_cookie_setting()['encrypt'];
        $this->_received_session_token = $this->get_cookie($this->_session_cookie_name);
        $this->_database0implement = database_implement(FRG_DB_INSTANCE_PRIMARY);
        $this->_remember_me_enabled = static::_credential()['remember_me_enabled'];
        $this->_remember_me_table_name = static::_credential()['remember_me_table_name'];
        $this->_remember_me_cookie_name = static::_credential()['remember_me_cookie_name'];
        $this->_remember_me_expiration = static::_credential()['remember_me_expiration'];
        $this->_remember_me_match_ip = static::_credential()['remember_me_match_ip'];
        if ($this->_received_session_token !== '')
        {
            $session = $this->_find_session_by_token($this->_received_session_token);
            if (array_key_exists('id', $session) === true)
            {
                $this->_session_id = $session['id'];
                $this->_ip_address_must_be = $session['ip_address'];
                $this->_user_agent_must_be = $session['user_agent'];
                if ((int) $session['is_logged_in'] === 1)
                    $this->_user_id = (int) $session['user_id'];
                if (time() > (int) $session['rotated_at'] + $this->_session_rotation_time)
                {
                    $this->_session_token = generate_token();
                    $params = [
                        'token' => $this->_session_token,
                        'rotated_at' => time()
                    ];
                    $this->_update_session($this->_session_id, $params);
                    $this->set_cookie($this->_session_cookie_name, $this->_session_token, $this->_session_cookie_expiration_time, static::DEFAULT_COOKIE_PATH);
                } else {
                    $this->_session_token = $this->_received_session_token;
                }
            }
        }
        $this->_received_remember_me_token = $this->get_cookie($this->_remember_me_cookie_name);
        $this->_anti_csrf_token_salt = static::_credential()['anti_csrf_token_salt'];
        $this->_anti_csrf_token_expire = static::_credential()['anti_csrf_token_expire'];
    }

    function login(string $user_name = '', string $password = '') : bool
    {
        $user = $this->validate_user($user_name, $password);
        if ($user === false)
        {
            static::_log_info('fail to validate user');
            return false;
        }
        $ip_address = static::_remote_addr();
        $user_agent = static::_user_agent();
        $this->_store_session(
            [
                'token' => $this->_session_token,
                'is_logged_in' => 1,
                'user_id' => $user['id'],
                'user_agent' => $user_agent,
                'ip_address' => $ip_address
            ]
        );
        $this->_user_id = $user['id'];
        return true;
    }

    function logout() : bool
    {
        $this->_store_session(
            [
                'token' => $this->_session_token,
                'is_logged_in' => 0,
                'user_id' => 0,
                'user_agent' => '',
                'ip_address' => ''
            ]
        );
        return true;
    }

    function validate_user(string $user_name = '', string $password = '') : bool|array
    {
        $user = static::_find_user_by_name($user_name);
        if ($user === [])
            return false;
        if (static::_verify_password_hash($user['password_hash'], $password) ===false)
            return false;
        return $user;
    }

    function check() : bool
    {
        if ($this->_check_session() === true)
            return true;
        $this->_log_credential('check session failed');
        if ($this->_check_remember_me() === true)
            return true;
        $this->_log_credential('check remember me failed');
        return false;
    }

    function anti_csrf_token() : string
    {
        return $this->_generate_anti_csrf_token($this->_anti_csrf_token_salt, $this->_user_id, $this->_session_id, $this->_anti_csrf_token_expire);
    }

    function validate_anti_csrf_token(string $token) : bool
    {
        list($is_token_ok, $message) = $this->_validate_anti_csrf_token($this->_anti_csrf_token_salt, $this->_user_id, $this->_session_id, $token);
        if ($is_token_ok === true)
            return true;
        static::_log_info('validate anti csrf token failed:' . $message);
        return false;
    }

    function issue_session_id() : bool
    {
        if ($this->_received_session_token !== ''
            and array_key_exists('id', $this->_find_session_by_token($this->_received_session_token))
        )
            return true;

        $this->_log_credential('session_token: ' . $this->_session_token . ' session_id: ' . $this->_session_id . 'ip_address: ' . static::_remote_addr() . 'path: ' . static::_path());
        $this->_session_token = generate_token();
        $this->set_cookie($this->_session_cookie_name, $this->_session_token, $this->_session_cookie_expiration_time, static::DEFAULT_COOKIE_PATH);
        $params = [
            'token' => $this->_session_token,
            'rotated_at' => time()
        ];
        $this->_store_session($params);

        return true;
    }

    function _generate_anti_csrf_token(string $salt, int $user_id, int $session_id, int $expire) : string
    {
        $nonce = generate_token();
        $expire_at = time() + $expire;
        $token_string = $salt . $nonce . $user_id . $session_id . $expire_at;
        return implode('|', [$nonce, md5($token_string), $expire_at]);
    }

    function _validate_anti_csrf_token(string $salt, int $user_id, int $session_id, string $anti_csrf_token) : array
    {
        list($nonce, $token, $expire_at) = explode('|', $anti_csrf_token);
        if ($expire_at < time())
            return [false, 'expired'];
        $token_must_be = md5($salt . $nonce . $user_id . $session_id . $expire_at);
        if ($token === $token_must_be)
            return [true, ''];
        return [false, 'invalid token'];
    }

    function _check_session() : bool
    {
        return is_int($this->_user_id)
            AND static::_user_agent() === $this->_user_agent_must_be
            AND $this->_is_ip_addresses_identical(static::_remote_addr(), $this->_ip_address_must_be, $this->_session_ip_mask);
    }

    function _check_remember_me() : bool
    {
        if ($this->_received_remember_me_token === '')
        {
            $this->_log_credential('check remember me failed: no remember me token');
            return false;
        }

        $remember_me_info = $this->_find_remember_me_by_token($this->_received_remember_me_token);
        if ($remember_me_info === [])
        {
            $this->_log_credential('check remember me failed: no info stored for rm token');
            return false;
        }
        $ip_address = static::_remote_addr();
        $user_agent = static::_user_agent();
        $this->_store_session(
            [
                'token' => $this->_session_token,
                'is_logged_in' => 1,
                'user_id' => $remember_me_info['user_id'],
                'user_agent' => $user_agent,
                'ip_address' => $ip_address
            ]
        );
        $this->_user_id = $remember_me_info['user_id'];
        return true;
    }

    function get_user_id() : int|bool
    {
        return is_int($this->_user_id) ? $this->_user_id : false;
    }

    function remember_me() : bool
    {
        if ($this->_remember_me_enabled === false)
            return false;
        if ($this->_user_id === NULL)
            return false;
        $token = generate_token();
        $this->set_cookie($this->_remember_me_cookie_name, $token, $this->_remember_me_expiration, static::DEFAULT_COOKIE_PATH);
        $this->_store_remember_me($token, $this->_user_id, static::_remote_addr(), static::_user_agent());
        return true;
    }

    function set_cookie(string $cookie_name, array|string $value, int $expiration = 3600, string $path = '', string $domain = '') : bool
    {
        $value = is_array($value) ? json_encode($value) : $value;
        if ($this->_is_cookie_encrypted === true)
            $value = secret_box($value, static::_cookie_setting()['encrypt_key']);
        store_cookie($cookie_name, $value, time() + $expiration, $path, $domain);
        return true;
    }

    function get_cookie(string $cookie_name) : array|string
    {
        $cookie_value = array_key_exists($cookie_name, static::_captured_cookie_values()) ? static::_captured_cookie_values()[$cookie_name] : '';
        $cookie_value = $this->_is_cookie_encrypted ? secret_box_open($cookie_value, static::_cookie_setting()['encrypt_key']) : $cookie_value;
        return json_decode($cookie_value, true) ?? $cookie_value;
    }

    function delete_cookie(string $cookie_name) : bool
    {
        store_cookie($cookie_name, '', time() - static::COOKIE_DELETE_SEC);
        return true;
    }

    function delete_session_data() : bool
    {
        database_implement(FRG_DB_INSTANCE_PRIMARY)
            ->delete($this->_session_table_name, 'rotated_at', time() - $this->_session_cookie_expiration_time, '<');
        return true;
    }

    function _is_ip_addresses_identical(string $ip_address_1, string $is_address_2, int $mask) : bool
    {
        $ip_address_int_1 = ip2long($ip_address_1);
        $ip_address_int_2 = ip2long($is_address_2);
        if (is_int($ip_address_int_1) AND is_int($ip_address_int_2))
        {
            $ip_address_int_1_shifted = $ip_address_int_1 >> (32 - $mask);
            $is_address_int_2_shifted = $ip_address_int_2 >> (32 - $mask);
            return $ip_address_int_1_shifted === $is_address_int_2_shifted;
        } else {
            return false;
        }
    }

    function _update_user(int $id, array $fields)
    {
        $this->_database0implement
            ->update_by_key($this->_user_table_name, $id, $fields);
    }

    function store_user(array $params) : void
    {
        $this->_database0implement
            ->store(
                $this->_user_table_name,
                ['name'],
                $params
            );
    }

    function _find_user_by_name(string $name) : array
    {
        return database_implement(FRG_DB_INSTANCE_PRIMARY)
            ->find_one_by($this->_user_table_name, 'name', $name);
    }

    function _find_session_by_token(string $session_token) : array
    {
        return database_implement(FRG_DB_INSTANCE_PRIMARY)
            ->find_one_by($this->_session_table_name, 'token', $session_token);
    }

    function _update_session(int $id, array $fields)
    {
        $this->_database0implement
            ->update_by_key($this->_session_table_name, $id, $fields);
    }

    function _store_session(array $params) : void
    {
        $this->_database0implement
            ->store(
                $this->_session_table_name,
                ['token'],
                $params
            );
    }

    function _find_remember_me_by_token(string $remember_me_token) : array
    {
        return database_implement(FRG_DB_INSTANCE_PRIMARY)
            ->find_one_by($this->_remember_me_table_name, 'token', $remember_me_token);
    }

    function _store_remember_me(string $token, int $user_id, string $ip_address, string $user_agent) : void
    {
        $this->_database0implement
            ->store(
                $this->_remember_me_table_name,
                ['token'],
                [
                    'token' => $token,
                    'user_id' => $user_id,
                    'ip_address' => $ip_address,
                    'created_at_int' => time(),
                    'user_agent' => $user_agent
                ]
            );
    }

    function password_hash(string $password) : string|bool
    {
        if (mb_check_encoding($password, 'ASCII') === false)
            return false;
        if (strlen($password) > self::MAX_PASSWORD_LENGTH)
            return false;
        try
        {
            return sodium_crypto_pwhash_str($password, SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
        } catch (Throwable $t) {
            static::_log_info($t);
            return false;
        }
    }

    function _verify_password_hash(string $hash, string $password) : bool
    {
        try
        {
            return sodium_crypto_pwhash_str_verify($hash, $password);
        } catch (Throwable $t) {
            static::_log_info($t);
            return false;
        }
    }

    function _log_credential(string $message) : void
    {
        if ($this->_logging === false)
            return;
        static::_log_info($message);
    }
}