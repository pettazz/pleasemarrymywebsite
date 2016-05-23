<?php

    class EpisodeModel extends SyrupModel{

        const tableName = 'Episode';

        protected $id = array(SyrupField::INT, 2, false, NULL, 'PRI', NULL);
        protected $startTime = array(SyrupField::INT, 10, False);
        protected $teamSize = array(SyrupField::INT, 2, False);
        protected $isPlayoffs = array(SyrupField::TINYINT, 1, True, 0);

    }
    
?>