<?php
require_once '../classes/item.inc.php';
require_once '../classes/servico.inc.php';
require_once '../classes/dataDisponivel.inc.php';
require_once '../utils/funcoesUteis.php';
require_once 'includes/cabecalho.inc.php';


$carrinho = [];

if (isset($_SESSION["carrinho"])) {
    $carrinho = $_SESSION["carrinho"];
}

?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-4">
                <h1 class="h3 text-primary">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Meu Carrinho
                </h1>
                <p class="text-muted">Revise seus serviços selecionados</p>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/mensagens.inc.php" ?>

<?php
if (sizeof($carrinho) == 0) {
    include_once 'includes/carrinhoVazio.inc.php';
    $_SESSION["soma"] = 0;
} else {
?>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Itens no Carrinho
                <span class="badge bg-light text-primary ms-2"><?= sizeof($carrinho) ?></span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr class="align-middle text-center">
                            <th width="8%">
                                <i class="fas fa-hashtag"></i>
                                ID
                            </th>
                            <th>
                                <i class="fas fa-info-circle me-1"></i>
                                Nome
                            </th>
                            <th>
                                <i class="fas fa-user me-1"></i>
                                Prestador
                            </th>
                            <th>
                                <i class="fas fa-map-marker-alt me-1"></i>
                                Cidade
                            </th>
                            <th>
                                <i class="fas fa-calendar me-1"></i>
                                Data
                            </th>
                            <th>
                                <i class="fas fa-dollar-sign me-1"></i>
                                Valor
                            </th>
                            <th width="10%">
                                <i class="fas fa-trash me-1"></i>
                                Ação
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        $contador = 0;
                        $soma = 0;
                        foreach ($carrinho as $item) {
                            $servico = $item->getServico();
                            if ($servico === null) {
                                continue;
                            }
                            foreach ($item->getDatas() as $data) {
                                $contador++;
                                $soma += $servico->valor;
                        ?>
                                <tr class="align-middle" style="text-align: center">
                                    <td class="fw-bold"><?= $contador ?></td>
                                    <td class="text-start"><?= $servico->nome ?></td>
                                    <td><?= $servico->nomePrestador ?></td>
                                    <td><?= $servico->cidade ?></td>
                                    <td><?= formatarData($data->data) ?></td>
                                    <td class="fw-bold text-success">R$ <?= number_format($servico->valor, 2, ",", ".") ?></td>
                                    <td>
                                        <a href="../controllers/controllerCarrinho.php?opcao=4&id_servico=<?= $servico->id ?>&id_data=<?= $data->id ?>"
                                            class="btn btn-outline-danger btn-sm"
                                            title="Remover item"
                                            onclick="return confirm('Deseja remover este item do carrinho?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                        <?php }
                        } ?>

                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0 text-primary">
                            <i class="fas fa-calculator me-2"></i>
                            Total: <span class="text-success fw-bold">R$ <?= number_format($soma, 2, ",", ".") ?></span>
                        </h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted"><?= $contador ?> item(ns) no carrinho</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-4 mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center align-items-center">
                <a class="btn btn-outline-primary btn-lg shadow-sm" href="../controllers/controllerServico.php?opcao=6&opcao_redirecionamento=1">
                    <i class="fas fa-shopping-bag me-2"></i>
                    Continuar Comprando
                </a>
                <a class="btn btn-outline-warning btn-lg shadow-sm" href="../controllers/controllerCarrinho.php?opcao=5"
                    onclick="return confirm('⚠️ Deseja realmente esvaziar todo o carrinho?')">
                    Limpar Carrinho
                </a>
                <a class="btn btn-success btn-lg shadow fw-bold" href="../controllers/controllerVenda.php?opcao=2">
                    <i class="fas fa-credit-card me-2"></i>
                    Finalizar Compra
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

<?php
    $_SESSION["soma"] = $soma;
}
?>

<?php require_once 'includes/rodape.inc.php'; ?>