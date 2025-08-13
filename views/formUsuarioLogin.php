<?php require_once "includes/cabecalho.inc.php";

$em_compra = 0;

if(isset($_REQUEST["em_compra"])){
    $em_compra = (int)$_REQUEST["em_compra"];
}
?>

<!-- CONTEUDO -->
<h1 class="text-center">Login de Usuário</h1>

<div class="row">
    <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
            <div class="card-img-left d-none d-md-flex">
                <!-- Background image for card set in CSS! -->
            </div>
            <div class="card-body p-4 p-sm-5">
                <h5 class="card-title text-center mb-5 fw-light fs-5">Entre com suas informações de Login</h5>
                <form action="../controllers/controllerUsuario.php" method="get">
                    <input type="hidden" name="em_compra" value="<?= $em_compra ?>">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInputEmail" minlength="8" maxlength="50"
                         placeholder="nome@exemplo.com" name="email" required>
                        <label for="floatingInputEmail">Endereço de Email</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" minlength="4" maxlength="8"
                         placeholder="Senha" name="senha" required>
                        <label for="floatingPassword">Senha</label>
                    </div>

                    <div class="d-grid mb-2">
                        <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">Efetuar Login</button>
                    </div>

                    <?php
                        require_once "includes/mensagens.inc.php";
                    ?>

                    <a class="d-block text-center mt-2 small" href="formUsuario.php">Não possui uma conta? Cadastre-se aqui</a>

                    <input type="hidden" value="1" name="opcao">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="includes/scripts/validacoesFormUsuario.js"></script>

<!-- Rodape -->

<?php require_once "includes/rodape.inc.php" ?>