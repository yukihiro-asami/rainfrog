<?php /** @noinspection PhpConditionAlreadyCheckedInspection PhpUnused DuplicatedCode SqlNoDataSourceInspection SqlDialectInspection*/

use function castle\database_implement;

class Test_Class_Database0implement extends TestCase
{
    function test_primary()
    {
        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        $database0implement = database_implement(FRG_DB_INSTANCE_PRIMARY);
        $database0implement->query($sql)->execute();

        $sql = <<<EOF
CREATE TABLE `TRADESYSTEM`.`test0field`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_2` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key`(`field_1`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;
EOF;
        $database0implement->query($sql)->execute();
        $database0implement->store('test0field', ['field_1'], ['field_1' => 'rainfrog', 'field_2' => '雨蛙 primary']);

        $actual = $database0implement->find_by('test0field', 'field_1', 'rainfrog');
        $expect = [['id' => 1, 'field_1' => 'rainfrog', 'field_2' => '雨蛙 primary']];
        $this->assertEquals($expect, $actual);

        $actual = $database0implement->find_one_by('test0field', 'field_1', 'rainfrog');
        $expect = ['id' => 1, 'field_1' => 'rainfrog', 'field_2' => '雨蛙 primary'];
        $this->assertEquals($expect, $actual);

        $database0implement->store('test0field', ['field_1'], ['field_1' => 'rainfrog', 'field_2' => "\n\""]);
        $actual = $database0implement->find_one_by('test0field', 'field_1', 'rainfrog');
        $expect = ['id' => 1, 'field_1' => 'rainfrog', 'field_2' => "\n\""];
        $this->assertEquals($expect, $actual);


        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        $database0implement->query($sql)->execute();
    }

    function test_secondary()
    {
        $database_implement_id = FRG_DB_INSTANCE_SECONDARY;
        $database0implement = database_implement($database_implement_id);
        if (isset($database0implement) === false)
        {
            echo 'no second db instance';
            return;
        }

        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        $database0implement->query($sql)->execute();

        $sql = <<<EOF
CREATE TABLE `TRADESYSTEM`.`test0field`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_2` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key`(`field_1`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;
EOF;
        $database0implement->query($sql)->execute();
        $database0implement->store('test0field', ['field_1'], ['field_1' => 'rainfrog', 'field_2' => '雨蛙 secondary']);

        $actual = $database0implement->find_by('test0field', 'field_1', 'rainfrog');
        $expect = [['id' => 1, 'field_1' => 'rainfrog', 'field_2' => '雨蛙 secondary']];
        $this->assertEquals($expect, $actual);

        $actual = $database0implement->find_one_by('test0field', 'field_1', 'rainfrog');
        $expect = ['id' => 1, 'field_1' => 'rainfrog', 'field_2' => '雨蛙 secondary'];
        $this->assertEquals($expect, $actual);

        $database0implement->store('test0field', ['field_1'], ['field_1' => 'rainfrog', 'field_2' => "\n\""]);
        $actual = $database0implement->find_one_by('test0field', 'field_1', 'rainfrog');
        $expect = ['id' => 1, 'field_1' => 'rainfrog', 'field_2' => "\n\""];
        $this->assertEquals($expect, $actual);

        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        $database0implement->query($sql)->execute();
    }


    function test_third()
    {
        $database_implement_id = FRG_DB_INSTANCE_TERTIARY;
        $database0implement = database_implement($database_implement_id);
        if (isset($database0implement) === false)
        {
            echo 'no 3ed db instance';
            return;
        }
        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        $database0implement->query($sql)->execute();
        $sql = <<<EOF
CREATE TABLE `TRADESYSTEM`.`test0field`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_2` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key`(`field_1`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;
EOF;
        $database0implement->query($sql)->execute();
        $database0implement->store('test0field', ['field_1'], ['field_1' => 'rainfrog', 'field_2' => '雨蛙 tertiary']);

        $actual = $database0implement->find_by('test0field', 'field_1', 'rainfrog');
        $expect = [['id' => 1, 'field_1' => 'rainfrog', 'field_2' => '雨蛙 tertiary']];
        $this->assertEquals($expect, $actual);

        $actual = $database0implement->find_one_by('test0field', 'field_1', 'rainfrog');
        $expect = ['id' => 1, 'field_1' => 'rainfrog', 'field_2' => '雨蛙 tertiary'];
        $this->assertEquals($expect, $actual);

        $database0implement->store('test0field', ['field_1'], ['field_1' => 'rainfrog', 'field_2' => "\n\""]);
        $actual = $database0implement->find_one_by('test0field', 'field_1', 'rainfrog');
        $expect = ['id' => 1, 'field_1' => 'rainfrog', 'field_2' => "\n\""];
        $this->assertEquals($expect, $actual);

        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        $database0implement->query($sql)->execute();
    }

    function test_quaternary()
    {
        $database_implement_id = FRG_DB_INSTANCE_QUATERNARY;
        $database0implement = database_implement($database_implement_id);
        if (isset($database0implement) === false)
        {
            echo 'no 3ed db instance';
            return;
        }
        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        $database0implement->query($sql)->execute();

        $sql = <<<EOF
CREATE TABLE `TRADESYSTEM`.`test0field`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_2` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key`(`field_1`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;
EOF;
        $database0implement->query($sql)->execute();
        $database0implement->store('test0field', ['field_1'], ['field_1' => 'rainfrog', 'field_2' => '雨蛙 quaternary']);

        $actual = $database0implement->find_by('test0field', 'field_1', 'rainfrog');
        $expect = [['id' => 1, 'field_1' => 'rainfrog', 'field_2' => '雨蛙 quaternary']];
        $this->assertEquals($expect, $actual);

        $actual = $database0implement->find_one_by('test0field', 'field_1', 'rainfrog');
        $expect = ['id' => 1, 'field_1' => 'rainfrog', 'field_2' => '雨蛙 quaternary'];
        $this->assertEquals($expect, $actual);

        $database0implement->store('test0field', ['field_1'], ['field_1' => 'rainfrog', 'field_2' => "\n\""]);
        $actual = $database0implement->find_one_by('test0field', 'field_1', 'rainfrog');
        $expect = ['id' => 1, 'field_1' => 'rainfrog', 'field_2' => "\n\""];
        $this->assertEquals($expect, $actual);

        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        $database0implement->query($sql)->execute();
    }

    function test_bind_param_params_quote()
    {
        foreach ([FRG_DB_INSTANCE_PRIMARY, FRG_DB_INSTANCE_SECONDARY, FRG_DB_INSTANCE_TERTIARY, FRG_DB_INSTANCE_QUATERNARY] as $database_implement_id)
        {
            $database0implement = database_implement($database_implement_id);

            $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
            $database0implement->query($sql)->execute();

            $sql = <<<EOF
CREATE TABLE `TRADESYSTEM`.`test0field`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_char` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_int` int(10) NULL DEFAULT NULL,
  `field_float` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key`(`field_char`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;
EOF;
            $database0implement->query($sql)->execute();

            $char_value = '文字列string';
            $field_int = 126;
            $field_float = 123.555543;

            $sql = <<<EOF
INSERT INTO `TRADESYSTEM`.`test0field` SET field_char = :char_value,`field_int` = :int_value, `field_float` = :float_value
EOF;
            $database0implement->query($sql)
                ->bind('char_value', $char_value)
                ->bind('int_value', $field_int)
                ->bind('float_value', $field_float)
                ->execute();

            $actual = $database0implement->find_by('test0field', 'field_char', $char_value);
            $expect = [
                0 =>
                    [
                        'id' => 1,
                        'field_char' => '文字列string',
                        'field_int' => 126,
                        'field_float' => 123.555543
                    ]
            ];
            $this->assertEquals($expect, $actual);

            $char_value = 'key1';
            $field_int = 128;
            $field_float = 3.0000003;

            $sql = <<<EOF
INSERT INTO `TRADESYSTEM`.`test0field` SET field_char = :char_value,`field_int` = :int_value, `field_float` = :float_value
EOF;
            $database0implement->query($sql)
                ->param('char_value', $char_value)
                ->param('int_value', $field_int)
                ->param('float_value', $field_float)
                ->execute();

            $actual = $database0implement->find_by('test0field', 'field_char', $char_value);
            $expect = [
                0 =>
                    [
                        'id' => 2,
                        'field_char' => 'key1',
                        'field_int' => 128,
                        'field_float' => 3.0000003
                    ]
            ];
            $this->assertEquals($expect, $actual);

            $char_value = 'key2';
            $field_int = 128000;
            $field_float = 314.0000003;

            $params = ['char_value' => $char_value,
            'int_value' => $field_int,
            'float_value' => $field_float];

            $sql = <<<EOF
INSERT INTO `TRADESYSTEM`.`test0field` SET field_char = :char_value,`field_int` = :int_value, `field_float` = :float_value
EOF;
            $database0implement->query($sql)
                ->params($params)
                ->execute();

            $actual = $database0implement->find_by('test0field', 'field_char', $char_value);
            $expect = [
                0 =>
                    [
                        'id' => 3,
                        'field_char' => 'key2',
                        'field_int' => 128000,
                        'field_float' => 314.0000003
                    ]
            ];
            $this->assertEquals($expect, $actual);

            $test_string = "Co'mpl''ex \"st'\"ring";
            $actual = $database0implement->quote($test_string);
            $expect = <<<EOF
'Co\'mpl\'\'ex \"st\'\"ring'
EOF;
            $this->assertEquals($expect, $actual);

            $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
            $database0implement->query($sql)->execute();
        }
    }
}