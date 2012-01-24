<style type="text/css">
    .card { border:1px black solid; width:50px; }
</style>

<div class="card" animal="<?php echo $card->animal;  ?>" 
     price="<?php echo $card->value;  ?>" >
    <div class="cardImage">
        <img class="animal" animal="<?php echo $card->animal;  ?>" 
             src="/images/<?php echo $card->animal;  ?>01.jpg" 
             width="50" height="50" />
    </div>
    <div class="cardValue">
        <?php echo $card->value; ?>
    </div>
</div>