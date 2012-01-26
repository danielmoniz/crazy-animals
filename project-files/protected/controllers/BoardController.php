<?php

class BoardController extends Controller {
    
    public function __construct() {
        
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