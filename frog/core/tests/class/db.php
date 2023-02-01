<?php /** @noinspection PhpUnhandledExceptionInspection */

/** @noinspection PhpConditionAlreadyCheckedInspection PhpUnused DuplicatedCode SqlNoDataSourceInspection SqlDialectInspection*/

use function castle\database_implement;

class Test_Class_DB extends TestCase
{

    function test_primary()
    {

        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        DB::query($sql)
            ->execute();

        $sql = <<<EOF
CREATE TABLE `TRADESYSTEM`.`test0field`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key`(`field_1`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;
EOF;
        DB::query($sql)->execute();

        $value_1 = 'hogehoge';
        $value_2 = 'HOGEHOGE';

        $sql = "INSERT INTO `test0field` SET `field_1` = :field_1, `field_2` = :field_2";
        $actual = DB::query($sql)
            ->bind('field_1', $value_1)
            ->bind('field_2', $value_2)
            ->execute(true);
        $this->assertEquals(1, $actual);

        $sql = "SELECT * FROM `test0field` WHERE `field_1` = 'hogehoge';";
        $actual = DB::query($sql)
            ->execute();

        $expect = [
            0 => [
                'id' => 1,
                'field_1' => 'hogehoge',
                'field_2' => 'HOGEHOGE'
            ]
        ];

        $this->assertEquals($expect, $actual);

        $sql = "INSERT INTO `test0field` SET `field_1` = :field_1, `field_2` = :field_2";

        $value_p_1 = 'hoge';
        $value_p_2 = 'hogehoge';

        $actual = DB::query($sql)
            ->param('field_1', $value_p_1)
            ->param('field_2', $value_p_2)
            ->execute(true);
        $this->assertEquals(1, $actual);

        $sql = "INSERT INTO `test0field` SET `field_1` = :field_1, `field_2` = :field_2";

        $params = [
            'field_1'  =>  'frag',
            'field_2'  =>  'fragfrag'
        ];

        $actual = DB::query($sql)
            ->params($params)
            ->execute(true);

        $this->assertEquals(1, $actual);

        $sql = "DELETE FROM `test0field`;";
        $actual =  DB::query($sql)->execute(true);
        $this->assertEquals(3, $actual);

        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        DB::query($sql)->execute();
    }

    function test_quote()
    {
        $test_string = "Co'mpl''ex \"st'\"ring";
        $actual = DB::quote($test_string);
        $expect = <<<EOF
'Co\'mpl\'\'ex \"st\'\"ring'
EOF;
        $this->assertEquals($expect, $actual);
    }

    function test_transaction()
    {

            $sql = <<<EOF
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `order`;
EOF;
            DB::query($sql)->execute();

            $sql = <<<EOF
CREATE TABLE `TRADESYSTEM`.`users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_char` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_int` int(10) NULL DEFAULT NULL,
  `field_float` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key`(`field_char`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;
EOF;
            DB::query($sql)->execute();

            $sql = <<<EOF
            INSERT INTO `TRADESYSTEM`.`users` SET `field_char` = 'key1',`field_int` = 144, `field_float` = 144.0001;
            INSERT INTO `TRADESYSTEM`.`users` SET `field_char` = 'key2',`field_int` = 10, `field_float` = 44.0001;
            INSERT INTO `TRADESYSTEM`.`users` SET `field_char` = 'key3',`field_int` = 20, `field_float` = 4.0001;
            EOF;
            DB::query($sql)
                ->execute();

            $sql = <<<EOF
            CREATE TABLE `TRADESYSTEM`.`order`  (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `field_char` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
              `field_int` int(10) NULL DEFAULT NULL,
              `field_float` double NULL DEFAULT NULL,
              PRIMARY KEY (`id`) USING BTREE,
              UNIQUE INDEX `key`(`field_char`) USING BTREE
            ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;
            EOF;

            DB::query($sql)->execute();

            DB::start_transaction();

            $sql = <<<EOF
            UPDATE `TRADESYSTEM`.`users` SET `field_int` = 100 WHERE field_char = 'key1';
            EOF;
            DB::query($sql)
                ->execute();

            DB::rollback_transaction();

            $sql = <<<EOF
            UPDATE `TRADESYSTEM`.`users` SET `field_int` = 100 WHERE field_char = 'key1';
            EOF;
            $actual = DB::query($sql)
                ->execute();

/*
        $result = $database0implement->find_one_by('users', 'field_char', 'key1')['field_int'];
        $this->assertEquals(144, $result);
        /*
                $database0implement->start_transaction();
                $sql = <<<EOF
        UPDATE `TRADESYSTEM`.`users` SET `field_int` = 100 WHERE field_char = 'key1';
        INSERT `TRADESYSTEM`.`order` SET `field_char` = 'key1', `field_int` = 44;
        EOF;
                $database0implement->query($sql)
                    ->execute();
                $database0implement->commit_transaction();
                $result = $database0implement->find_one_by('users', 'field_char', 'key1')['field_int'];
                $this->assertEquals(100, $result);

                $result = $database0implement->find_one_by('order', 'field_char', 'key1')['field_int'];
                $this->assertEquals(44, $result);

                $sql = <<<EOF
        DROP TABLE IF EXISTS `users`;
        DROP TABLE IF EXISTS `order`;
        EOF;
                $database0implement->query($sql)->execute();*/

    }
}