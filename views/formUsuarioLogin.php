<?php require_once "includes/cabecalho.inc.php";

$em_compra = 0;

if (isset($_REQUEST["em_compra"])) {
    $em_compra = (int)$_REQUEST["em_compra"];
}
?>

<div class="row">
    <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card flex-row my-5 border-0 shadow-lg rounded-3 overflow-hidden">
            <div class="card-img-left d-none d-md-flex">
            </div>
            <div class="card-body p-4 p-sm-5">
                <div class="text-center mb-4">
                    <i class="fas fa-user-circle text-primary" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3 mb-0 fw-bold">Fazer Login</h5>
                    <p class="text-muted">Acesse sua conta</p>
                </div>

                <form action="../controllers/controllerUsuario.php" method="get">
                    <input type="hidden" name="em_compra" value="<?= $em_compra ?>">

                    <div class="form-floating mb-4">
                        <input type="email" class="form-control" id="floatingInputEmail" minlength="8" maxlength="50"
                            placeholder="nome@exemplo.com" name="email" required>
                        <label for="floatingInputEmail">
                            <i class="fas fa-envelope me-2"></i>
                            Email
                        </label>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="floatingPassword" minlength="4" maxlength="8"
                            placeholder="Senha" name="senha" required>
                        <label for="floatingPassword">
                            <i class="fas fa-lock me-2"></i>
                            Senha
                        </label>
                    </div>

                    <div class="d-grid mb-3">
                        <button class="btn btn-lg btn-primary fw-bold" type="submit">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Entrar
                        </button>
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


<?php require_once "includes/rodape.inc.php" ?>