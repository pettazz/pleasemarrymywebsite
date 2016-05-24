<?php
    
  // because I'm too lazy to make this a legit module

  class Bach{
    private $jacked;

    public function __construct($JACKED){
      $this->jacked = $JACKED;
      $this->jacked->loadDependencies(array('Syrup', 'MySQL'));
    }

    public function getCurrentEpisode(){
      $now = time();
      return $this->jacked->Syrup->Episode->findOne(array('startTime > ?' => $now), array('field' => 'id', 'direction' => 'ASC'));
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
        usort($res, function($a, $b){
          if($a['score'] < $b['score']){
            return -1;
          }else if($a['score'] > $b['score']){
            return 0;
          }else{
            return 1;
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

    public function getScoresForContestant($contestant){
      return $this->jacked->Syrup->Score->find(array('Contestant' => $contestant));
    }

    public function getTeams($ordered = 'alpha'){
      $res = array();
      $teams = $this->jacked->Syrup->Team->find();
      foreach($teams as $team){
        $score = $this->getScoreForTeam($team->uuid);
        $res[$team->uuid] = array('team' => $team, 'score' => $score);
      }

      if($ordered == 'rank'){
        usort($res, function($a, $b){
          if($a['score'] < $b['score']){
            return -1;
          }else if($a['score'] > $b['score']){
            return 0;
          }else{
            return 1;
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

  }

?>