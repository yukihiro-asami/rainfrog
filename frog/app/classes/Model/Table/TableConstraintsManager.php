<?php

namespace Model\Table;
class TableConstraintsManager extends \TableConstraintsManager
{
    function __construct()
    {
        static::internalSetConstraints('\Model\Table\Users', '\Model\Table\UserSettings', ['id' => 'user_id']);
        parent::__construct();
    }
}