<?php
class Controller_Operation extends Controller
{
    function get_index(string $hoge = ' no param')
    {
        $result_of_check = Auth::check();
        $result_of_check = $result_of_check ? 'true' : 'false';
        $token =Input::params('token');
        $result_of_token_validation = Auth::validate_anti_csrf_token($token) ? 'true' : 'false';
        return Response::forge(
            View::forge($this->_view_filename,
            [
                'result_of_check' => $result_of_check,
                'token' => $token,
                'result_of_token_validation' => $result_of_token_validation,
            ]
            )
        );
    }
}