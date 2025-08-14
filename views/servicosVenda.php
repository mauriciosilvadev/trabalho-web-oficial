<?php
include_once '../utils/funcoesUteis.php';
include_once '../classes/servico.inc.php';
include_once '../classes/tipo.inc.php';
include_once '../classes/dataDisponivel.inc.php';
include_once 'includes/cabecalho.inc.php';

$servicos = $_SESSION["servicos"];

$busca = "";

if (isset($_SESSION["busca"])) {
  $busca = $_SESSION["busca"];
  unset($_SESSION["busca"]);
}

$tamanhoMaxDescricao = 50;
$tamanhoMaxNome = 50;
?>
<h1 class="text-center">Serviços Disponíveis</h1>

<div class="col-md-6 mb-3">
  <form action="../controllers/controllerServico.php" method="get" class="row g-3 align-items-center">
    <input type="hidden" name="opcao" value="7">
    <div class="col-auto">
      <label for="busca" class="col-form-label">Busca:</label>
    </div>
    <div class="d-flex col-10 col-md-10">
      <input type="text" id="busca" name="busca" value="<?= $busca ?>" class="form-control me-2" placeholder="Digite aqui">
      <button type="submit" class="btn btn-info">Buscar</button>
    </div>
  </form>
</div>

<?php
$possuiServicoComDatasDisponivel = false;

foreach ($servicos as $servico) {
  if (sizeof($servico->datasDisponiveis) > 0) {
    $possuiServicoComDatasDisponivel = true;
    break;
  }
}

if (!$possuiServicoComDatasDisponivel) {
  $title = "Nenhum serviço cadastrado";
  $message = "Volte mais tarde, pois não há serviços cadastrados com datas disponíveis.<br>Por favor, tente novamente mais tarde.";
  if ($busca != "") {
    $title = "Nenhum serviço encontrado";
    $message = "Não foi encontrado nenhum serviço com os critérios de busca informados.";
  }
  require_once "includes/carrinhoBuscaVazia.php";
} else {
?>
  <div class="row row-cols-1 row-cols-md-3 g-4">

    <?php
    foreach ($servicos as $servico) {
      if (sizeof($servico->datasDisponiveis) == 0) {
        continue;
      }
      $c = $tamanhoMaxDescricao - strlen($servico->descricao) - 1;
      $c = $c > 0 ? $c : 0;

      $n = $tamanhoMaxNome - strlen($servico->nome) - 1;
      $n = $n > 0 ? $n : 0;
    ?>

      <div class="col">
        <div class="card">
          <form action="../controllers/controllerCarrinho.php" method="get" id="form-servico-<?= $servico->id ?>" onsubmit="return validarSelecaoDatas(<?= $servico->id ?>)">
            <input type="hidden" name="opcao" value="3">
            <input type="hidden" name="id_servico" value="<?= $servico->id ?>">
            <div class="card-body">
              <h5 class="card-title" style="height: 60px; overflow: hidden; text-overflow: ellipsis;"><?= $servico->nome ?></h5>
              <p class="card-text" style="height: 50px; overflow: hidden; text-overflow: ellipsis;"><?= $servico->descricao ?></p>
              <h6 class="card-text">Tipo: <?= $servico->tipo->nome ?></h6>
              <h6 class="card-text">Prestador: <?= $servico->nomePrestador ?></h6>
              <h6 class="card-text text-end"><?= $servico->cidade ?></h6>
              <h4 class="card-title">R$ <?= number_format($servico->valor, 2, ',', '.') ?></h4>

              <!-- Datas para seleção com lista suspensa -->
              <p class="card-text"><strong>Datas Disponíveis:</strong></p>
              <div class="dropdown">
                <button class="btn w-100 btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                  Selecionar Datas
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                  <?php foreach ($servico->datasDisponiveis as $index => $data) { ?>
                    <li>
                      <div class="form-check px-3">
                        <input class="form-check-input data-checkbox-<?= $servico->id ?>" type="checkbox" name="id_datas[]" value="<?= $data->id ?>" id="date-<?= $servico->id ?>-<?= $index ?>" onchange="verificarSelecaoDatas(<?= $servico->id ?>)">
                        <label class="form-check-label" for="date-<?= $servico->id ?>-<?= $index ?>">
                          <?= formatarData($data->data) ?>
                        </label>
                      </div>
                    </li>
                  <?php } ?>
                </ul>
              </div>

              <!-- Mensagem de validação -->
              <div id="msg-validacao-<?= $servico->id ?>" class="alert alert-warning mt-2" style="display: none;">
                <small>Selecione uma data para contratar o serviço</small>
              </div>

              <!-- Botão de ação -->
              <div class="text-end mt-3">
                <button id="btn-contratar-<?= $servico->id ?>" class="btn btn-danger" type="submit" disabled>Contratar</button>
              </div>
            </div>
          </form>
        </div>
      </div>

    <?php
    }
    ?>
  </div>

<?php
}
?>

<script>
function verificarSelecaoDatas(servicoId) {
  const checkboxes = document.querySelectorAll('.data-checkbox-' + servicoId);
  const botao = document.getElementById('btn-contratar-' + servicoId);
  const mensagem = document.getElementById('msg-validacao-' + servicoId);
  
  let algumSelecionado = false;
  
  checkboxes.forEach(function(checkbox) {
    if (checkbox.checked) {
      algumSelecionado = true;
    }
  });
  
  if (algumSelecionado) {
    botao.disabled = false;
    botao.classList.remove('btn-secondary');
    botao.classList.add('btn-danger');
    mensagem.style.display = 'none';
  } else {
    botao.disabled = true;
    botao.classList.remove('btn-danger');
    botao.classList.add('btn-secondary');
    mensagem.style.display = 'block';
  }
}

function validarSelecaoDatas(servicoId) {
  const checkboxes = document.querySelectorAll('.data-checkbox-' + servicoId);
  let algumSelecionado = false;
  
  checkboxes.forEach(function(checkbox) {
    if (checkbox.checked) {
      algumSelecionado = true;
    }
  });
  
  if (!algumSelecionado) {
    alert('Por favor, selecione pelo menos uma data para contratar o serviço.');
    return false;
  }
  
  return true;
}

// Inicializar estado dos botões quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
  <?php foreach ($servicos as $servico) { 
    if (sizeof($servico->datasDisponiveis) > 0) { ?>
      verificarSelecaoDatas(<?= $servico->id ?>);
    <?php } 
  } ?>
});
</script>

<?php require_once "includes/rodape.inc.php"; ?>