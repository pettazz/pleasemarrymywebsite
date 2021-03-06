<?php
    
  // because I'm too lazy to make this a legit module

  class Bach{
    private $jacked;

    public function __construct($JACKED){
      $this->jacked = $JACKED;
      $this->jacked->loadDependencies(array('Syrup', 'MySQL', 'Sessions'));
    }

    public function getLatestEpisodeID(){
      $query = "SELECT MAX(id) AS id FROM Episode";
      $result = $this->jacked->MySQL->query($query);
      if($result){
        if($result[0]['id'] > 0){
          return $result[0]['id'];
        }else{
          return 1;
        }
      }else{
        return 1;
      }
    }

    public function getLatestEpisode(){
      $epid = $this->getLatestEpisodeID();
      return $this->jacked->Syrup->Episode->findOne(array('id = ?' => $epid), array('field' => 'id', 'direction' => 'ASC'));
    }

    public function getContestants($ordered = 'alpha', $aliveOnly = False){
      if($aliveOnly){
        $where = array('alive' => '1');
      }else{
        $where = NULL;
      }

      $res = array();
      $contestants = $this->jacked->Syrup->Contestant->find($where, array('field' => 'name', 'direction' => 'ASC'));
      foreach($contestants as $contestant){
        $score = $this->getScoreForContestant($contestant->uuid);
        $res[$contestant->uuid] = array('contestant' => $contestant, 'score' => $score);
      }

      if($ordered == 'rank'){
        uasort($res, function($a, $b){
          if($a['score'] < $b['score']){
            return 1;
          }else if($a['score'] > $b['score']){
            return -1;
          }else{
            return 0;
          }
        });
      }

      return $res;
    }

    public function getScoreForContestant($contestant){
      $query = "SELECT SUM(Action.value) AS score FROM Action, Score WHERE Score.Contestant = '" . $contestant . "' AND Action.uuid = Score.Action";
      $result = $this->jacked->MySQL->query($query);
      if($result){
        if($result[0]['score'] > 0){
          return $result[0]['score'];
        }else{
          return 0;
        }
      }else{
        return 0;
      }
    }

    public function getScoreForContestantByEpisode($contestant, $episode){
      $query = "SELECT SUM(Action.value) AS score FROM Action, Score WHERE 
        Score.Contestant = '" . $contestant . "' AND 
        Score.episode = " . $episode . " AND
        Action.uuid = Score.Action";
      $result = $this->jacked->MySQL->query($query);
      if($result){
        if($result[0]['score'] > 0){
          return $result[0]['score'];
        }else{
          return 0;
        }
      }else{
        return 0;
      }
    }

    public function getScoresForContestant($contestant, $ordered = False){
      if($ordered && $ordered == 'episode'){
        $order = array('field' => 'episode', 'direction' => 'DESC');
      }
      return $this->jacked->Syrup->Score->find(array('Contestant' => $contestant), $order);
    }

    public function getTeams($ordered = 'alpha'){
      $res = array();
      $teams = $this->jacked->Syrup->Team->find();
      foreach($teams as $team){
        $score = $this->getScoreForTeam($team->uuid);
        $res[$team->uuid] = array('team' => $team, 'score' => $score);
      }

      if($ordered == 'rank'){
        uasort($res, function($a, $b){
          if($a['score'] < $b['score']){
            return 1;
          }else if($a['score'] > $b['score']){
            return -1;
          }else{
            return 0;
          }
        });
      }

      return $res;
    }

    public function getScoreForTeam($team){
      $query = "SELECT SUM(Action.value) AS score FROM Ownership, Action, Score WHERE 
        Ownership.Team = '" . $team . "' AND
        Score.Contestant = Ownership.Contestant AND
        Score.episode = Ownership.episode AND
        Action.uuid = Score.Action";

      $result = $this->jacked->MySQL->query($query);
      if($result){
        if($result[0]['score'] > 0){
          return $result[0]['score'];
        }else{
          return 0;
        }
      }else{
        return 0;
      }
    }

    public function getScoreForTeamByEpisode($team, $episode){
      $query = "SELECT SUM(Action.value) AS score FROM Ownership, Action, Score WHERE 
        Ownership.Team = '" . $team . "' AND
        Score.Contestant = Ownership.Contestant AND
        Score.episode = " . $episode . " AND
        Score.episode = Ownership.episode AND
        Action.uuid = Score.Action";

      $result = $this->jacked->MySQL->query($query);
      if($result){
        if($result[0]['score'] > 0){
          return $result[0]['score'];
        }else{
          return 0;
        }
      }else{
        return 0;
      }
    }

    public function getAvailableContestantsForEpisode($episode){
      $me = $this->jacked->Flock->getUserSession();
      $meID = $me['userid'];
      $myTeam = $this->jacked->Syrup->Team->findOne(array('Owner' => $meID));
      $res = $this->jacked->Syrup->Contestant->find(array('AND' => array(
        'alive' => 1,
        'uuid NOT IN (SELECT Contestant FROM Ownership WHERE episode = ? AND Team = "' . $myTeam->uuid . '")' => $episode,
        'uuid NOT IN (SELECT Contestant FROM Ownership WHERE episode = ? AND Team = "' . $myTeam->uuid . '" GROUP BY Contestant HAVING COUNT(uuid) >= 2)' => $episode,
        'uuid NOT IN (SELECT Contestant FROM Ownership WHERE episode = ? AND Team <> "' . $myTeam->uuid . '" GROUP BY Contestant HAVING COUNT(uuid) >= 2)' => $episode - 1
      )), array('field' => 'name', 'direction' => 'ASC'));
      return $res;
    }

    public function isTeamInLastPlace($team){
      $teams = $this->getTeams('rank');
      return array_search($team, array_keys($teams)) == count($teams) - 1;
    }

  }

?>