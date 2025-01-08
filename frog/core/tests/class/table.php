<?php /** @noinspection PhpUnhandledExceptionInspection */

/** @noinspection PhpConditionAlreadyCheckedInspection PhpUnused DuplicatedCode SqlNoDataSourceInspection SqlDialectInspection*/

use function castle\database_implement;

class Test_Class_Table extends RfTestCase
{
    function test_1()
    {

        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        DB::query($sql)
            ->execute();

        $sql = <<<EOF
CREATE TABLE `TRADESYSTEM`.`test0field`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `is_ship` int(11) NOT NULL DEFAULT 1,
  `has_shipping_fee` int(11) NOT NULL DEFAULT 0,
  `amazon_fee_percentage` double NOT NULL DEFAULT 0,
  `amazon_fee_amount` double NOT NULL DEFAULT 0,
  `memo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `product_type`(`product_type`) USING BTREE,
  INDEX `is_ship`(`is_ship`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;
EOF;
        DB::query($sql)->execute();
        $test_table = new class() extends Table {
            protected static ?string $_table_name = 'test0field';
            protected static array $_unique_keys = ['product_type'];
        };

        $test_table::store(
            [
                'product_type' => 'LIP_COLOR',
                'is_ship' => 0,
            ]
        );

        $expect = [
            0 => [
                'id' => 1,
                'product_type' =>  'LIP_COLOR',
                'label' => NULL,
                'is_ship' => 0,
                'has_shipping_fee' => 0,
                'amazon_fee_percentage' => 0.0,
                'amazon_fee_amount' => 0.0,
                'memo' =>  ''
            ]
        ];

        $actual = $test_table::find_by('product_type', 'LIP_COLOR');

        $this->assertEquals($expect, $actual);

        $actual = $test_table::find_by_pk(1);

        $this->assertEquals($expect, $actual);

        $test_table::store_records(
            [
                [
                    'product_type' => 'LIP_YELLOW',
                    'label'  => 'リップ',
                    'is_ship' => 0,
                ],
                [
                    'product_type' => 'FROG_RED',
                    'label'  => '赤のカエル',
                    'is_ship' => 0,
                ],
                [
                    'product_type' => 'FROG_WHITE',
                    'label'  => '白のカエル',
                    'is_ship' => 0,
                ]
            ]
        );

        $actual = count($test_table::find_by('is_ship', 0));

        $this->assertEquals(4, $actual);

        $actual = $test_table::find_one_by('is_ship', 0);

        $expect = [
                'id' => 1,
                'product_type' =>  'LIP_COLOR',
                'label' => NULL,
                'is_ship' => 0,
                'has_shipping_fee' => 0,
                'amazon_fee_percentage' => 0.0,
                'amazon_fee_amount' => 0.0,
                'memo' =>  ''
        ];

        $this->assertEquals($expect, $actual);

        $sql = <<<EOF
DROP TABLE IF EXISTS `test0field`;
EOF;
        DB::query($sql)->execute();
    }

    function testSnakeCase()
    {
        $class_name = 'StudyCaseClassName';
        $result = Table::_convert_to_snake_case($class_name);
        $this->assertEquals('study_case_class_name', $result);
    }
}