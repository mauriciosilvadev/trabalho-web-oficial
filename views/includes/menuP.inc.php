<?php
// Menu do prestador de serviço
$usuario = $_SESSION["usuario"];
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
  <div class="container">
    <a href="index.php" class="navbar-brand d-flex align-items-center">
      <span class="fw-bold text-primary">Serviços</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a href="index.php" class="nav-link fw-semibold">
            <i class="fas fa-home me-1"></i>
            Home
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-cogs me-1"></i>
            Serviços
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="../controllers/controllerServico.php?opcao=1&opcao_redirecionamento=1">
                <i class="fas fa-eye me-2"></i>
                Visualizar
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="../controllers/controllerTipo.php?opcao=1">
                <i class="fas fa-plus me-2"></i>
                Cadastrar
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item" href="../controllers/controllerVenda.php?opcao=3">
                <i class="fas fa-chart-line me-2"></i>
                Consultar Vendidos
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="../controllers/controllerVenda.php?opcao=4">
                <i class="fas fa-list-alt me-2"></i>
                Consultar Contratados
              </a>
            </li>
          </ul>
        </li>
      </ul>

      <div class="d-flex align-items-center">
        <a class="btn btn-outline-success me-3 position-relative" href="exibirCarrinho.php">
          <i class="fas fa-shopping-cart"></i>
          <span class="visually-hidden">Carrinho</span>
        </a>

        <div class="dropdown me-3">
          <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-tie me-1"></i>
            <?= $usuario->nome ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="../controllers/controllerUsuario.php?opcao=4">
                <i class="fas fa-eye me-2"></i>
                Visualizar Cadastro
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="../views/formUsuarioAtualizarSenha.php">
                <i class="fas fa-key me-2"></i>
                Alterar Senha
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fas fa-sign-out-alt me-2"></i>
                Sair
              </a>
            </li>
          </ul>
        </div>

        <?php include_once "modal.inc.php"; ?>
      </div>
    </div>
  </div>
</nav>