<?php

class BoardController extends Controller {
    
    public function __construct() {
        
    }
    
    public function actionLounge() {
        $this->render("/pages/lounge");
    }
    
    public function actionLobby($newGame = false, $gameId = null) {
        $gameId = GameState::startGame();
//        var_dump($newGame, $gameId); exit;
        $this->render("/pages/lobby", array("newGame"=>$newGame, "gameId"=>$gameId));
    }
    
    /**
     * This controller grabs the number of players from the 
     * URL and establishes a deck and set of hands to play with. 
     * It then calls the correct subviews and sends them to the 
     * pages/gameBoard view.
     */
    public function actionPlay($numPlayers = 2)
    {
        $totalCards = 30;
        $subtractCards = $numPlayers;
        if ($numPlayers == 4)
            $subtractCards = 2;
        $numCards = $totalCards - $subtractCards;
        
        if ($numPlayers < 2 || $numPlayers > 4) {
            echo "Too many or too few players.";
            exit;
        }
        
        $cards = Cards::createDeck($numPlayers, $subtractCards);
        $deck = array();
        foreach ($cards as $card) {
            $deck[] = $this->renderPartial('/gamePieces/card', 
                    array('card'=>$card), true);
        }

        $hands = Cards::handOutCards($deck, $numCards, $numPlayers);

        
        $this->render('/pages/gameBoard', 
                array('deck'=>$deck, 'hands'=>$hands, 'numPlayers'=>$numPlayers));
    }
    
    public function actionPlayCard() {
//        var_dump("test"); exit;
        $animal = $_POST['animal'];
        $value = $_POST['value'];
        $cardPlayed = new Card($animal, $value);
        var_dump($cardPlayed); exit;
    }
    
    public function actionTakeAnimal() {
        $animal = $_POST['animal'];
        $player = $_POST['player'];
        var_dump($animal, $player); exit;
    }
    
    public function actionGetPlayers() {
        $gameId = $_POST['gameId'];
        $players = GameState::getPlayersInGame($gameId);
//        var_dump($gameId, $players); exit;
        $playerBlock = $this->renderPartial("/blocks/playerList", 
                array("players"=>$players), true);
        echo $playerBlock;
    }

    // PERMISSIONS CODE---------------------------------------
    /**
     * Returns a list of access control functions (??) or something.
     * @return array An array containing a list of access control functions (??)
     */
//    public function filters() {
//        return array('accessControl');
//    }

    /**
     * Returns an array of arrays that contains controller-wide access controls.
     * @return Array An array of arrays containing permissions.
     */
//    public function accessRules() {
//        return array(
//            array('allow',
//                'roles'=>array('Admin'),
//            ),
//            array(
//                'deny',
//            ),
//        );
//    }
    // --------------------------------------------------------
    
}

?>