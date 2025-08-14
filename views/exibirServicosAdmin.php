<?php
require_once '../classes/servico.inc.php';
require_once 'includes/cabecalho.inc.php';

$servicos = $_SESSION['servicos'];
?>
<?php require_once 'includes/mensagens.inc.php'; ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <i class="fas fa-cogs text-primary me-2"></i>
                    Serviços Cadastrados - Administração
                </h1>
                <span class="badge bg-primary fs-6"><?= count($servicos) ?> serviços</span>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-primary">
                        <tr class="align-middle text-center">
                            <th width="8%">
                                <i class="fas fa-hashtag me-1"></i>
                                ID
                            </th>
                            <th>
                                <i class="fas fa-user me-1"></i>
                                Prestador
                            </th>
                            <th>
                                <i class="fas fa-tag me-1"></i>
                                Nome
                            </th>
                            <th>
                                <i class="fas fa-align-left me-1"></i>
                                Descrição
                            </th>
                            <th>
                                <i class="fas fa-dollar-sign me-1"></i>
                                Valor
                            </th>
                            <th>
                                <i class="fas fa-map-marker-alt me-1"></i>
                                Cidade
                            </th>
                            <th>
                                <i class="fas fa-folder me-1"></i>
                                Tipo
                            </th>
                            <th width="15%">
                                <i class="fas fa-cog me-1"></i>
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contadora = 0;
                        foreach ($servicos as $servico) {
                            $contadora++;
                            echo "<tr class='align-middle text-center'>";
                            echo "<td><span class='badge bg-light text-dark'>" . $contadora . "</span></td>";
                            echo "<td><strong class='text-primary'>" . $servico->nomePrestador . "</strong></td>";
                            echo "<td><strong>" . $servico->nome . "</strong></td>";
                            echo "<td><span class='text-truncate d-inline-block' style='max-width: 200px;' title='" . htmlspecialchars($servico->descricao) . "'>" . $servico->descricao . "</span></td>";
                            echo "<td><span class='fw-bold text-success'>R$ " . number_format($servico->valor, 2, ',', '.') . "</span></td>";
                            echo "<td><i class='fas fa-map-marker-alt text-muted me-1'></i>" . $servico->cidade . "</td>";
                            echo "<td><span class='badge bg-info'>" . $servico->tipo->nome . "</span></td>";
                            echo "<td>";
                            echo "<a href='../controllers/controllerServico.php?opcao=3&id=" . $servico->id . "' class='btn btn-outline-primary btn-sm me-1' title='Visualizar'>";
                            echo "<i class='fas fa-eye'></i>";
                            echo "</a>";
                            if (!$servico->possuiServicoAFazer) {
                                echo "<a href='../controllers/controllerServico.php?opcao=5&id=" . $servico->id . "' class='btn btn-outline-danger btn-sm' title='Excluir' onclick='return confirm(\"Tem certeza que deseja excluir este serviço?\")'>";
                                echo "<i class='fas fa-trash'></i>";
                                echo "</a>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
        </tbody>
    </table>

                </div>
            </div>
        </div>
    </div>

    <?php
    if ($contadora == 0) {
        require_once 'includes/servicosVazios.inc.php';
    }
    ?>

</div>

<?php
require_once 'includes/rodape.inc.php';
?>