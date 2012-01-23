<?php

/**
 * The model that deals with Card objects.
 */
class Cards extends CComponent {
    
    public function createDeck($numPlayers = 3) {
        $animals = array("Lion", "Leopard", "Elephant", "Rhino", "Zebra");
        $deck = array();
        foreach ($animals as $animal) {
            for ($i=0; $i<=5; $i++) {
                $deck[] = new Card($animal, $i);
            }
        }
        
        $discards = array_rand($deck, $numPlayers);
        foreach ($discards as $discard) {
            array_splice($deck, $discard, 1);
        }
//        var_dump(sizeof($deck)); exit;
        shuffle($deck);
        
        return $deck;
    }
    
    public function handOutCards($deck, $totalCards, $numPlayers = 3) {
        return array_chunk($deck, $totalCards/$numPlayers);
    }
}


?>
