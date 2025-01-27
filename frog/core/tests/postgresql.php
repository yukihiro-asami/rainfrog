<?php
class Test_Postgresql extends RfTestCase
{

    function testFirst()
    {
        $connection = 'pgsql:host=localhost;port=5432;dbname=tradesystem;user=postgres;password=R53pmnE3rPRPtAfY';
        $sql = 'SELECT 1';
        $dbh = new PDO($connection);
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;
        print_r($result);
    }
}