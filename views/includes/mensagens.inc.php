<?php
$erros = [];
$sucessos = [];

if (isset($_SESSION["erros"])) {
    $erros = $_SESSION["erros"];
    unset($_SESSION["erros"]);
}

if (isset($_SESSION["sucessos"])) {
    $sucessos = $_SESSION["sucessos"];
    unset($_SESSION["sucessos"]);
}

?>

<?php
foreach ($sucessos as $s) {
?>
    <div class="alert alert-success" role="alert">
        <?= $s ?>
    </div>
<?php } ?>

<?php
foreach ($erros as $e) {
?>
<div class="alert alert-danger" role="alert">
    <?= $e ?>
</div>

<?php } ?>