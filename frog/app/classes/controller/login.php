<?php
class Controller_Login extends Controller
{
    function get_index(string $hoge = ' no param')
    {
        Auth::login('hogehoge', 'hoge1234');
        global $__credential;
        $__credential->remember_me();
        return Response::forge('ok');
    }
}