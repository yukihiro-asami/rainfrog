<?php /** @noinspection SqlNoDataSourceInspection */

class Test_Class_Database0implement extends TestCase
{
    function test_primary()
    {
        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        $database0implement = \castle\database_implement(FRG_DB_INSTANCE_PRIMARY);
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
        $database0implement = \castle\database_implement($database_implement_id);
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
        $database0implement = \castle\database_implement($database_implement_id);
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
        $database0implement = \castle\database_implement($database_implement_id);
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

    function test_bind()
    {

    }
}