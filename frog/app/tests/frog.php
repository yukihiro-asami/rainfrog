<?php
class Tests_Castle extends TestCase
{
    public function test_hoge1()
    {
        Auth::issue_session_id();
    }
}