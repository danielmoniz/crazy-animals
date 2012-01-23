<?php

class TestController extends Controller {
    
    public function __construct() {
        
    }
    
    public function actionDan($numPlayers)
    {
        $totalCards = 30;
        $deck = Cards::createDeck();
        if ($numPlayers < 2 || $numPlayers > 4) {
            echo "Too many or too few players.";
            exit;
        }
        $subtractCards = $numPlayers;
        if ($numPlayers == 4)
            $subtractCards = 2;
        $numCards = $totalCards - $subtractCards;
        $hands = Cards::handOutCards($deck, $numCards , $numPlayers);
//        var_dump($deck); exit;
        $this->render('/pages/gameBoard', 
                array('deck'=>$deck, 'hands'=>$hands, 'numPlayers'=>$numPlayers));
    }
    
    public function actionDan2()
    {
        $this->render('/pages/testBoard');
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