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
    <div class="alert alert-success" role="alert" id="success-message">
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

<script>
// Auto-hide success messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successMessages = document.querySelectorAll('#success-message');
    successMessages.forEach(function(message) {
        setTimeout(function() {
            message.style.transition = 'opacity 0.5s';
            message.style.opacity = '0';
            setTimeout(function() {
                message.remove();
            }, 500);
        }, 5000); // 5 segundos
    });
});
</script>