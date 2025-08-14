<?php
require_once '../classes/servico.inc.php';
require_once 'includes/cabecalho.inc.php';

$usuarios = $_SESSION['usuarios'];
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="text-center mb-4">
                <h1 class="h3 text-primary">
                    <i class="fas fa-users me-2"></i>
                    Usuários Cadastrados
                </h1>
                <p class="text-muted">Gerencie os usuários do sistema</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>
            Lista de Usuários
            <span class="badge bg-light text-primary ms-2"><?= count($usuarios) ?></span>
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
                            <i class="fas fa-user me-1"></i>
                            Nome
                        </th>
                        <th>
                            <i class="fas fa-home me-1"></i>
                            Endereço
                        </th>
                        <th>
                            <i class="fas fa-map-marker-alt me-1"></i>
                            Cidade
                        </th>
                        <th>
                            <i class="fas fa-phone me-1"></i>
                            Telefone
                        </th>
                        <th>
                            <i class="fas fa-envelope me-1"></i>
                            Email
                        </th>
                        <th>
                            <i class="fas fa-tag me-1"></i>
                            Tipo
                        </th>
                        <th width="12%">
                            <i class="fas fa-cogs me-1"></i>
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    $contadora = 0;
                    foreach ($usuarios as $usuario) {
                        $contadora++;
                        echo "<tr class='align-middle text-center'>";
                        echo "<td class='fw-bold'>" . $contadora . "</td>";
                        echo "<td class='text-start'><strong>" . $usuario->nome . "</strong></td>";
                        echo "<td class='text-truncate' style='max-width: 150px;' title='" . htmlspecialchars($usuario->endereco) . "'>" . $usuario->endereco . "</td>";
                        echo "<td>" . $usuario->cidade . "</td>";
                        echo "<td>" . $usuario->telefone . "</td>";
                        echo "<td>" . $usuario->email . "</td>";
                        echo "<td><span class='badge bg-info'>" . $usuario->tipo . "</span></td>";
                        echo "<td>";
                        echo "<a href='../controllers/controllerUsuario.php?opcao=11&id=" . $usuario->id . "' class='btn btn-outline-primary btn-sm me-1' title='Visualizar usuário'>";
                        echo "<i class='fas fa-eye'></i>";
                        echo "</a>";
                        if (!$usuario->possuiServicosFuturosAPrestar && !$usuario->possuiServicosFuturosContratados) {
                            echo "<a href='../controllers/controllerUsuario.php?opcao=13&id=" . $usuario->id . "' class='btn btn-outline-danger btn-sm' title='Excluir usuário' onclick='return confirm(\"Deseja excluir este usuário?\")'>";
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

<?php
require_once 'includes/rodape.inc.php';
?>