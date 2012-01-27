<?php foreach ($games as $game): ?>
<div class="game">
    <a href="<?php echo $this->createUrl("/board/lobby", array('newGame'=>0, "gameId"=>$game['gameId'])); ?>">
        <?php echo $game['gameId']; ?>
    </a>
</div>
<?php endforeach;