<?php

    class OwnershipModel extends SyrupModel{

        const tableName = 'Ownership';

        protected $Team = array(SyrupField::VARCHAR, 64, false, NULL, 'FK', array('hasOne' => 'Team.uuid'));
        protected $Contestant = array(SyrupField::VARCHAR, 64, false, NULL, 'FK', array('hasOne' => 'Contestant.uuid'));
        protected $episode = array(SyrupField::INT, 2, False);

    }
    
?>