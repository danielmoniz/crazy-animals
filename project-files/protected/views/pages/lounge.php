Create a new game or join one here.
<div id="games">
    <?php echo $gamesBlock; ?>
</div>
<form id="lobby" action="<?php echo $this->createUrl("/board/lobby"); ?>" method="get">
    <input type="submit" value="New Game" />
    <input type="hidden" name="newGame" value="1" />
</form>

<script type="text/javascript">
    
    setInterval("checkForGames()", 1000);
    
    function checkForGames() {
        $.post("/board/getGamesList", function(data) {
            $("#games").html(data);
        });
    }
    
    $(document).ready(function() {
        
    });
</script>