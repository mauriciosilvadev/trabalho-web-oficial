<?php
include_once '../utils/funcoesUteis.php';
include_once '../classes/servico.inc.php';
include_once '../classes/tipo.inc.php';
include_once '../classes/dataDisponivel.inc.php';
include_once 'includes/cabecalho.inc.php';

// Verificar se os serviços estão carregados na sessão
if (!isset($_SESSION["servicos"]) || empty($_SESSION["servicos"])) {
  // Redirecionar para carregar os serviços
  header("Location: ../controllers/controllerServico.php?opcao=6&opcao_redirecionamento=1");
  exit();
}

$servicos = $_SESSION["servicos"];

$busca = "";

if (isset($_SESSION["busca"])) {
  $busca = $_SESSION["busca"];
  unset($_SESSION["busca"]);
}

$tamanhoMaxDescricao = 50;
$tamanhoMaxNome = 50;
?>
<div class="container-fluid">
  <div class="row mb-4">
    <div class="col-12">
      <div class="text-center mb-4">
        <h1 class="h3 text-primary">
          <i class="fas fa-store me-2"></i>
          Serviços Disponíveis
        </h1>
        <p class="text-muted">Encontre e contrate os melhores serviços</p>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-lg-6 col-md-8">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <form action="../controllers/controllerServico.php" method="get">
            <input type="hidden" name="opcao" value="7">
            <div class="input-group">
              <span class="input-group-text bg-primary text-white">
                <i class="fas fa-search"></i>
              </span>
              <input type="text" id="busca" name="busca" value="<?= $busca ?>"
                class="form-control" placeholder="Buscar serviços...">
              <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-search me-2"></i>
                Buscar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
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
    <div class="row justify-content-center mb-4">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0">
            <i class="fas fa-list me-2 text-primary"></i>
            Resultados da Busca
          </h5>
          <span class="badge bg-primary fs-6"><?= count(array_filter($servicos, function ($s) {
                                                return sizeof($s->datasDisponiveis) > 0;
                                              })) ?> serviços</span>
        </div>
      </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
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
          <div class="card h-100 border-0 shadow-sm">
            <form action="../controllers/controllerCarrinho.php" method="get" id="form-servico-<?= $servico->id ?>" onsubmit="return validarSelecaoDatas(<?= $servico->id ?>)">
              <input type="hidden" name="opcao" value="3">
              <input type="hidden" name="id_servico" value="<?= $servico->id ?>">

              <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0" style="height: 60px; overflow: hidden; text-overflow: ellipsis;">
                  <i class="fas fa-tag me-2"></i>
                  <?= $servico->nome ?>
                </h5>
              </div>

              <div class="card-body d-flex flex-column">
                <p class="card-text text-muted" style="height: 50px; overflow: hidden; text-overflow: ellipsis;">
                  <i class="fas fa-align-left me-2"></i>
                  <?= $servico->descricao ?>
                </p>

                <div class="mb-3">
                  <div class="row g-2">
                    <div class="col-12">
                      <small class="text-muted">
                        <i class="fas fa-folder me-1"></i>
                        <strong>Tipo:</strong>
                        <span class="badge bg-info"><?= $servico->tipo->nome ?></span>
                      </small>
                    </div>
                    <div class="col-12">
                      <small class="text-muted">
                        <i class="fas fa-user me-1"></i>
                        <strong>Prestador:</strong> <?= $servico->nomePrestador ?>
                      </small>
                    </div>
                    <div class="col-12">
                      <small class="text-muted">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        <strong>Cidade:</strong> <?= $servico->cidade ?>
                      </small>
                    </div>
                  </div>
                </div>

                <div class="text-center mb-3">
                  <h4 class="text-success fw-bold">
                    R$ <?= number_format($servico->valor, 2, ',', '.') ?>
                  </h4>
                </div>

                <div class="mb-3">
                  <h6 class="text-primary mb-2">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Datas Disponíveis
                  </h6>
                  <div class="dropdown">
                    <button class="btn w-100 btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton-<?= $servico->id ?>" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-calendar-check me-2"></i>
                      Selecionar Datas
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton-<?= $servico->id ?>">
                      <?php foreach ($servico->datasDisponiveis as $index => $data) { ?>
                        <li>
                          <div class="form-check px-3 py-1">
                            <input class="form-check-input data-checkbox-<?= $servico->id ?>" type="checkbox" name="id_datas[]" value="<?= $data->id ?>" id="date-<?= $servico->id ?>-<?= $index ?>" onchange="verificarSelecaoDatas(<?= $servico->id ?>)">
                            <label class="form-check-label" for="date-<?= $servico->id ?>-<?= $index ?>">
                              <i class="fas fa-calendar me-2 text-muted"></i>
                              <?= formatarData($data->data) ?>
                            </label>
                          </div>
                        </li>
                      <?php } ?>
                    </ul>
                  </div>
                </div>

                <div id="msg-validacao-<?= $servico->id ?>" class="alert alert-warning alert-dismissible fade show" style="display: none;">
                  <i class="fas fa-exclamation-triangle me-2"></i>
                  <small>Selecione uma data para contratar o serviço</small>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <!-- Botão de ação -->
                <div class="mt-auto">
                  <button id="btn-contratar-<?= $servico->id ?>" class="btn btn-success w-100 btn-lg" type="submit" disabled>
                    <i class="fas fa-shopping-cart me-2"></i>
                    Contratar Serviço
                  </button>
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
        botao.classList.add('btn-success');
        mensagem.style.display = 'none';
      } else {
        botao.disabled = true;
        botao.classList.remove('btn-success');
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

    document.addEventListener('DOMContentLoaded', function() {
      <?php foreach ($servicos as $servico) {
        if (sizeof($servico->datasDisponiveis) > 0) { ?>
          verificarSelecaoDatas(<?= $servico->id ?>);
      <?php }
      } ?>
    });
  </script>

</div>

<?php require_once "includes/rodape.inc.php"; ?>