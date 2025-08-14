<?php
require_once "../classes/tipo.inc.php";
require_once "../utils/funcoesUteis.php";
require_once "includes/cabecalho.inc.php";

$tipos = isset($_SESSION["tipos"]) ? $_SESSION["tipos"] : [];
?>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-primary mb-0">Inclusão de Serviço</h1>
                <a href="../controllers/controllerServico.php?opcao=1" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #007bff, #0056b3);">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle"></i> Cadastrar Novo Serviço
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" action="../controllers/controllerServico.php" method="post">
                        <div class="col-md-6">
                            <label for="nome" class="form-label">Nome: </label>
                            <input type="text" class="form-control" name="nome" minlength="10" maxlength="50" required>
                        </div>
                        <div class="col-md-3">
                            <label for="valor" class="form-label">Valor: </label>
                            <input type="number" class="form-control" name="valor" lang="pt-BR" step="0.01" min="0.01" required>
                        </div>
                        <div class="col-md-3">
                            <label for="tipo" class="form-label">Tipo: </label>
                            <select name="tipo" class="form-select" required>
                                <option disabled selected value="">Escolha...</option>
                                <?php
                                foreach ($tipos as $t) {
                                    echo "<option value=$t->id>$t->nome</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="cidade" class="form-label">Cidade: </label>
                            <input type="text" class="form-control" minlength="3" maxlength="50" name="cidade" id="cidade" required>
                        </div>

                        <div class="col-md-8">
                            <label for="descricao" class="form-label">Descrição do serviço: </label>
                            <textarea class="form-control" minlength="10" maxlength="500" name="descricao" id="descricao" rows="3" required></textarea>
                        </div>

                        <div class="col-md-8 col-lg-6" id="datas">
                            <div class="d-flex">
                                <label for="dates" class="form-label me-auto">Datas: </label>
                                <button type="button" onclick="addDate()" class="mb-2 btn btn-primary mx-1" style="min-width: 100px;">Adicionar</button>
                            </div>
                            <div class="d-flex" id="data0">
                                <input type="date" name="datas[]" oninput="validarData()" class="form-control mb-2 data_input" required>
                                <button type="button" onclick="removeDate(0)" class="mb-2 btn btn-outline-danger mx-1" style="min-width: 100px;">Remover</button>
                            </div>
                        </div>

                        <input type="hidden" name="opcao" value="2">

                        <div class="col-12 d-flex gap-2 justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save"></i> Cadastrar Serviço <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                            <button type="reset" class="btn btn-outline-warning btn-lg px-4">
                                <i class="fas fa-eraser"></i> Limpar Formulário
                            </button>
                        </div>

                        <?php
                        require_once "includes/mensagens.inc.php";
                        ?>

                    </form>
                </div>
            </div>
        </div>

        <script src="includes/scripts/validacoesFormServico.js"></script>
        <script src="includes/scripts/adicionarRemoverDatasDisponiveis.js"></script>

        <?php
        require_once 'includes/rodape.inc.php';
        ?>