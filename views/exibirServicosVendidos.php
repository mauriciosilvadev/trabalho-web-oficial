<?php
require_once '../classes/item.inc.php';
require_once '../classes/servico.inc.php';
require_once '../classes/venda.inc.php';
require_once '../classes/dataDisponivel.inc.php';
require_once '../utils/funcoesUteis.php';
require_once 'includes/cabecalho.inc.php';


$vendas = [];

if (isset($_SESSION["vendas_feitas"])) {
    $vendas = $_SESSION["vendas_feitas"];
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="text-success mb-0">
        <i class="fas fa-chart-line me-2"></i>
        Serviços Vendidos
    </h1>
    <span class="badge bg-success fs-6">
        <i class="fas fa-list me-1"></i>
        <?= sizeof($vendas) ?> vendas
    </span>
</div>

<?php include_once "includes/mensagens.inc.php" ?>

<?php
if (sizeof($vendas) == 0) {
    $title = "Nenhum serviço vendido";
    $message = "Não foram encontrados serviços vendidos.";
    require_once "includes/carrinhoBuscaVazia.php";
} else {
?>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-success">
                        <tr class="align-middle text-center">
                            <th class="fw-bold">
                                <i class="fas fa-hashtag me-1"></i>
                                Nº
                            </th>
                            <th class="fw-bold">
                                <i class="fas fa-tag me-1"></i>
                                Nome
                            </th>
                            <th class="fw-bold">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                Cidade
                            </th>
                            <th class="fw-bold">
                                <i class="fas fa-calendar me-1"></i>
                                Data
                            </th>
                            <th class="fw-bold">
                                <i class="fas fa-dollar-sign me-1"></i>
                                Valor
                            </th>
                            <th class="fw-bold">
                                <i class="fas fa-credit-card me-1"></i>
                                Pagamento
                            </th>
                            <th class="fw-bold">
                                <i class="fas fa-cogs me-1"></i>
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        $contador = 0;
                        $valorTotalServicosPrestados = 0;
                        $valorTotal = 0;
                        foreach ($vendas as $venda) {
                            foreach ($venda->itens as $itens) {
                                $servico = $itens->getServico();
                                if ($servico === null) {
                                    continue;
                                }
                                $datas = $itens->getDatas();
                                foreach ($datas as $data) {
                                    $contador++;
                                    if ($data->prestado) {
                                        $valorTotalServicosPrestados += $servico->valor;
                                    }
                                    $valorTotal += $servico->valor;
                        ?>
                                    <tr class="align-middle text-center">
                                        <td class="fw-bold text-success"><?= $contador ?></td>
                                        <td class="fw-semibold"><?= $servico->nome ?></td>
                                        <td>
                                            <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                            <?= $servico->cidade ?>
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar text-muted me-1"></i>
                                            <?= formatarData($data->data) ?>
                                        </td>
                                        <td class="fw-bold text-success">
                                            <i class="fas fa-dollar-sign me-1"></i>
                                            R$ <?= number_format($servico->valor, 2, ",", ".") ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <i class="fas fa-credit-card me-1"></i>
                                                <?= $venda->formaPagamento ?>
                                            </span>
                                        </td>
                                        <?php
                                        if ($data->prestado) {
                                            echo "<td><span class='badge bg-success fs-6'><i class='fas fa-check-circle me-1'></i>Serviço Prestado</span></td>";
                                        } else {
                                            echo "<td><span class='badge bg-warning fs-6'><i class='fas fa-clock me-1'></i>Não Prestado</span></td>";
                                        }
                                        ?>
                                    </tr>

                        <?php }
                            }
                        } ?>

                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="7" class="text-end fw-bold fs-5 text-success border-top border-2">
                                <i class="fas fa-check-circle me-2"></i>
                                Valor Total Serviços Prestados:
                                <span class="badge bg-success ms-2 fs-6">
                                    R$ <?= number_format($valorTotalServicosPrestados, 2, ",", ".") ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-end fw-bold fs-4 text-primary border-top border-2">
                                <i class="fas fa-calculator me-2"></i>
                                Valor Total Geral:
                                <span class="badge bg-primary ms-2 fs-5">
                                    R$ <?= number_format($valorTotal, 2, ",", ".") ?>
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

<?php
}
require_once 'includes/rodape.inc.php';
?>