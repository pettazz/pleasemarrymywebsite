<?php

    class ActionModel extends SyrupModel{

        const tableName = 'Action';

        protected $uuid = array(SyrupField::VARCHAR, 64, false, NULL, 'PRI', NULL, array('UUID'));
        protected $name = array(SyrupField::VARCHAR, 127);
        protected $description = array(SyrupField::VARCHAR, 255, True);
        protected $value = array(SyrupField::INT, 2, False);
        protected $tag = array(SyrupField::ENUM, "ENUM('ACTION','CONVERSATION','FUCKERY','NEGATIVE','HOMETOWNS','FANTASY_SUITE','FINALE')", false, 'ACTION');

    }
    
?>