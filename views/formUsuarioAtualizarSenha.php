<?php require_once "includes/cabecalho.inc.php" ?>

<!-- CONTEUDO -->
<h1 class="text-center">Alterar Senha</h1>

<div class="row">
    <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
            <div class="card-img-left d-none d-md-flex">
                <!-- Background image for card set in CSS! -->
            </div>
            <div class="card-body p-4 p-sm-5">
                <h5 class="card-title text-center mb-5 fw-light fs-5">Entre com sua nova senha</h5>
                <form action="../controllers/controllerUsuario.php" method="get">

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" minlength="4" 
                        maxlength="8" placeholder="Senha" name="senha" oninput="validarSenha()" required>
                        <label for="floatingPassword">Nova Senha</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingCPassword" minlength="4" maxlength="8" 
                        placeholder="Confirmar Senha" name="confirmar_senha" oninput="validarSenha()" required>
                        <label for="floatingCPassword">Confirmar Senha</label>
                    </div>

                    <div id="erroSenha" class="alert alert-danger" role="alert" style="display: none;">
                        As senhas não coincidem.
                    </div>

                    <div class="d-grid mb-2">
                        <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">Atualizar Senha</button>
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

<script src="includes/scripts/validacoesFormUsuario.js"></script>

<!-- Rodape -->

<?php require_once "includes/rodape.inc.php" ?>