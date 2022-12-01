<?php
class Controller_Logout extends Controller
{
    function get_index(string $hoge = ' no param')
    {
        Auth::logout();
        return Response::forge('ok');
    }
}