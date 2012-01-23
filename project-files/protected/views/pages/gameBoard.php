<?php
$animals = array("Lion", "Leopard", "Elephant", "Rhino", "Zebra");
?>



<style type="text/css">
    .row { clear:both; height:110px; }
    .column { float: left; margin-left:20px; }
    .playerName { font-size:30px; }
    img.animal, .card { float:left; }
    .card { border:1px black solid; }
    .cardValue { font-size: 20px; text-align:center; }
</style>

<input type="hidden" class="currentPlayer" value="1" />

<div class="column remainingFigures">
    <h2>Available Animals</h2>

    <?php foreach ($animals as $animal): ?>
        <div class="row">
            <?php for ($i = 0; $i < 5; $i++): ?>
                <img class="animal" type="<?php echo $animal; ?>" src="/images/<?php echo $animal; ?>01.jpg" width="100" height="100" />
            <?php endfor; ?>
        </div>
    <?php endforeach; ?>

</div>

<div class="poachedAnimals column">
    <h2>Poached Animals</h2>
    <?php for ($i=1; $i<=$numPlayers; $i++): ?>
    <div class="row" player="<?php echo $i; ?>">
        <div class="playerName"><?php echo $i; ?></div>
    </div>
    <?php endfor; ?>
</div>

<div class="playerHand column">
    <h2>Player 1's Hand</h2>
    <?php foreach ($hands[0] as $card): ?>
        <div class="card">
            <div class="cardImage">
                <img class="animal" price="<?php echo $card->animal; ?>" 
                     src="/images/<?php echo $card->animal; ?>01.jpg" 
                     width="50" height="50" />
            </div>
            <div class="cardValue">
                <?php echo $card->value; ?>
            </div>
        </div>
    <?php endforeach; ?>
    
</div>

<div class="row">
    <h2>Game Deck</h2>
    <?php foreach ($deck as $card): ?>
        <div class="card">
            <div class="cardImage">
                <img class="animal" price="<?php echo $card->animal; ?>" 
                     src="/images/<?php echo $card->animal; ?>01.jpg" 
                     width="50" height="50" />
            </div>
            <div class="cardValue">
                <?php echo $card->value; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        var phase = "playcard"; // turn starts with a player drawing a card
        var players = "<?php echo $numPlayers; ?>";
        var currentPlayer = 1;
        console.log(players);
        console.log(currentPlayer);
        $(".remainingFigures img.animal").click(function() {
//            if (phase == "takefigure") { // check for correct phase
                $(this).remove();
                $(this).appendTo($(".poachedAnimals .row[player=" + currentPlayer + "]"));
                currentPlayer = getNewPlayerNum(currentPlayer);
                phase = "playcard";
//            }
        });
        
        function getNewPlayerNum(currentPlayerNum) {
            return ((currentPlayerNum) % players) + 1;
        }
    });
</script>