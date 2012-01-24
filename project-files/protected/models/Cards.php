<?php

/**
 * The model that deals with Card objects.
 */
class Cards extends CComponent {
    
    /**
     * Create a a deck (array) of Card objects using the total number of 
     * players and the number of cards to be subtracted.
     * @TODO Use the number of players to determine how many cards are 
     * to be subtracted HERE, rather than in the controller.
     * @param $numPlayers The number of players in the game.
     * @param $subtractCards The number of cards to be removed from the deck.
     * @return Return a shuffled deck of Card objects to be used in the game.
     * @TODO The deck probably need not be shuffled immediately.
     */
    public function createDeck($numPlayers = 3, $subtractCards = 2) {
        $animals = array("Lion", "Leopard", "Elephant", "Rhino", "Zebra");
        $deck = array();
        foreach ($animals as $animal) {
            for ($i=0; $i<=5; $i++) {
                $deck[] = new Card($animal, $i);
            }
        }
        // discard the correct number of cards at random from the deck.
        /* @TODO If the deck is shuffled first, the first three cards 
         * can be discarded instead of pulling them randomly. */
        $discards = array_rand($deck, $subtractCards);
        foreach ($discards as $discard) {
            array_splice($deck, $discard, 1);
        }
        
        shuffle($deck);
        
        return $deck;
    }
    
    /**
     * Get a list of hands for each player. 
     * NOTE: The hands will not be equal if the number of players does not 
     * divide the number of cards!
     * @param array $deck The deck of cards to be used in the game.
     * @param int $numCards The number of cards to be used.
     * @TODO Generate $numCards from $deck! Use sizeof().
     * @param $numPlayers The number of players in the game.
     * @return array A list of arrays, representing hands of cards.
     */
    public function handOutCards($deck, $numCards, $numPlayers = 3) {
//        var_dump(sizeof($deck), $numCards, $numPlayers, $numCards/$numPlayers); exit;
        return array_chunk($deck, $numCards/$numPlayers);
    }
}


?>
