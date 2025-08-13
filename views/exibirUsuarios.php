<?php
require_once '../classes/servico.inc.php';
require_once 'includes/cabecalho.inc.php';

$usuarios = $_SESSION['usuarios'];
?>
<p>
<h1 class="text-center">Usuários cadastrados</h1>
<p>
<div class="table-responsive">
    <table class="table table-light table-hover">
        <thead class="table-primary">
            <tr class="align-middle" style="text-align: center">
                <th witdh="10%">ID</th>
                <th>Nome</th>
                <th>Endereco</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $contadora = 0;
            foreach ($usuarios as $usuario) {
                $contadora++;
                echo "<tr align='center'>";
                echo "<td>" . $contadora . "</td>";
                echo "<td><strong>" . $usuario->nome . "</strong></td>";
                echo "<td class='text-truncate' style='max-width: 150px;'>" . $usuario->endereco . "</td>";
                echo "<td>" . $usuario->telefone . "</td>";
                echo "<td>" . $usuario->email . "</td>";
                echo "<td>" . $usuario->tipo . "</td>";
                echo "<td><a href='../controllers/controllerUsuario.php?opcao=11&id=" . $usuario->id . "' class='btn btn-success btn-sm'>V</a> ";
                if (!$usuario->possuiServicosFuturosAPrestar && !$usuario->possuiServicosFuturosContratados) {
                    echo "<a href='../controllers/controllerUsuario.php?opcao=13&id=" . $usuario->id . "' class='btn btn-danger btn-sm'>X</a></td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
require_once 'includes/rodape.inc.php';
?>