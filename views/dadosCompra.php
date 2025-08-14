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

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="text-center mb-4">
                <h1 class="h3 text-primary">
                    <i class="fas fa-file-invoice me-2"></i>
                    Resumo da Compra
                </h1>
                <p class="text-muted">Revise os dados antes de prosseguir com o pagamento</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 text-center">
                    <i class="fas fa-user me-2"></i>
                    Dados do Cliente
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-hashtag text-primary me-2"></i>
                    <strong>Código:</strong> <span class="badge bg-light text-dark"><?= $usuario->id ?></span>
                </div>
                <div class="mb-3">
                    <i class="fas fa-user text-primary me-2"></i>
                    <strong>Nome:</strong> <?= $usuario->nome ?>
                </div>
                <div class="mb-3">
                    <i class="fas fa-id-card text-primary me-2"></i>
                    <strong>CPF/CNPJ:</strong> <?= $usuario->cpf_cnpj ?>
                </div>
                <div class="mb-3">
                    <i class="fas fa-home text-primary me-2"></i>
                    <strong>Endereço:</strong> <?= $usuario->endereco ?>
                </div>
                <div class="mb-3">
                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                    <strong>Cidade:</strong> <?= $usuario->cidade ?>
                </div>
                <div class="mb-3">
                    <i class="fas fa-phone text-primary me-2"></i>
                    <strong>Telefone:</strong> <?= $usuario->telefone ?>
                </div>
                <div class="mb-0">
                    <i class="fas fa-envelope text-primary me-2"></i>
                    <strong>Email:</strong> <?= $usuario->email ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-12 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0 text-center">
                    <i class="fas fa-list me-2"></i>
                    Serviços Contratados
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
                                    <i class="fas fa-tag me-1"></i>
                                    Nome
                                </th>
                                <th>
                                    <i class="fas fa-list me-1"></i>
                                    Tipo
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
                                    <tr class="align-middle text-center">
                                        <td class="fw-bold"><?= $servico->id ?></td>
                                        <td class="text-start"><?= $servico->nome ?></td>
                                        <td><span class="badge bg-info"><?= $servico->tipo->nome ?></span></td>
                                        <td><?= $servico->nomePrestador ?></td>
                                        <td><?= $servico->cidade ?></td>
                                        <td><?= formatarData($data->data) ?></td>
                                        <td class="fw-bold text-success">R$ <?= number_format($servico->valor, 2, ",", ".") ?></td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0 text-primary">
                                <i class="fas fa-calculator me-2"></i>
                                Total da Compra:
                                <span class="text-success fw-bold">R$ <?= number_format($soma, 2, ",", ".") ?></span>
                            </h4>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="text-muted"><?= $contador ?> serviço(s) contratado(s)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body text-center py-4">
                <h5 class="text-primary mb-3">
                    <i class="fas fa-arrow-right me-2"></i>
                    Próximo Passo
                </h5>
                <p class="text-muted mb-4">Confirme os dados acima e prossiga para o pagamento</p>
                <a class="btn btn-success btn-lg px-5" href="dadosPagamento.php">
                    <i class="fas fa-credit-card me-2"></i>
                    Prosseguir para Pagamento
                </a>
            </div>
        </div>
    </div>
</div>


<?php require_once "includes/rodape.inc.php" ?>