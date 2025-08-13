<?php
require_once '../classes/item.inc.php';
require_once '../classes/servico.inc.php';
require_once '../classes/dataDisponivel.inc.php';
require_once '../utils/funcoesUteis.php';
require_once 'includes/cabecalho.inc.php';


$carrinho = [];

if(isset($_SESSION["carrinho"])){
    $carrinho = $_SESSION["carrinho"];
}

?>

<h1 class="text-center">Carrinho de compra</h1>
<?php include_once "includes/mensagens.inc.php" ?>
<p>
    <?php
    if(sizeof($carrinho) == 0){
        include_once 'includes/carrinhoVazio.inc.php';
        $_SESSION["soma"] = 0;
    }else{

    ?>
<div class="table-responsive">
    <table class="table table-ligth table-striped">
        <thead class="table-danger">
            <tr class="align-middle" style="text-align: center">
                <th witdh="10%">Nº</th>
                <th>Descricao</th>
                <th>Prestador</th>
                <th>Cidade</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Remover</th>
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
                <td><?= $contador ?></td>
                <td><?= $servico->descricao ?></td>
                <td><?= $servico->nomePrestador ?></td>
                <td><?= $servico->cidade ?></td>
                <td><?= formatarData($data->data) ?></td>
                <td>R$ <?= number_format($servico->valor, 2, ",", ".") ?></td>
                <td><a href="../controllers/controllerCarrinho.php?opcao=4&id_servico=<?= $servico->id?>&id_data=<?= $data->id ?>" class='btn btn-danger btn-sm'>X</a></td>
            </tr>

            <?php }} ?>

            <tr align="right">
                <td colspan="8">
                    <font face="Verdana" size="4" color="red"><b>Valor Total = <?=number_format($soma, 2, ",", ".")?></b></font>
                </td>
            </tr>
    </table>
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <a class="btn btn-warning" role="button" href="../controllers/controllerServico.php?opcao=6&opcao_redirecionamento=1"><b>Continuar comprando</b></a>
            </div>
            <div class="col">
                <a class="btn btn-danger" role="button" href="../controllers/controllerCarrinho.php?opcao=5"><b>Esvaziar carrinho</b></a>
            </div>
            <div class="col">
                <a class="btn btn-success" role="button" href="../controllers/controllerVenda.php?opcao=2"><b>Finalizar compra</b></a>
            </div>
        </div>
    </div>

    <?php
        $_SESSION["soma"] = $soma;
    }
    require_once 'includes/rodape.inc.php';
    ?>