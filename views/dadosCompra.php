<?php
require_once '../classes/item.inc.php';
require_once '../classes/servico.inc.php';
require_once '../classes/dataDisponivel.inc.php';
require_once '../utils/funcoesUteis.php';
require_once "includes/cabecalho.inc.php";

$usuario = $_SESSION['usuario'];
$carrinho = $_SESSION['carrinho'];
$soma = $_SESSION["soma"];
?>

<h1 class="text-center">Dados do cliente</h1>

<p>&nbsp;
<div style="font-size: 1.25rem;">
    <p><b>Nome:</b> <?= $usuario->nome ?>
    <p><b>CPF/CNPJ:</b> <?= $usuario->cpf_cnpj ?>
    <p><b>Endereço Completo:</b> <?= $usuario->endereco ?>
    <p><b>Telefone:</b> <?= $usuario->telefone ?>
    <p><b>Email:</b> <?= $usuario->email ?>
        </font>
    <p>
        <hr>
    <p>&nbsp;
</div>

<h1 class="text-center">Dados da compra</h1>
<p>

<div class="table-responsive">
    <table class="table">
        <thead class="table-success">
            <tr class="align-middle" style="text-align: center">
                <th witdh="10%">Nº</th>
                <th>Descricao</th>
                <th>Prestador</th>
                <th>Cidade</th>
                <th>Data</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $contador = 0;
            foreach ($carrinho as $item) {
                $servico = $item->getServico();
                if ($servico === null) {
                    continue;
                }
                foreach ($item->getDatas() as $data) {
                    $contador++;
            ?>
                    <tr class="align-middle" style="text-align: center">
                        <td><?= $contador ?></td>
                        <td><?= $servico->descricao ?></td>
                        <td><?= $servico->nomePrestador ?></td>
                        <td><?= $servico->cidade ?></td>
                        <td><?= formatarData($data->data) ?></td>
                        <td>R$ <?= number_format($servico->valor, 2, ",", ".") ?></td>
                    </tr>
            <?php }
            } ?>

            <tr align="right">
                <td colspan="7">
                    <font face="Verdana" size="4" color="red"><b>Valor Total = R$ <?= number_format($soma, 2, ",", ".") ?></b></font>
                </td>
            </tr>
    </table>
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <a class="btn btn-success" role="button" href="dadosPagamento.php"><b>Efetuar o pagamento</b></a>
            </div>
        </div>
    </div>

    <!-- Rodape -->

    <?php require_once "includes/rodape.inc.php" ?>