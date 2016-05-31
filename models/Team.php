<?php

    class TeamModel extends SyrupModel{

        const tableName = 'Team';

        protected $uuid = array(SyrupField::VARCHAR, 64, false, NULL, 'PRI', NULL, array('UUID'));
        protected $Owner = array(SyrupField::VARCHAR, 64, false, NULL, 'FK', array('hasOne' => 'User.guid'));
        protected $name = array(SyrupField::VARCHAR, 255);
        protected $avatar = array(SyrupField::VARCHAR, 255, true, NULL);

    }
    
?>