<?php
class Test_Hoge extends TestCase
{
    public function test_hoge1() {
        $records = [
            ['name' => "あさ\"みん\'", 'address' => 'hoge111', 'age' => 2],
            ['name' => 'あさみん1', 'address' => 'hoge2', 'age' => 2],
            ['name' => 'あさみん2', 'address' => 'hoge3', 'age' => 3],
            ['name' => 'あさみん3', 'address' => 'hoge4', 'age' => 4],
            ['name' => 'あさみん4', 'address' => 'hoge5', 'age' => 5],
            ['name' => 'あさみん5', 'address' => 'hoge6', 'age' => 6],
            ['name' => 'あさみん6', 'address' => 'hoge7', 'age' => 7],
            ['name' => 'あさみん7', 'address' => 'hoge8', 'age' => 8],
            ['name' => 'あさみん8', 'address' => 'hoge9', 'age' => 9],
            ['name' => 'あさみん9', 'address' => 'hoge10', 'age' => 10],
            ['name' => 'あさみん10', 'address' => 'hoge11', 'age' => 11]
        ];
        array_walk(
            $records,
            fn($record) =>  \castle\database_implement(0)->store('users', ['name'], $record)
        );
    }

    public function test_hoge2() {
        Db::start_transaction();
        Db::query("INSERT INTO users SET `name` = 'hoge'")->execute();
        Db::commit_transaction();
    }

    public function test_hoge3() {
        $start = microtime(true);
        $length = 0;
        foreach (range(0, 99) AS $value)
        {
            $password = $value . 'hogehoge';
            $hash = sodium_crypto_pwhash_str($password, SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
            if ($length < mb_strlen($hash))
                $length = mb_strlen($hash);
            $this->assertTrue(sodium_crypto_pwhash_str_verify($hash, $password));
            $this->assertFalse(sodium_crypto_pwhash_str_verify($hash, $password . 'a'));
        }
        $end = microtime(true);
        echo ($end - $start) / 100 . 'sec' . PHP_EOL;
        echo $length . 'character' . PHP_EOL;
    }

    public function test_hoge4() {
        echo \castle\database_implement(0)->_update_by_pk_sql('sessions', 2, ['session_id'  => 'hoge']);
    }

}