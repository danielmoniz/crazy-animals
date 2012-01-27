Waiting for players...
<div id="players">
    <?php echo $playerList; ?>
</div>
<form id="lobby" action="/board/play">
    <input type="submit" value="Start game!" />
    <input type="hidden" name="gameId" value="<?php echo $gameId; ?>" />
</form>

<script type="text/javascript">
    
    setInterval("checkForPlayers()", 1000);
    var gameId = $("input[name=gameId]").val();
    
    function checkForPlayers() {
        
        console.log("gameId:", gameId);
        $.post("/board/getPlayers", { gameId:gameId }, function(data) {
            $("#players").html(data);
        });
    }
    
    $(document).ready(function() {
        
    });
</script>