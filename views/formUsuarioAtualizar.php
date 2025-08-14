<?php
require_once "includes/cabecalho.inc.php";
require_once "../utils/funcoesUteis.php";

$usuario = $_SESSION["usuario"];
$opcaoUpdate = 5;
$opcaoUpdate = 5;
$opcaoRemocao = 7;

if ($usuario->tipo == "A") {
    $opcaoUpdate = 12;
    $opcaoRemocao = 13;
    $usuario = $_SESSION["usuarioAtualizar"];
}
?>

<div class="container-fluid px-3">
    <div class="row min-vh-100 justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5 d-flex align-items-center">
            <div class="w-100 py-5 px-md-5 px-xl-6 position-relative">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h2 class="mb-0">
                            <i class="fas fa-user-edit me-2"></i>
                            Atualização de Dados
                        </h2>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Veja suas informações de Cadastro</h5>
                        <form action="../controllers/controllerUsuario.php" method="get">

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" minlength="3" maxlength="50" id="floatingInputNome"
                                        placeholder="José" name="nome" value="<?= $usuario->nome ?>" required>
                                    <label for="floatingInputNome">Nome</label>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingInputEmail" minlength="8" maxlength="50"
                                        placeholder="nome@exemplo.com" name="email" value="<?= $usuario->email ?>" required>
                                    <label for="floatingInputEmail">Email</label>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputEndereco" minlength="5" maxlength="50"
                                        placeholder="rua, avenida, rodovia + nº" name="endereco" value="<?= $usuario->endereco ?>" required>
                                    <label for="floatingInputEndereco">Endereço</label>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-city"></i></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputCidade" minlength="2" maxlength="50"
                                        placeholder="Nome da cidade" name="cidade" value="<?= $usuario->cidade ?>" required>
                                    <label for="floatingInputCidade">Cidade</label>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputTel"
                                        placeholder="Digite apenas números" name="telefone" maxlength="11"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        value="<?= $usuario->telefone ?>" required>
                                    <label for="floatingInputTel">Telefone</label>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputCPF"
                                        placeholder="Digite apenas números" name="cpf_cnpj" maxlength="11"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        value="<?= $usuario->cpf_cnpj ?>" required>
                                    <label for="floatingInputCPF">CPF ou CNPJ</label>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="floatingInputDtNasc" name="dt_nascimento" oninput="validarDataNascimento()"
                                        value="<?= parseISO($usuario->dtNascimento) ?>" required>
                                    <label for="floatingInputDtNasc">Data Nascimento</label>
                                </div>
                            </div>

                            <div id="erroDtNasc" class="alert alert-danger" role="alert" style="display: none;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                O usuário deve ter mais de 18 anos
                            </div>

                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" id="floatingPestador" name="tipo"
                                    <?= $usuario->tipo == "P" ? "checked" : "" ?> <?= $usuario->possuiServicosFuturosAPrestar ? "disabled" : "" ?>>
                                <label class="form-check-label" for="floatingPestador">
                                    <i class="fas fa-tools me-2"></i>
                                    É Prestador de serviço
                                </label>
                            </div>

                            <div class="d-grid mb-3">
                                <button class="btn btn-lg btn-primary fw-bold" type="submit">
                                    <i class="fas fa-save me-2"></i>
                                    Atualizar Cadastro
                                </button>
                            </div>

                            <?php
                            if (!$usuario->possuiServicosFuturosAPrestar && !$usuario->possuiServicosFuturosContratados) {
                                echo "<div class='d-grid mb-3'>
                        <a href='../controllers/controllerUsuario.php?opcao=" . $opcaoRemocao . "' class='btn btn-lg btn-danger fw-bold'>
                            <i class='fas fa-trash me-2'></i>
                            Remover Conta
                        </a>
                        </div>";
                            }
                            ?>

                            <input type="hidden" value="<?= $opcaoUpdate ?>" name="opcao">
                            <input type="hidden" value="<?= $usuario->id ?>" name="id">

                            <?php
                            require_once "includes/mensagens.inc.php";
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="includes/scripts/validacoesFormUsuario.js"></script>


<?php require_once "includes/rodape.inc.php" ?>