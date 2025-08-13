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

<h1 class="text-center">Servicos contratados</h1>
<?php include_once "includes/mensagens.inc.php" ?>
<p>
    <?php
    if (sizeof($vendas) == 0) {
        $title = "Nenhum serviço encontrado";
        $message = "Não foram encontrados serviços contratados.";
        require_once "includes/carrinhoBuscaVazia.php";
    } else {

    ?>
<div class="table-responsive">
    <table class="table table-ligth table-striped">
        <thead class="table-danger">
            <tr class="align-middle" style="text-align: center">
                <th witdh="10%">Nº</th>
                <th>Nome</th>
                <th>Prestador</th>
                <th>Cidade</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Pagamento</th>
                <th>Serviço</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $contador = 0;
            foreach ($vendas as $venda) {
                foreach ($venda->itens as $itens) {
                    $servico = $itens->getServico();
                    if ($servico === null) {
                        continue;
                    }
                    foreach ($itens->getDatas() as $data) {
                        $contador++;
            ?>
                        <tr class="align-middle" style="text-align: center">
                            <td><?= $contador ?></td>
                            <td><?= $servico->nome ?></td>
                            <td><?= $servico->nomePrestador ?></td>
                            <td><?= $servico->cidade ?></td>
                            <td><?= formatarData($data->data) ?></td>
                            <td>R$ <?= number_format($servico->valor, 2, ",", ".") ?></td>
                            <td><?= $venda->formaPagamento ?></td>
                            <?php
                            if ($data->prestado) {
                                echo "<td>serviço prestado</td>";
                            } else {
                                echo "<td><a href='../controllers/controllerServico.php?opcao=8&id=" . $data->id . "' class='btn btn-success btn-sm'>Prestado?</a></td>";
                            }
                            ?>
                        </tr>

            <?php }
                }
            } ?>
    </table>

<?php
    }
    require_once 'includes/rodape.inc.php';
?>