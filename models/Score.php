<?php

    class ScoreModel extends SyrupModel{

        const tableName = 'Score';

        protected $Contestant = array(SyrupField::VARCHAR, 64, False, NULL, 'FK', array('hasOne' => 'Contestant.uuid'));
        protected $Action = array(SyrupField::VARCHAR, 64, False, NULL, 'FK', array('hasOne' => 'Action.uuid'));
        protected $Scorer = array(SyrupField::VARCHAR, 64, False, NULL, 'FK', array('hasOne' => 'User.uuid'));
        protected $episode = array(SyrupField::INT, 2, False);

    }
    
?>