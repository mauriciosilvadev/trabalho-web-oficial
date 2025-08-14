<?php
// Menu do administrador
$usuario = $_SESSION["usuario"];
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
  <div class="container">
    <a href="index.php" class="navbar-brand d-flex align-items-center">
      <span class="fw-bold text-warning">Loja Serviços</span>
      <span class="badge bg-warning text-dark ms-2">Admin</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-cogs me-1"></i>
            Serviços
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="../controllers/controllerServico.php?opcao=10">
                <i class="fas fa-eye me-2"></i>
                Visualizar
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="../controllers/controllerVenda.php?opcao=10">
                <i class="fas fa-search me-2"></i>
                Consultar
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="../controllers/controllerUsuario.php?opcao=10" class="nav-link fw-semibold">
            <i class="fas fa-users me-1"></i>
            Usuários
          </a>
        </li>
      </ul>

      <div class="d-flex align-items-center">
        <div class="dropdown">
          <button class="btn btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-shield me-1"></i>
            <?= $usuario->nome ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
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