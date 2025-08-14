<?php
require_once 'includes/cabecalho.inc.php';

if (!isset($_SESSION["soma"]) || !isset($_SESSION["carrinho"])) {
    header("Location: ../views/exibirCarrinho.php");
    exit();
}

$valorTotal = $_SESSION["soma"];
$nomeEmpresa = "Loucos por Serviços";
$cnpjEmpresa = "12.345.678/0001-90";
$enderecoEmpresa = "Rua das Flores, 123 - Alegre/ES";
$numeroBoleto = date("Y") . date("m") . date("d") . rand(100000, 999999);
$dataVencimento = date("d/m/Y", strtotime("+3 days"));
$codigoBarras = "34191" . substr($numeroBoleto, -10) . "0" . str_replace(".", "", number_format($valorTotal * 100, 0, "", "")) . "0000000000000000000000000000000000000000000000";
$linhaDigitavel = substr($codigoBarras, 0, 4) . " " . substr($codigoBarras, 4, 5) . " " . substr($codigoBarras, 9, 5) . " " . substr($codigoBarras, 14, 6) . " " . substr($codigoBarras, 20, 5) . " " . substr($codigoBarras, 25, 6) . " " . substr($codigoBarras, 31, 1) . " " . substr($codigoBarras, 32);
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-4">
                <h1 class="h3 text-primary">
                    <i class="fas fa-barcode me-2"></i>
                    Boleto Bancário
                </h1>
                <p class="text-muted">Imprima ou salve o boleto para pagamento</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-file-invoice me-2"></i>
                    Boleto de Cobrança
                </h5>
                <div>
                    <button class="btn btn-light btn-sm me-2" onclick="window.print()">
                        <i class="fas fa-print me-1"></i>
                        Imprimir
                    </button>
                    <button class="btn btn-outline-light btn-sm" onclick="copiarLinhaDigitavel()">
                        <i class="fas fa-copy me-1"></i>
                        Copiar Código
                    </button>
                </div>
            </div>
            <div class="card-body p-0">

                <div class="boleto-header p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <div class="banco-logo text-center">
                                <div class="bg-primary text-white p-3 rounded">
                                    <h4 class="mb-0">341-7</h4>
                                    <small>ITAÚ</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <h5 class="mb-1">Banco Itaú S.A.</h5>
                            <p class="mb-0 text-muted">www.itau.com.br</p>
                        </div>
                        <div class="col-md-3 text-end">
                            <h6 class="mb-1">Boleto Nº</h6>
                            <strong><?= $numeroBoleto ?></strong>
                        </div>
                    </div>
                </div>

                <div class="linha-digitavel p-3 bg-light border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Linha Digitável:</label>
                            <input type="text" class="form-control form-control-lg" id="linhaDigitavel" value="<?= $linhaDigitavel ?>" readonly>
                        </div>
                        <div class="col-md-4 text-end">
                            <label class="form-label fw-bold">Vencimento:</label>
                            <div class="fs-4 text-danger fw-bold"><?= $dataVencimento ?></div>
                        </div>
                    </div>
                </div>

                <div class="beneficiario p-4 border-bottom">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-building me-2"></i>
                                Beneficiário
                            </h6>
                            <p class="mb-1"><strong><?= $nomeEmpresa ?></strong></p>
                            <p class="mb-1">CNPJ: <?= $cnpjEmpresa ?></p>
                            <p class="mb-0"><?= $enderecoEmpresa ?></p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-dollar-sign me-2"></i>
                                Valor
                            </h6>
                            <div class="fs-2 text-success fw-bold">R$ <?= number_format($valorTotal, 2, ',', '.') ?></div>
                        </div>
                    </div>
                </div>

                <div class="pagador p-4 border-bottom">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-user me-2"></i>
                        Pagador
                    </h6>
                    <?php if (isset($_SESSION["usuario"])): ?>
                        <p class="mb-1"><strong><?= $_SESSION["usuario"]->nome ?></strong></p>
                        <p class="mb-1">Email: <?= $_SESSION["usuario"]->email ?></p>
                        <p class="mb-0">CPF: ***.***.***-**</p>
                    <?php else: ?>
                        <p class="mb-0">Dados do pagador serão preenchidos no momento do pagamento</p>
                    <?php endif; ?>
                </div>

                <div class="instrucoes p-4 border-bottom">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Instruções de Pagamento
                    </h6>
                    <ul class="mb-0">
                        <li>Pagamento válido até <?= $dataVencimento ?></li>
                        <li>Após o vencimento, será cobrada multa de 2% + juros de 1% ao mês</li>
                        <li>Pagamento pode ser feito em qualquer banco, lotérica ou internet banking</li>
                        <li>Em caso de dúvidas, entre em contato: (28) 9999-9999</li>
                        <li>Não receber dinheiro em espécie</li>
                    </ul>
                </div>

                <div class="codigo-barras p-4">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-barcode me-2"></i>
                        Código de Barras
                    </h6>
                    <div class="barcode-container text-center mb-3">
                        <svg width="100%" height="60" viewBox="0 0 400 60" class="border">
                            <rect width="400" height="60" fill="white" />
                            <g fill="black">
                                <rect x="10" y="10" width="2" height="40" />
                                <rect x="15" y="10" width="1" height="40" />
                                <rect x="18" y="10" width="3" height="40" />
                                <rect x="23" y="10" width="1" height="40" />
                                <rect x="26" y="10" width="2" height="40" />
                                <rect x="30" y="10" width="1" height="40" />
                                <rect x="33" y="10" width="2" height="40" />
                                <rect x="37" y="10" width="1" height="40" />
                                <rect x="40" y="10" width="3" height="40" />
                                <rect x="45" y="10" width="1" height="40" />
                                <rect x="48" y="10" width="2" height="40" />
                                <rect x="52" y="10" width="1" height="40" />
                                <rect x="55" y="10" width="2" height="40" />
                                <rect x="59" y="10" width="3" height="40" />
                                <rect x="64" y="10" width="1" height="40" />
                                <rect x="67" y="10" width="2" height="40" />
                                <rect x="71" y="10" width="1" height="40" />
                                <rect x="74" y="10" width="3" height="40" />
                                <rect x="79" y="10" width="1" height="40" />
                                <rect x="82" y="10" width="2" height="40" />
                                <rect x="86" y="10" width="1" height="40" />
                                <rect x="89" y="10" width="2" height="40" />
                                <rect x="93" y="10" width="3" height="40" />
                                <rect x="98" y="10" width="1" height="40" />
                                <rect x="101" y="10" width="2" height="40" />
                                <rect x="105" y="10" width="1" height="40" />
                                <rect x="108" y="10" width="3" height="40" />
                                <rect x="113" y="10" width="1" height="40" />
                                <rect x="116" y="10" width="2" height="40" />
                                <rect x="120" y="10" width="1" height="40" />
                                <rect x="123" y="10" width="2" height="40" />
                                <rect x="127" y="10" width="3" height="40" />
                                <rect x="132" y="10" width="1" height="40" />
                                <rect x="135" y="10" width="2" height="40" />
                                <rect x="139" y="10" width="1" height="40" />
                                <rect x="142" y="10" width="3" height="40" />
                                <rect x="147" y="10" width="1" height="40" />
                                <rect x="150" y="10" width="2" height="40" />
                                <rect x="154" y="10" width="1" height="40" />
                                <rect x="157" y="10" width="2" height="40" />
                                <rect x="161" y="10" width="3" height="40" />
                                <rect x="166" y="10" width="1" height="40" />
                                <rect x="169" y="10" width="2" height="40" />
                                <rect x="173" y="10" width="1" height="40" />
                                <rect x="176" y="10" width="3" height="40" />
                                <rect x="181" y="10" width="1" height="40" />
                                <rect x="184" y="10" width="2" height="40" />
                                <rect x="188" y="10" width="1" height="40" />
                                <rect x="191" y="10" width="2" height="40" />
                                <rect x="195" y="10" width="3" height="40" />
                                <rect x="200" y="10" width="1" height="40" />
                                <rect x="203" y="10" width="2" height="40" />
                                <rect x="207" y="10" width="1" height="40" />
                                <rect x="210" y="10" width="3" height="40" />
                                <rect x="215" y="10" width="1" height="40" />
                                <rect x="218" y="10" width="2" height="40" />
                                <rect x="222" y="10" width="1" height="40" />
                                <rect x="225" y="10" width="2" height="40" />
                                <rect x="229" y="10" width="3" height="40" />
                                <rect x="234" y="10" width="1" height="40" />
                                <rect x="237" y="10" width="2" height="40" />
                                <rect x="241" y="10" width="1" height="40" />
                                <rect x="244" y="10" width="3" height="40" />
                                <rect x="249" y="10" width="1" height="40" />
                                <rect x="252" y="10" width="2" height="40" />
                                <rect x="256" y="10" width="1" height="40" />
                                <rect x="259" y="10" width="2" height="40" />
                                <rect x="263" y="10" width="3" height="40" />
                                <rect x="268" y="10" width="1" height="40" />
                                <rect x="271" y="10" width="2" height="40" />
                                <rect x="275" y="10" width="1" height="40" />
                                <rect x="278" y="10" width="3" height="40" />
                                <rect x="283" y="10" width="1" height="40" />
                                <rect x="286" y="10" width="2" height="40" />
                                <rect x="290" y="10" width="1" height="40" />
                                <rect x="293" y="10" width="2" height="40" />
                                <rect x="297" y="10" width="3" height="40" />
                                <rect x="302" y="10" width="1" height="40" />
                                <rect x="305" y="10" width="2" height="40" />
                                <rect x="309" y="10" width="1" height="40" />
                                <rect x="312" y="10" width="3" height="40" />
                                <rect x="317" y="10" width="1" height="40" />
                                <rect x="320" y="10" width="2" height="40" />
                                <rect x="324" y="10" width="1" height="40" />
                                <rect x="327" y="10" width="2" height="40" />
                                <rect x="331" y="10" width="3" height="40" />
                                <rect x="336" y="10" width="1" height="40" />
                                <rect x="339" y="10" width="2" height="40" />
                                <rect x="343" y="10" width="1" height="40" />
                                <rect x="346" y="10" width="3" height="40" />
                                <rect x="351" y="10" width="1" height="40" />
                                <rect x="354" y="10" width="2" height="40" />
                                <rect x="358" y="10" width="1" height="40" />
                                <rect x="361" y="10" width="2" height="40" />
                                <rect x="365" y="10" width="3" height="40" />
                                <rect x="370" y="10" width="1" height="40" />
                                <rect x="373" y="10" width="2" height="40" />
                                <rect x="377" y="10" width="1" height="40" />
                                <rect x="380" y="10" width="3" height="40" />
                                <rect x="385" y="10" width="1" height="40" />
                                <rect x="388" y="10" width="2" height="40" />
                            </g>
                        </svg>
                    </div>
                    <p class="text-center text-muted mb-0">
                        <small><?= $codigoBarras ?></small>
                    </p>
                </div>

                <div class="acoes p-4 bg-light">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-success btn-lg w-100" onclick="confirmarPagamento()">
                                <i class="fas fa-check me-2"></i>
                                Já Paguei
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary btn-lg w-100" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>
                                Imprimir Boleto
                            </button>
                        </div>
                        <div class="col-md-4">
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
    function copiarLinhaDigitavel() {
        const linhaDigitavel = document.getElementById('linhaDigitavel');
        linhaDigitavel.select();
        linhaDigitavel.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(linhaDigitavel.value).then(function() {
            const botao = event.target.closest('button');
            const textoOriginal = botao.innerHTML;
            botao.innerHTML = '<i class="fas fa-check me-1"></i>Copiado!';
            botao.classList.remove('btn-outline-light');
            botao.classList.add('btn-success');

            setTimeout(function() {
                botao.innerHTML = textoOriginal;
                botao.classList.remove('btn-success');
                botao.classList.add('btn-outline-light');
            }, 2000);
        });
    }

    function confirmarPagamento() {
        if (confirm('Confirma que o pagamento do boleto foi realizado?')) {
            window.location.href = '../controllers/controllerVenda.php?opcao=1&pag=boleto';
        }
    }
</script>

<style>
    @media print {

        .btn,
        .acoes {
            display: none !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }

        body {
            background: white !important;
        }
    }

    .boleto-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .banco-logo {
        font-family: 'Courier New', monospace;
    }

    .barcode-container {
        background: white;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }
</style>

<?php
require_once('includes/rodape.inc.php');
?>