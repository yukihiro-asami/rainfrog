<?php
class Test_Postgresql extends RfTestCase
{

    function testFirst()
    {
        $connection = 'pgsql:host=localhost;port=5432;dbname=rainfrog;user=postgres;password=0HJZBK2VsFce4tDV';
        $sql = 'SELECT 1';
        $dbh = new PDO($connection);
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;
        print_r($result);
    }
}