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

}