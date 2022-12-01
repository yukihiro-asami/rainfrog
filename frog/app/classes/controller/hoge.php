<?php
class Controller_Hoge extends Controller
{
    function get_index(string $hoge = ' no param')
    {
        $result_of_check = Auth::check();
        $result_of_check = $result_of_check ? 'true' : 'false';
        $token = Auth::anti_csrf_token();
        return Response::forge(
            View::forge($this->_view_filename,
            [
                'result_of_check' => $result_of_check,
                'token' => $token
            ]
            )
        );
    }
}