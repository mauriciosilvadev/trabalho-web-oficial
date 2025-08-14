<?php
require_once 'includes/cabecalho.inc.php';
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <h1 class="h3 text-primary">
                    <i class="fas fa-credit-card me-2"></i>
                    Forma de Pagamento
                </h1>
                <p class="text-muted">Selecione como deseja efetuar o pagamento</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 text-center">
                    <i class="fas fa-payment me-2"></i>
                    Escolha sua Opção de Pagamento
                </h5>
            </div>
            <div class="card-body p-4">
                <form id="formPagamento" action="../controllers/controllerVenda.php" method="get">
                    <div class="row g-3">

                        <!-- Boleto Bancário -->
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input d-none" type="radio" name="pag" value="boleto" id="boleto" required>
                                <label class="form-check-label w-100" for="boleto">
                                    <div class="card h-100 payment-option">
                                        <div class="card-body text-center p-4">
                                            <i class="fas fa-barcode text-primary" style="font-size: 2.5rem;"></i>
                                            <h6 class="mt-3 mb-2">Boleto Bancário</h6>
                                            <small class="text-muted">Pagamento em até 3 dias úteis</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- PIX -->
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input d-none" type="radio" name="pag" value="pix" id="pix">
                                <label class="form-check-label w-100" for="pix">
                                    <div class="card h-100 payment-option">
                                        <div class="card-body text-center p-4">
                                            <i class="fas fa-qrcode text-info" style="font-size: 2.5rem;"></i>
                                            <h6 class="mt-3 mb-2">PIX</h6>
                                            <small class="text-muted">Transferência instantânea</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>

                    <input type="hidden" value="1" name="opcao">

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-success btn-lg px-5" onclick="processarPagamento()">
                            <i class="fas fa-check me-2"></i>
                            Confirmar Pagamento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .payment-option {
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .payment-option:hover {
        border-color: #007bff;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.1);
    }

    .form-check-input:checked+.form-check-label .payment-option {
        border-color: #007bff;
        background-color: #f8f9ff;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
    }

    .form-check-label {
        cursor: pointer;
    }
</style>

<script>
    function processarPagamento() {
        const formaPagamento = document.querySelector('input[name="pag"]:checked');

        if (!formaPagamento) {
            alert('Por favor, selecione uma forma de pagamento.');
            return;
        }

        const valorPagamento = formaPagamento.value;

        // Redirecionar para páginas específicas de pagamento
        switch (valorPagamento) {
            case 'pix':
                window.location.href = 'pagamentoPix.php';
                break;
            case 'boleto':
                window.location.href = 'pagamentoBoleto.php';
                break;
            case 'crédito':
            case 'debito':
                // Para cartão, processar diretamente
                window.location.href = '../controllers/controllerVenda.php?opcao=1&pag=' + valorPagamento;
                break;
            default:
                alert('Forma de pagamento não reconhecida.');
        }
    }
</script>
<?php
require_once('includes/rodape.inc.php');
?>