<?php

/**
 * The model that deals with Card objects.
 */
class Cards extends CComponent {
    
    public function createDeck($numPlayers = 3, $subtractCards = 2) {
        $animals = array("Lion", "Leopard", "Elephant", "Rhino", "Zebra");
        $deck = array();
        foreach ($animals as $animal) {
            for ($i=0; $i<=5; $i++) {
                $deck[] = new Card($animal, $i);
            }
        }
        
        $discards = array_rand($deck, $subtractCards);
        foreach ($discards as $discard) {
            array_splice($deck, $discard, 1);
        }
//        var_dump(sizeof($deck)); exit;
        shuffle($deck);
        
        return $deck;
    }
    
    public function handOutCards($deck, $numCards, $numPlayers = 3) {
//        var_dump(sizeof($deck), $numCards, $numPlayers, $numCards/$numPlayers); exit;
        return array_chunk($deck, $numCards/$numPlayers);
    }
}


?>
