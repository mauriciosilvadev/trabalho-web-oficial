<?php
// Menu do cliente
$usuario = $_SESSION["usuario"];
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
  <div class="container">
    <a href="index.php" class="navbar-brand d-flex align-items-center">
      <img src="imagens/logo2.png" alt="Logo" class="me-2" style="height: 40px;">
      <span class="fw-bold text-primary">Loja Serviços</span>
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
        <li class="nav-item">
          <a class="nav-link fw-semibold" href="../controllers/controllerVenda.php?opcao=4">
            <i class="fas fa-list-alt me-1"></i>
            Serviços Contratados
          </a>
        </li>
      </ul>

      <div class="d-flex align-items-center">
        <a class="btn btn-outline-success me-3 position-relative" href="exibirCarrinho.php">
          <i class="fas fa-shopping-cart"></i>
          <span class="visually-hidden">Carrinho</span>
        </a>
        
        <div class="dropdown me-3">
          <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user me-1"></i>
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
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item text-danger" href="../controllers/controllerUsuario.php?opcao=2">
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