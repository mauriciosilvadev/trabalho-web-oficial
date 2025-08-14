<?php require_once "includes/cabecalho.inc.php" ?>

<div class="container-fluid px-3">
    <div class="row min-vh-100">
        <div class="col-md-8 col-lg-6 col-xl-5 d-flex align-items-center">
            <div class="w-100 py-5 px-md-5 px-xl-6 position-relative">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-warning text-dark text-center py-3">
                        <h2 class="mb-0">
                            <i class="fas fa-key me-2"></i>
                            Atualização de Senha
                        </h2>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="card-title text-center mb-4 fw-light fs-5">Entre com sua nova senha</h5>
                        <form action="../controllers/controllerUsuario.php" method="get">

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" minlength="4"
                                    maxlength="8" placeholder="Senha" name="senha" oninput="validarSenha()" required>
                                <label for="floatingPassword">
                                    <i class="fas fa-lock me-2"></i>Nova Senha
                                </label>
                            </div>

                            <hr>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingCPassword" minlength="4" maxlength="8"
                                    placeholder="Confirmar Senha" name="confirmar_senha" oninput="validarSenha()" required>
                                <label for="floatingCPassword">
                                    <i class="fas fa-lock me-2"></i>Confirmar Senha
                                </label>
                            </div>

                            <div id="erroSenha" class="alert alert-danger" role="alert" style="display: none;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                As senhas não coincidem
                            </div>

                            <div class="d-grid mb-2">
                                <button class="btn btn-lg btn-warning btn-login fw-bold text-uppercase text-dark" type="submit">
                                    <i class="fas fa-sync-alt me-2"></i>Atualizar Senha
                                </button>
                            </div>

                            <?php
                            require_once "includes/mensagens.inc.php";
                            ?>

                            <input type="hidden" value="6" name="opcao">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="includes/scripts/validacoesFormUsuario.js"></script>


<?php require_once "includes/rodape.inc.php" ?>