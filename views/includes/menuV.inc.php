<!--Menu visitante-->
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
          <a class="nav-link fw-semibold" href="../controllers/controllerServico.php?opcao=6&opcao_redirecionamento=1">
            <i class="fas fa-cogs me-1"></i>
            Serviços
          </a>
        </li>
      </ul>

      <div class="d-flex align-items-center">
        <a class="btn btn-outline-success me-3 position-relative" href="exibirCarrinho.php">
          <i class="fas fa-shopping-cart"></i>
          <span class="visually-hidden">Carrinho</span>
        </a>
        
        <a class="btn btn-primary me-2" href="formUsuarioLogin.php">
          <i class="fas fa-sign-in-alt me-1"></i>
          Login
        </a>
        
        <a class="btn btn-outline-primary" href="formUsuario.php">
          <i class="fas fa-user-plus me-1"></i>
          Cadastrar-se
        </a>
      </div>
    </div>
  </div>
</nav>