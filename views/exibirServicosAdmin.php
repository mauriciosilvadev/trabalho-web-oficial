<?php
require_once '../classes/servico.inc.php';
require_once 'includes/cabecalho.inc.php';

$servicos = $_SESSION['servicos'];
?>
<p>
<h1 class="text-center">Serviços cadastrados</h1>
<p>
<div class="table-responsive">
    <table class="table table-light table-hover">
        <thead class="table-primary">
            <tr class="align-middle" style="text-align: center">
                <th witdh="10%">ID</th>
                <th>Prestador</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Cidade</th>
                <th>Tipo</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $contadora = 0;
            foreach ($servicos as $servico) {
                $contadora++;
                echo "<tr align='center'>";
                echo "<td>" . $contadora . "</td>";
                echo "<td><strong>" . $servico->nomePrestador . "</strong></td>";
                echo "<td>" . $servico->nome . "</td>";
                echo "<td class='text-truncate' style='max-width: 150px;'>" . $servico->descricao . "</td>";
                echo "<td>" . $servico->valor . "</td>";
                echo "<td>" . $servico->cidade . "</td>";
                echo "<td>" . $servico->tipo->nome . "</td>";
                echo "<td><a href='../controllers/controllerServico.php?opcao=3&id=". $servico->id ."' class='btn btn-success btn-sm'>V</a> ";
                if(!$servico->possuiServicoAFazer){
                    echo "<a href='../controllers/controllerServico.php?opcao=5&id=". $servico->id ."' class='btn btn-danger btn-sm'>X</a></td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    if ($contadora == 0) {
        require_once 'includes/servicosVazios.inc.php';
    }
    ?>

</div>

<?php
require_once 'includes/rodape.inc.php';
?>