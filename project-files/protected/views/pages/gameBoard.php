<?php
$animals = array("Lion", "Leopard", "Elephant", "Rhino", "Zebra");
?>



<style type="text/css">
    .row { clear:both; height:110px; }
    .column { float: left; margin-left:20px; }
    .playerName { font-size:30px; }
    img.animal, .card { float:left; }
    .cardValue { font-size: 20px; text-align:center; }
    .currentCard { background:yellow; }
</style>

<input type="hidden" class="currentPlayer" value="1" />

<div class="column remainingFigures">
    <h2>Available Animals</h2>

    <?php foreach ($animals as $animal): ?>
        <div class="row" animal="<?php echo $animal; ?>">
            <?php for ($i = 0; $i < 5; $i++): ?>
                <img class="animal" type="<?php echo $animal; ?>" src="/images/<?php echo $animal; ?>01.jpg" width="100" height="100" />
            <?php endfor; ?>
        </div>
    <?php endforeach; ?>

</div>

<div class="playedCards column">
    <h2>Played Cards</h2>
    <?php foreach ($animals as $animal): ?>
        <div class="row" animal="<?php echo $animal; ?>">

        </div>
    <?php endforeach; ?>
</div>

<div class="poachedAnimals column">
    <h2>Poached Animals</h2>
    <?php for ($i = 1; $i <= $numPlayers; $i++): ?>
        <div class="row" player="<?php echo $i; ?>">
            <div class="playerName"><?php echo $i; ?></div>
        </div>
    <?php endfor; ?>
</div>

<?php for ($playerNum=1; $playerNum<=$numPlayers; $playerNum++): ?>
<div class="playerHand column" player="<?php echo $playerNum; ?>" 
     style="<?php echo ($playerNum!=1) ? "display:none;" : ""; ?>">
    <h2>Player <?php echo $playerNum; ?>'s Hand</h2>
    <div class="cards">
        <?php foreach ($hands[$playerNum-1] as $hand) {
            echo $hand;
        } ?>
    </div>
    <?php //foreach ($hands[0] as $card): ?>
<!--        <div class="card" animal="<?php //echo $card->animal; ?>" 
            price="<?php //echo $card->value; ?>" >
            <div class="cardImage">
                <img class="animal" animal="<?php //echo $card->animal; ?>" 
                     src="/images/<?php //echo $card->animal; ?>01.jpg" 
                     width="50" height="50" />
            </div>
            <div class="cardValue">
                <?php //echo $card->value; ?>
            </div>
        </div>-->
    <?php //endforeach; ?>
    
</div>
<?php endfor; ?>

<div class="row">
    <h2>Game Deck</h2>
    <?php foreach ($deck as $card) {
        echo $card;
    } ?>
</div>


<script type="text/javascript">
    var phase = "playcard"; // turn starts with a player drawing a card
    var players = "<?php echo $numPlayers; ?>";
    var animals = <?php echo json_encode($animals); ?>; // initial animals
    var currentPlayer = 1;
    var gameEnd = false;

    var hands = <?php echo $hands; ?>; // determine player hands
    startTurn(currentPlayer, hands); // begin first turn
    
    $(document).ready(function() {
        $(".playerHand .card").live("click", function() {
            if (phase == "playcard") { // check for correct phase
                var card = $(this);
                var animal = $(this).attr("animal");
                card.remove(); // delete card from hand
                
                var relevantCards = $(".playedCards .row[animal=" + animal + "]").children(".card");
                relevantCards.removeClass("currentCard");
                card.addClass("currentCard");
                card.appendTo($(".playedCards .row[animal=" + animal + "]"));
                if (relevantCards.length + 1>= 6) { // ie. were 5 cards, now 6
                    gameEnd = true;
                }
                phase = "takefigure";
            }
        });
        
        $(".remainingFigures img.animal").live("click", function() {
            if (phase == "takefigure") { // check for correct phase
                $(this).remove(); // delete figure from available animals section
                
                $(this).appendTo($(".poachedAnimals .row[player=" + currentPlayer + "]"));
                if (!gameEnd) {
                    nextTurn();
                    phase = "playcard";
                } else {
                    endGame();
                }
            }
        });
    });
    
    function startTurn(playerNum, hands) {
        $(".playerHand[player=" + currentPlayer + "]").show();
    }
    
    
    function nextTurn() {
        $(".playerHand:visible").hide();
        currentPlayer = getNewPlayerNum(currentPlayer, players);
        startTurn(currentPlayer, hands);
    }
    
    function endGame() {
        phase = "gameover";
        countScore();
        // count score and declare players' points
        alert('game over!');
    }
    
    function getNewPlayerNum(currentPlayerNum, players) {
        return ((currentPlayerNum) % players) + 1;
    }
    
    // Note: need to account for zero cards being in a given row!
    function countScore() {
        var scoreCards = $(".playedCards .card.currentCard");
        var scoreMultipliers = new Array();
        $.each(animals, function(index, animal) {
            animalValue = scoreCards.filter("[animal=" + animal + "]").attr("price");
            if (animalValue == undefined)
                animalValue = 0;
            console.log(animalValue);
            scoreMultipliers[animal] = animalValue;
//            scoreMultipliers.push({ animal:card.attr("animal"), price:card.attr("price") });
//            console.log(card.attr("animal"), card.attr("price"));
//            scoreMultipliers[card.attr("animal")] = card.attr("price");
        });
        console.log(scoreMultipliers['Lion'], scoreMultipliers['Zebra']);
        
        var score = new Array();
//        $.each($(".poachedAnimals .row"), function(player, animals) {
//            console.log(animals);
//            
//        });
    }
</script>