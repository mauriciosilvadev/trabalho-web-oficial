<?php
require_once 'includes/cabecalho.inc.php';

if (!isset($_SESSION["soma"]) || !isset($_SESSION["carrinho"])) {
    header("Location: ../views/exibirCarrinho.php");
    exit();
}

$valorTotal = $_SESSION["soma"];
$chavePixEmpresa = "mauricio.s.souze@edu.ufes";
$nomeEmpresa = "Loucos por Serviços";
$cidadeEmpresa = "Alegre";
$identificadorTransacao = "TXN" . date("YmdHis") . rand(1000, 9999);
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <h1 class="h3 text-primary">
                    <i class="fas fa-qrcode me-2"></i>
                    Pagamento via PIX
                </h1>
                <p class="text-muted">Escaneie o QR Code ou copie a chave PIX</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0 text-center">
                    <i class="fas fa-mobile-alt me-2"></i>
                    Instruções de Pagamento PIX
                </h5>
            </div>
            <div class="card-body p-4">

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="fas fa-receipt me-2"></i>
                                    Resumo do Pedido
                                </h6>
                                <p class="mb-2"><strong>Valor Total:</strong> <span class="text-success fs-4">R$ <?= number_format($valorTotal, 2, ',', '.') ?></span></p>
                                <p class="mb-2"><strong>Identificador:</strong> <?= $identificadorTransacao ?></p>
                                <p class="mb-0"><strong>Beneficiário:</strong> <?= $nomeEmpresa ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 text-center">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="fas fa-qrcode me-2"></i>
                                    QR Code PIX
                                </h6>
                                <div class="qr-code-container mb-3">
                                    <svg width="200" height="200" viewBox="0 0 200 200" class="border">
                                        <rect width="200" height="200" fill="white" />
                                        <g fill="black">
                                            <rect x="10" y="10" width="60" height="60" />
                                            <rect x="130" y="10" width="60" height="60" />
                                            <rect x="10" y="130" width="60" height="60" />

                                            <rect x="20" y="20" width="40" height="40" fill="white" />
                                            <rect x="140" y="20" width="40" height="40" fill="white" />
                                            <rect x="20" y="140" width="40" height="40" fill="white" />

                                            <rect x="30" y="30" width="20" height="20" />
                                            <rect x="150" y="30" width="20" height="20" />
                                            <rect x="30" y="150" width="20" height="20" />

                                            <rect x="80" y="20" width="10" height="10" />
                                            <rect x="100" y="20" width="10" height="10" />
                                            <rect x="80" y="40" width="10" height="10" />
                                            <rect x="110" y="40" width="10" height="10" />
                                            <rect x="90" y="60" width="10" height="10" />
                                            <rect x="80" y="80" width="10" height="10" />
                                            <rect x="100" y="80" width="10" height="10" />
                                            <rect x="120" y="80" width="10" height="10" />
                                            <rect x="90" y="100" width="10" height="10" />
                                            <rect x="110" y="100" width="10" height="10" />
                                            <rect x="80" y="120" width="10" height="10" />
                                            <rect x="100" y="120" width="10" height="10" />
                                            <rect x="120" y="120" width="10" height="10" />
                                            <rect x="140" y="120" width="10" height="10" />
                                            <rect x="160" y="120" width="10" height="10" />
                                            <rect x="80" y="140" width="10" height="10" />
                                            <rect x="100" y="140" width="10" height="10" />
                                            <rect x="120" y="140" width="10" height="10" />
                                            <rect x="140" y="140" width="10" height="10" />
                                            <rect x="160" y="140" width="10" height="10" />
                                            <rect x="80" y="160" width="10" height="10" />
                                            <rect x="100" y="160" width="10" height="10" />
                                            <rect x="120" y="160" width="10" height="10" />
                                            <rect x="140" y="160" width="10" height="10" />
                                            <rect x="160" y="160" width="10" height="10" />
                                            <rect x="80" y="180" width="10" height="10" />
                                            <rect x="100" y="180" width="10" height="10" />
                                            <rect x="120" y="180" width="10" height="10" />
                                            <rect x="140" y="180" width="10" height="10" />
                                            <rect x="160" y="180" width="10" height="10" />
                                        </g>
                                    </svg>
                                </div>
                                <small class="text-muted">Escaneie com seu app bancário</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-info">
                            <div class="card-body">
                                <h6 class="card-title text-info">
                                    <i class="fas fa-key me-2"></i>
                                    Chave PIX para Cópia
                                </h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="chavePix" value="<?= $chavePixEmpresa ?>" readonly>
                                    <button class="btn btn-outline-info" type="button" onclick="copiarChavePix()">
                                        <i class="fas fa-copy me-1"></i>
                                        Copiar
                                    </button>
                                </div>
                                <small class="text-muted mt-2 d-block">Cole esta chave no seu app bancário para fazer o pagamento</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h6 class="card-title text-warning">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Como Pagar
                                </h6>
                                <ol class="mb-0">
                                    <li>Abra o aplicativo do seu banco</li>
                                    <li>Acesse a área PIX</li>
                                    <li>Escolha "Pagar com QR Code" ou "Pagar com Chave PIX"</li>
                                    <li>Escaneie o código ou cole a chave PIX</li>
                                    <li>Confirme o valor de <strong>R$ <?= number_format($valorTotal, 2, ',', '.') ?></strong></li>
                                    <li>Finalize o pagamento</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-lg w-100" onclick="confirmarPagamento()">
                                <i class="fas fa-check me-2"></i>
                                Já Paguei
                            </button>
                        </div>
                        <div class="col-md-6">
                            <a href="dadosPagamento.php" class="btn btn-outline-secondary btn-lg w-100">
                                <i class="fas fa-arrow-left me-2"></i>
                                Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copiarChavePix() {
        const chavePix = document.getElementById('chavePix');
        chavePix.select();
        chavePix.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(chavePix.value).then(function() {
            const botao = event.target.closest('button');
            const textoOriginal = botao.innerHTML;
            botao.innerHTML = '<i class="fas fa-check me-1"></i>Copiado!';
            botao.classList.remove('btn-outline-info');
            botao.classList.add('btn-success');

            setTimeout(function() {
                botao.innerHTML = textoOriginal;
                botao.classList.remove('btn-success');
                botao.classList.add('btn-outline-info');
            }, 2000);
        });
    }

    function confirmarPagamento() {
        if (confirm('Confirma que o pagamento PIX foi realizado?')) {
            window.location.href = '../controllers/controllerVenda.php?opcao=1&pag=pix';
        }
    }
</script>

<style>
    .qr-code-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
    }
</style>

<?php
require_once('includes/rodape.inc.php');
?>