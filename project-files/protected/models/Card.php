<?php

/**
 * The class describing the Card object. Each card has an animal and a value.
 */
class Card extends CComponent {
    public $animal;
    public $value;
    
    function __construct($animal, $value) {
        $this->animal = $animal;
        $this->value = $value;
    }
}


?>
