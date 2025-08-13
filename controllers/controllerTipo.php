<?php
require_once "../dao/tipoDAO.inc.php";

$opcao = 0;

if(isset($_REQUEST["opcao"]) && is_numeric($_REQUEST["opcao"])){
    $opcao = (int)$_REQUEST["opcao"];
}

$tipoDAO = new TipoDAO();
switch ($opcao) {
    case 1: //get all
    case 2:
        $tipos = $tipoDAO->getAll();

        session_start();
        $_SESSION["tipos"] = $tipos;

        if($opcao == 1) header("Location: ../views/formServico.php");
        else header("Location: ../views/formServicoAtualizar.php");
        break;
    default:
        # code...
        break;
}
?>