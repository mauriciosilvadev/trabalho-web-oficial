<?php require_once "includes/cabecalho.inc.php" ?>

<div class="row">
    <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
            <div class="card-img-left d-none d-md-flex">
            </div>
            <div class="card-body p-4 p-sm-5">
                <div class="text-center mb-4">
                    <i class="fas fa-user-plus text-primary" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3 mb-0 fw-bold">Criar Nova Conta</h5>
                    <p class="text-muted">Preencha os dados abaixo para se cadastrar</p>
                </div>
                
                <form action="../controllers/controllerUsuario.php" method="get">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-user me-2"></i>
                                Informações Pessoais
                            </h6>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" minlength="3" maxlength="50" id="floatingInputNome" placeholder="José" name="nome" required>
                        <label for="floatingInputNome">
                            <i class="fas fa-user me-2"></i>
                            Nome Completo
                        </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInputEmail" minlength="8" maxlength="50" placeholder="nome@exemplo.com" name="email" required>
                        <label for="floatingInputEmail">
                            <i class="fas fa-envelope me-2"></i>
                            Email
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted mb-3 mt-4">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Endereço
                            </h6>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputEndereco" minlength="5" maxlength="50" placeholder="rua, avenida, rodovia + nº" name="endereco" required>
                        <label for="floatingInputEndereco">
                            <i class="fas fa-home me-2"></i>
                            Endereço
                        </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputCidade" minlength="2" maxlength="50" placeholder="Nome da cidade" name="cidade" required>
                        <label for="floatingInputCidade">
                            <i class="fas fa-city me-2"></i>
                            Cidade
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted mb-3 mt-4">
                                <i class="fas fa-phone me-2"></i>
                                Contato
                            </h6>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputTel" 
                            placeholder="Digite apenas números" name="telefone" maxlength="11" 
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        <label for="floatingInputTel">
                            <i class="fas fa-phone me-2"></i>
                            Telefone
                        </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputCPF" 
                            placeholder="Digite apenas números" name="cpf_cnpj" maxlength="11"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        <label for="floatingInputCPF">
                            <i class="fas fa-id-card me-2"></i>
                            CPF ou CNPJ
                        </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="floatingInputDtNasc" name="dt_nascimento" oninput="validarDataNascimento()" required>
                        <label for="floatingInputDtNasc">
                            <i class="fas fa-calendar me-2"></i>
                            Data de Nascimento
                        </label>
                    </div>

                    <div id="erroDtNasc" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        O usuário deve ter mais de 18 anos
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted mb-3 mt-4">
                                <i class="fas fa-lock me-2"></i>
                                Segurança
                            </h6>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" minlength="8"
                            placeholder="Senha" name="senha"
                            title="A senha deve conter no mínimo 8 caracteres, uma letra maiúscula, uma minúscula, um número e um caractere especial"
                            oninput="validarSenha()" required>
                        <label for="floatingPassword">
                            <i class="fas fa-key me-2"></i>
                            Senha
                        </label>
                    </div>

                    <div id="erroSenhaForca" class="alert alert-warning alert-dismissible fade show" role="alert" style="display: none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        A senha deve conter no mínimo 8 caracteres, uma letra maiúscula, uma minúscula, um número e um caractere especial (!@#$%^&*)
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingCPassword" minlength="8"
                            placeholder="Confirmar Senha" name="confirmar_senha" oninput="validarSenha()" required>
                        <label for="floatingCPassword">
                            <i class="fas fa-lock me-2"></i>
                            Confirmar Senha
                        </label>
                    </div>

                    <div id="erroSenha" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        A senha e confirmação de senha são diferentes.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted mb-3 mt-4">
                                <i class="fas fa-cog me-2"></i>
                                Tipo de Conta
                            </h6>
                        </div>
                    </div>

                    <div class="card border-primary mb-4">
                        <div class="card-body">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="floatingPestador" name="tipo">
                                <label class="form-check-label fw-semibold" for="floatingPestador">
                                    <i class="fas fa-user-tie me-2"></i>
                                    É prestador de serviço
                                </label>
                            </div>
                            <small class="text-muted">Marque esta opção se você deseja oferecer serviços na plataforma</small>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button class="btn btn-lg btn-primary fw-bold" type="submit">
                            <i class="fas fa-user-plus me-2"></i>
                            Criar Conta
                        </button>
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

<?php require_once "includes/rodape.inc.php" ?>