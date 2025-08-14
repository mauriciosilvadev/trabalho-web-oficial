<!--Menu visitante-->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 w-100">
  <div class="container">
    <a href="index.php" class="navbar-brand d-flex align-items-center">
      <img src="imagens/loucos-por-servico.png" alt="Loucos por Serviços" height="60" class="me-2">
      <span class="fw-bold text-primary">Loucos por Serviços</span>
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