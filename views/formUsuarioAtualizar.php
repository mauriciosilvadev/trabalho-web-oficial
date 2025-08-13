<?php
require_once "includes/cabecalho.inc.php";
require_once "../utils/funcoesUteis.php";

$usuario = $_SESSION["usuario"];
$opcaoUpdate = 5;
$opcaoUpdate = 5;
$opcaoRemocao = 7;

if($usuario->tipo == "A"){
    $opcaoUpdate = 12;
    $opcaoRemocao = 13;
    $usuario = $_SESSION["usuarioAtualizar"];
}
?>

<!-- CONTEUDO -->
<h1 class="text-center">Informações do Usuário</h1>

<div class="row">
    <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
            <div class="card-img-left d-none d-md-flex">
                <!-- Background image for card set in CSS! -->
            </div>
            <div class="card-body p-4 p-sm-5">
                <h5 class="card-title text-center mb-5 fw-light fs-5">Veja suas informações de Cadastro</h5>
                <form action="../controllers/controllerUsuario.php" method="get">

                    <div class="form-floating mb-3">

                        <input type="text" class="form-control" minlength="3" maxlength="50" id="floatingInputNome"
                            placeholder="José" name="nome" value="<?= $usuario->nome ?>">
                        <label for="floatingInputNome">Nome</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInputEmail" minlength="8" maxlength="50"
                            placeholder="nome@exemplo.com" name="email" value="<?= $usuario->email ?>">
                        <label for="floatingInputEmail">Email</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputEndereco" minlength="5" maxlength="50"
                            placeholder="rua, avenida, rodovia + nº" name="endereco" value="<?= $usuario->endereco ?>">
                        <label for="floatingInputEndereco">Endereço</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputTel" oninput="validarTelefone(this)"
                        placeholder="XX XXXXX-XXXX" name="telefone"
                            value="<?= $usuario->telefone ?>">
                        <label for="floatingInputTel">Telefone (XX XXXXX-XXXX)</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputCPF" oninput="validarCPF_CNPJ(this)"
                        value="<?= $usuario->cpf_cnpj?>" placeholder="XXX.XXX.XXX-XX" name="cpf_cnpj" required>
                        <label for="floatingInputCPF">CPF ou CNPJ (XXX.XXX.XXX-XX)</label>
                    </div>

                    <hr>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="floatingInputDtNasc" name="dt_nascimento" oninput="validarDataNascimento()"
                            value="<?= parseISO($usuario->dtNascimento) ?>">
                        <label for="floatingInputDtNasc">Data Nascimento</label>
                    </div>

                    <div id="erroDtNasc" class="alert alert-danger" role="alert" style="display: none;">
                        O usuário deve ter mais de 18 anos
                    </div>

                    <hr>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="floatingPestador" name="tipo"
                            <?= $usuario->tipo == "P" ? "checked" : "" ?> <?= $usuario->possuiServicosFuturosAPrestar ? "disabled" : "" ?>>
                        <label class="form-check-label" for="floatingPestador">É Prestador de serviço</label>
                    </div>

                    <div class="d-grid mb-2">
                        <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">atualizar Cadastro</button>
                    </div>

                    <?php
                    if (!$usuario->possuiServicosFuturosAPrestar && !$usuario->possuiServicosFuturosContratados) {
                        echo "<div class='d-grid mb-2'>
                        <a href='../controllers/controllerUsuario.php?opcao=". $opcaoRemocao ."' class='btn btn-lg btn-danger btn-login fw-bold text-uppercase' >Remover conta</a>
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

<script src="includes/scripts/validacoesFormUsuario.js"></script>

<!-- Rodape -->

<?php require_once "includes/rodape.inc.php" ?>