<!-- Modal de Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h1 class="modal-title fs-5 d-flex align-items-center" id="logoutModalLabel">
          <i class="fas fa-exclamation-triangle me-2"></i>
          Confirmar Saída
        </h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div class="mb-3">
          <i class="fas fa-question-circle text-warning" style="font-size: 3rem;"></i>
        </div>
        <h5 class="mb-3">Você deseja realmente sair do sistema?</h5>
        <p class="text-muted mb-0">Sua sessão será encerrada e você precisará fazer login novamente.</p>
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <a class='btn btn-danger me-2 px-4' role='button' href='../controllers/controllerUsuario.php?opcao=2'>
          <i class="fas fa-sign-out-alt me-1"></i>
          Sim, Sair
        </a>
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i>
          Cancelar
        </button>        
      </div>
    </div>
  </div>
</div>