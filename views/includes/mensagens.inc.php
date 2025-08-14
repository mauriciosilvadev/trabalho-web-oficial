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
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" id="success-message">
        <i class="fas fa-check-circle me-2"></i>
        <strong>Sucesso!</strong> <?= $s ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<?php
foreach ($erros as $e) {
?>
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Erro!</strong> <?= $e ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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