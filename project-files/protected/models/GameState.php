<?php

class GameState extends CActiveRecord {
    
    public function startGame($name = "", $creatorId = 0) {
        $query = "INSERT INTO games (name, playerTurn)
            VALUES (:name, 1)";
        $paramArray = array(":name"=>$name);
        $startGame = Utilities::query($query, $paramArray, "execute");
        $gameId = Utilities::query("SELECT LAST_INSERT_ID()", array(), "scalar");
        
        // insert creator of game's userId as first player in game
        $addPlayerQuery = "INSERT INTO players (playerId, gameId, userId) 
            VALUES (1, :gameId, :userId)";
        $userId = Yii::app()->user->userId;
        $addPlayerParamArray = array(":gameId"=>$gameId, "userId"=>$userId);
        $addPlayer = Utilities::query($addPlayerQuery, 
                $addPlayerParamArray, "execute");
        return $gameId; // return success
    }
    
    public function playCard($card) {
        
    }
    
    public function getPlayersInGame($gameId) {
        $query = "SELECT userId from players 
            WHERE gameId = :gameId";
        $paramArray = array(":gameId"=>$gameId);
        return Utilities::query($query, $paramArray, "column");
    }
    
    public function getGamesList() {
        $query = "SELECT * FROM games 
            WHERE complete = FALSE 
            ORDER BY gameId DESC 
            LIMIT 10";
        return Utilities::query($query, array(), "all");
    }

}
?>