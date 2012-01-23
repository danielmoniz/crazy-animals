<?php
$animals = array("Lion", "Leopard", "Elephant", "Rhino", "Zebra");
?>



<style type="text/css">
    .row { clear:both; height:110px; }
</style>

<?php foreach ($animals as $animal): ?>
    <div class="row">
    <?php for ($i=0; $i<5; $i++): ?>
        <img class="animal <?php echo $animal; ?>"src="/images/<?php echo $animal; ?>01.jpg" width="100" height="100" />
    <?php endfor; ?>
    </div>
<?php endforeach; ?>




<script type="text/javascript">
    $(document).ready(function() {
        $("img.animal").click(function() {
            $(this).remove();
        });
    });
</script>