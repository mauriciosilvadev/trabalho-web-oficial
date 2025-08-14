<?php
require_once "../dao/tipoDAO.inc.php";

$opcao = 0;

if (isset($_REQUEST["opcao"]) && is_numeric($_REQUEST["opcao"])) {
    $opcao = (int)$_REQUEST["opcao"];
}

$tipoDAO = new TipoDAO();
if ($opcao == 1) { // buscar todos
    session_start();
    $tipos = $tipoDAO->getAll();
    $_SESSION["tipos"] = $tipos;

    header("Location: ../views/cadastrarServico.php");
} elseif ($opcao == 2) { // buscar todos para editar
    session_start();
    $tipos = $tipoDAO->getAll();
    $_SESSION["tipos"] = $tipos;

    header("Location: ../views/editarServico.php");
} else {
    header("Location: ../views/index.php");
}
