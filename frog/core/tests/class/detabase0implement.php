<?php
class Test_Class_Database0implement extends TestCase
{

    function test_01()
    {
        $database0implement = \castle\database_implement(CSL_DB_INSTANCE_PRIMARY);
        $database0implement->delete('test', 'test_2', 3, '>');
    }

}