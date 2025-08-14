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

<div class="row">
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center">Dados do Cliente</h4>
            </div>
            <div class="card-body">
                <div class="mb-2"><strong>Código:</strong> <?= $usuario->id ?></div>
                <div class="mb-2"><strong>Nome:</strong> <?= $usuario->nome ?></div>
                <div class="mb-2"><strong>CPF/CNPJ:</strong> <?= $usuario->cpf_cnpj ?></div>
                <div class="mb-2"><strong>Endereço:</strong> <?= $usuario->endereco ?></div>
                <div class="mb-2"><strong>Cidade:</strong> <?= $usuario->cidade ?></div>
                <div class="mb-2"><strong>Telefone:</strong> <?= $usuario->telefone ?></div>
                <div class="mb-0"><strong>Email:</strong> <?= $usuario->email ?></div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-12 mb-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0 text-center">Dados do(s) Serviço(s)</h4>
            </div>
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-success">
                            <tr class="align-middle" style="text-align: center">
                                <th witdh="10%">ID</th>
                                <th>Nome</th>
                                <th>Tipo</th>
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
                                        <td><?= $servico->id ?></td>
                                        <td><?= $servico->nome ?></td>
                                        <td><?= $servico->tipo->nome ?></td>
                                        <td><?= $servico->nomePrestador ?></td>
                                        <td><?= $servico->cidade ?></td>
                                        <td><?= formatarData($data->data) ?></td>
                                        <td>R$ <?= number_format($servico->valor, 2, ",", ".") ?></td>
                                    </tr>
                            <?php }
                            } ?>

                            <tr align="right">
                                <td colspan="8">
                                    <font face="Verdana" size="4" color="red"><b>Valor Total = R$ <?= number_format($soma, 2, ",", ".") ?></b></font>
                                </td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 text-center">
            <a class="btn btn-success btn-lg px-5" role="button" href="dadosPagamento.php">
                <i class="fas fa-credit-card me-2"></i><b>Efetuar o Pagamento</b>
            </a>
        </div>
    </div>


    <?php require_once "includes/rodape.inc.php" ?>