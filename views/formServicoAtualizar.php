<?php
require_once "../classes/tipo.inc.php";
require_once "../classes/servico.inc.php";
require_once "../utils/funcoesUteis.php";
require_once "includes/cabecalho.inc.php";

$tipos = $_SESSION["tipos"];
$servico = $_SESSION["servico"];
?>
<div class="d-flex justify-content-center align-items-center mb-4">
  <h1 class="text-primary mb-0">
    <i class="fas fa-edit me-2"></i>
    Atualização de Serviço
  </h1>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <form class="row g-3" action="../controllers/controllerServico.php" method="post">
      <div class="col-md-6">
        <label for="nome" class="form-label">
          <i class="fas fa-tag text-primary me-1"></i>
          Nome do Serviço:
        </label>
        <input type="text" class="form-control" name="nome" required
          minlength="10" maxlength="50" value="<?= $servico->nome ?>" placeholder="Digite o nome do serviço">
      </div>
      <div class="col-md-3">
        <label for="valor" class="form-label">
          <i class="fas fa-dollar-sign text-success me-1"></i>
          Valor:
        </label>
        <input type="number" class="form-control" min="0.01" name="valor" required value="<?= $servico->valor ?>" lang="pt-BR" step="0.01" placeholder="0,00">
      </div>
      <div class="col-md-3">
        <label for="tipo" class="form-label">
          <i class="fas fa-list text-info me-1"></i>
          Tipo:
        </label>
        <select name="tipo" class="form-select" required>
          <option disabled value="">Escolha o tipo...</option>
          <?php
          foreach ($tipos as $t) {
            echo "<option " . ($t->id == $servico->idTipo ? "selected" : "") . " value=$t->id>$t->nome</option>";
          }
          ?>
        </select>
      </div>

      <div class="col-md-4">
        <label for="cidade" class="form-label">
          <i class="fas fa-map-marker-alt text-danger me-1"></i>
          Cidade:
        </label>
        <input type="text" class="form-control" minlength="3" maxlength="50"
          name="cidade" id="cidade" required value="<?= $servico->cidade ?>" placeholder="Digite a cidade">
      </div>

      <div class="col-md-8">
        <label for="descricao" class="form-label">
          <i class="fas fa-align-left text-secondary me-1"></i>
          Descrição do Serviço:
        </label>
        <input type="text" class="form-control" minlength="10" maxlength="50"
          required name="descricao" id="descricao" value="<?= $servico->descricao ?>" placeholder="Descreva o serviço">
      </div>

      <div class="col-md-8 col-lg-6" id="datas">
        <div class="d-flex align-items-center mb-3">
          <label for="dates" class="form-label me-auto mb-0">
            <i class="fas fa-calendar-alt text-warning me-1"></i>
            Datas Disponíveis:
          </label>
          <button type="button" onclick="addDate()" class="btn btn-success btn-sm"
            style="min-width: 120px;">
            <i class="fas fa-plus me-1"></i>
            Adicionar Data
          </button>
        </div>
        <?php
        $contador = 0;
        foreach ($servico->datasDisponiveis as $d) {
        ?>

          <div class="d-flex" id="data<?= $contador ?>">

            <input type="date" name="datas[]" oninput="validarData()"
              class="form-control mb-2 data_input" <?= $d->disponivel ? "required" : "disabled" ?> value="<?= parseISO($d->data) ?>">

            <?php
            if ($d->disponivel) {
            ?>

              <button type="button" onclick="removeDate(<?= $contador ?>)"
                class="mb-2 btn btn-outline-danger btn-sm mx-1" style="min-width: 100px;">
                <i class="fas fa-trash me-1"></i>
                Remover
              </button>

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
      <input type="hidden" name="id" value="<?= $servico->id ?>">
      <input type="hidden" name="idPrestador" value="<?= $servico->idPrestador ?>">

      <div class="col-12 mt-4">
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-save me-2"></i>
            Atualizar Serviço
          </button>
          <a href="../controllers/controllerServico.php?opcao=1" class="btn btn-outline-secondary btn-lg">
            <i class="fas fa-times me-2"></i>
            Cancelar
          </a>
        </div>
      </div>

      <?php
      require_once "includes/mensagens.inc.php";
      ?>
    </form>
  </div>
</div>

<script src="includes/scripts/validacoesFormServico.js"></script>
<script src="includes/scripts/adicionarRemoverDatasDisponiveis.js"></script>

<?php
require_once 'includes/rodape.inc.php';
?>