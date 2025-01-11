<?php /** @noinspection PhpUnused */
namespace castle;

class TableConstraintsManager extends Castle
{
    static public array $internalTableConstraints = [];

    function __construct()
    {
    }

    function getConstraints(string $parentTable)
    {
        return static::$internalTableConstraints[$parentTable] ?? [];
    }

    static function internalSetConstraints(string $parentTable, string $childTable, array $sourceToTargetFields): bool
    {
        if (class_exists($parentTable) === false) {
            return false;
        }
        if (class_exists($childTable) === false) {
            return false;
        }
        static::$internalTableConstraints[$parentTable][$childTable] = $sourceToTargetFields;
        return true;
    }
}