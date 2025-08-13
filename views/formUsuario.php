<?php require_once "includes/cabecalho.inc.php" ?>

<!-- CONTEUDO -->
<h1 class="text-center">Cadastro de Usuário</h1>

<div class="row">
    <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
            <div class="card-img-left d-none d-md-flex">
                <!-- Background image for card set in CSS! -->
            </div>
            <div class="card-body p-4 p-sm-5">
                <h5 class="card-title text-center mb-5 fw-light fs-5">Entre com suas informações de Cadastro</h5>
                <form action="../controllers/controllerUsuario.php" method="get">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" minlength="3" maxlength="50" id="floatingInputNome" placeholder="José" name="nome" required>
                        <label for="floatingInputNome">Nome</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInputEmail" minlength="8" maxlength="50" placeholder="nome@exemplo.com" name="email" required>
                        <label for="floatingInputEmail">Email</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputEndereco" minlength="5" maxlength="50" placeholder="rua, avenida, rodovia + nº" name="endereco" required>
                        <label for="floatingInputEndereco">Endereço</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputTel" oninput="validarTelefone(this)"
                        placeholder="XX XXXXX-XXXX" name="telefone" required>
                        <label for="floatingInputTel">Telefone (XX XXXXX-XXXX)</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputCPF" oninput="validarCPF_CNPJ(this)"
                        placeholder="XXX.XXX.XXX-XX" name="cpf_cnpj" required>
                        <label for="floatingInputCPF">CPF ou CNPJ (XXX.XXX.XXX-XX)</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="floatingInputDtNasc" name="dt_nascimento" oninput="validarDataNascimento()" required>
                        <label for="floatingInputDtNasc">Data Nascimento</label>
                    </div>

                    <div id="erroDtNasc" class="alert alert-danger" role="alert" style="display: none;">
                        O usuário deve ter mais de 18 anos
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" minlength="4" 
                        maxlength="8" placeholder="Senha" name="senha" oninput="validarSenha()" required>
                        <label for="floatingPassword">Senha</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingCPassword" minlength="4" maxlength="8" 
                        placeholder="Confirmar Senha" name="confirmar_senha" oninput="validarSenha()" required>
                        <label for="floatingCPassword">Confirmar Senha</label>
                    </div>

                    <div id="erroSenha" class="alert alert-danger" role="alert" style="display: none;">
                        A senha e confirmação de senha são diferentes.
                    </div>

                    <hr>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="floatingPestador" name="tipo">
                        <label class="form-check-label" for="floatingPestador">É prestador de serviço</label>
                    </div>

                    <div class="d-grid mb-2">
                        <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">Efetuar Cadastro</button>
                    </div>

                     <?php
                        require_once "includes/mensagens.inc.php";
                    ?>

                    <a class="d-block text-center mt-2 small" href="formUsuarioLogin.php">Possui uma conta? Entre aqui</a>

                    <input type="hidden" value="3" name="opcao">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="includes/scripts/validacoesFormUsuario.js"></script>

<!-- Rodape -->

<?php require_once "includes/rodape.inc.php" ?>