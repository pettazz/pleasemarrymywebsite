<?php

    class ContestantModel extends SyrupModel{

        const tableName = 'Contestant';

        protected $uuid = array(SyrupField::VARCHAR, 64, false, NULL, 'PRI', NULL, array('UUID'));
        protected $name = array(SyrupField::VARCHAR, 128);
        protected $alive = array(SyrupField::TINYINT, 1, True, 1);

    }
    
?>