<?php
class Test_Hoge extends TestCase
{
    public function test_hoge1()
    {
        echo \castle\secret_box_key_generate();
    }
}