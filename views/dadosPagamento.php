<?php
     require_once 'includes/cabecalho.inc.php';
?>
      <center>
        <h2><font face="Arial">Opção de Pagamento</font></h2>
      <p>
      Escolha a sua opção de pagamento:
      <form action="../controllers/controllerVenda.php"  method="get">
            <input type="radio" name="pag" value="boleto" required> Boleto Bancário<p>
            <input type="radio" name="pag" value="crédito"> Cartão de Crédito<p>
            <input type="radio" name="pag" value="debito"> Cartão de Débito<p>
            <input type="radio" name="pag" value="pix"> Pix<p>
            <input type="radio" name="pag" value="paypal"> PayPal<p>
            <input type="radio" name="pag" value="picpay"> PicPay<p>
      
            <input type="hidden" value="1" name="opcao">
            <input type="submit" value="Efetuar Pagamento">
      </form>
<?php
       require_once('includes/rodape.inc.php');
?>