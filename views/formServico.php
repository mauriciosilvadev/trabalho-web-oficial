<?php
require_once "../classes/tipo.inc.php";
require_once "../utils/funcoesUteis.php";
require_once "includes/cabecalho.inc.php";

$tipos = $_SESSION["tipos"];
?>
<p>
<h1 class="text-center">Inclusão de serviço</h1>
<p>

<form class="row g-3" action="../controllers/controllerServico.php" method="post">
  <div class="col-md-6">
    <label for="nome" class="form-label">Nome: </label>
    <input type="text" class="form-control" name="nome" minlength="10" maxlength="50" required>
  </div>
  <div class="col-md-3">
    <label for="valor" class="form-label">Valor: </label>
    <input type="number" class="form-control" name="valor" lang="pt-BR" step="0.01" min="0.01" required>
  </div>
  <div class="col-md-3">
    <label for="tipo" class="form-label">Tipo: </label>
    <select name="tipo" class="form-select" required>
      <option disabled selected value="">Escolha...</option>
      <?php
      foreach ($tipos as $t) {
        echo "<option value=$t->id>$t->nome</option>";
      }
      ?>
    </select>
  </div>

  <div class="col-md-4">
    <label for="cidade" class="form-label">Cidade: </label>
    <input type="text" class="form-control" minlength="3" maxlength="50" name="cidade" id="cidade" required>
  </div>

  <div class="col-md-8">
    <label for="descricao" class="form-label">Descrição do serviço: </label>
    <input type="text" class="form-control" minlength="10" maxlength="50" name="descricao" id="descricao" required>
  </div>

  <div class="col-md-8 col-lg-6" id="datas">
    <div class="d-flex">
      <label for="dates" class="form-label me-auto">Datas: </label>
      <button type="button" onclick="addDate()" class="mb-2 btn btn-primary mx-1" style="min-width: 100px;">Adicionar</button>
    </div>
    <div class="d-flex" id="data0">
      <input type="date" name="datas[]" oninput="validarData()" class="form-control mb-2 data_input" required>
      <button type="button" onclick="removeDate(0)" class="mb-2 btn btn-outline-danger mx-1" style="min-width: 100px;">Remover</button>
    </div>
  </div>

  <input type="hidden" name="opcao" value="2">

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Incluir</button>
    <button type="reset" class="btn btn-danger">Cancelar</button>
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