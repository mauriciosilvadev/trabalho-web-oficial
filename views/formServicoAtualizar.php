<?php
require_once "../classes/tipo.inc.php";
require_once "../classes/servico.inc.php";
require_once "../utils/funcoesUteis.php";
require_once "includes/cabecalho.inc.php";

$tipos = $_SESSION["tipos"];
$servico = $_SESSION["servico"];
?>
<p>
<h1 class="text-center">Atualização de serviço</h1>
<p>

<form class="row g-3" action="../controllers/controllerServico.php" method="post">
  <div class="col-md-6">
    <label for="nome" class="form-label">Nome: </label>
    <input type="text" class="form-control" name="nome" required
      minlength="10" maxlength="50" value="<?=$servico->nome?>">
  </div>
  <div class="col-md-3">
    <label for="valor" class="form-label">Valor: </label>
    <input type="number" class="form-control" min="0.01" name="valor" required value="<?=$servico->valor?>" lang="pt-BR" step="0.01">
  </div>
  <div class="col-md-3">
    <label for="tipo" class="form-label">Tipo: </label>
    <select name="tipo" class="form-select" required>
      <option disabled value="">Escolha...</option>
      <?php
      foreach ($tipos as $t) {
        echo "<option " . ($t->id == $servico->idTipo ? "selected" : "") . " value=$t->id>$t->nome</option>";
      }
      ?>
    </select>
  </div>

  <div class="col-md-4">
    <label for="cidade" class="form-label">Cidade: </label>
    <input type="text" class="form-control" minlength="3" maxlength="50" 
    name="cidade" id="cidade" required value="<?=$servico->cidade?>">
  </div>

  <div class="col-md-8">
    <label for="descricao" class="form-label">Descrição do serviço: </label>
    <input type="text" class="form-control" minlength="10" maxlength="50" 
    required name="descricao" id="descricao" value="<?=$servico->descricao?>">
  </div>

  <div class="col-md-8 col-lg-6" id="datas">
    <div class="d-flex">
      <label for="dates" class="form-label me-auto">Datas: </label>
      <button type="button" onclick="addDate()" class="mb-2 btn btn-primary mx-1"
        style="min-width: 100px;">Adicionar</button>
    </div>
    <?php
    $contador = 0;
    foreach ($servico->datasDisponiveis as $d) {
    ?>

      <div class="d-flex" id="data<?=$contador?>">

        <input type="date" name="datas[]" oninput="validarData()"
          class="form-control mb-2 data_input" <?=$d->disponivel ? "required": "disabled"?> value="<?=parseISO($d->data)?>">

        <?php
        if ($d->disponivel) {
        ?>

          <button type="button" onclick="removeDate(<?=$contador?>)"
            class="mb-2 btn btn-outline-danger mx-1" style="min-width: 100px;">Remover</button>

        <?php
        }
        ?>

      </div>

    <?php
      $contador++;
    }
    ?>
  </div>

  <input type="hidden" name="opcao" value="4">
  <input type="hidden" name="id" value="<?=$servico->id?>">
  <input type="hidden" name="idPrestador" value="<?=$servico->idPrestador?>">

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Atualizar</button>
    <button type="button" class="btn btn-danger">
      <a href="../controllers/controllerServico.php?opcao=1" class="text-reset text-decoration-none">
        Cancelar
      </a>
    </button>
  </div>

  <?php
    require_once "includes/mensagens.inc.php";
  ?>
</form>

<script src="includes/scripts/validacoesFormServico.js"></script>
<script src="includes/scripts/adicionarRemoverDatasDisponiveis.js"></script>

<?php
require_once 'includes/rodape.inc.php';
?>