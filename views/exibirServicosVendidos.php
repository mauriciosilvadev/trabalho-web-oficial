<?php
require_once '../classes/item.inc.php';
require_once '../classes/servico.inc.php';
require_once '../classes/venda.inc.php';
require_once '../classes/dataDisponivel.inc.php';
require_once '../utils/funcoesUteis.php';
require_once 'includes/cabecalho.inc.php';


$vendas = [];

if(isset($_SESSION["vendas_feitas"])){
    $vendas = $_SESSION["vendas_feitas"];
}
?>

<h1 class="text-center">Servicos vendidos</h1>
<?php include_once "includes/mensagens.inc.php" ?>
<p>
<?php
    if(sizeof($vendas) == 0){
        $title = "Nenhum serviço vendido";
        $message = "Não foram encontrados serviços vendidos.";
        require_once "includes/carrinhoBuscaVazia.php";
    }else{

    ?>
<div class="table-responsive">
    <table class="table table-ligth table-striped">
        <thead class="table-danger">
            <tr class="align-middle" style="text-align: center">
                <th witdh="10%">Nº</th>
                <th>Nome</th>
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
            $valorTotalServicosPrestados = 0;
            $valorTotal = 0;
            foreach ($vendas as $venda) {
                foreach ($venda->itens as $itens) {
                    $servico = $itens->getServico();
                    if ($servico === null) {
                        continue;
                    }
                    $datas = $itens->getDatas();
                    foreach($datas as $data){
                $contador++;
                if($data->prestado){
                    $valorTotalServicosPrestados += $servico->valor;
                }
                $valorTotal += $servico->valor;
            ?>
            <tr class="align-middle" style="text-align: center">
                <td><?= $contador ?></td>
                <td><?= $servico->nome ?></td>
                <td><?= $servico->cidade ?></td>
                <td><?= formatarData($data->data) ?></td>
                <td>R$ <?= number_format($servico->valor, 2, ",", ".") ?></td>
                <td><?= $venda->formaPagamento ?></td>
                <?php
                if($data->prestado){
                    echo "<td>serviço prestado</td>";
                }else{
                    echo "<td>serviço não prestado</td>";
                }
                ?>
            </tr>

            <?php }}} ?>

            <tr align="right">
                <td colspan="8">
                    <font face="Verdana" size="4" color="green"><b>Valor total serviços prestados = <?=number_format($valorTotalServicosPrestados, 2, ",", ".")?></b></font>
                </td>
            </tr>

            <tr align="right">
                <td colspan="8">
                    <font face="Verdana" size="4" color="green"><b>Valor total = <?=number_format($valorTotal, 2, ",", ".")?></b></font>
                </td>
            </tr>
    </table>

    <?php
    }
    require_once 'includes/rodape.inc.php';
    ?>