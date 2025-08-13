<?php 
require_once "../classes/usuario.inc.php";
session_start();

if(!isset($_SESSION["usuario"]) || $_SESSION["usuario"]->tipo != "A"){
    header("Location: ../controllers/controllerServico.php?opcao=6&opcao_redirecionamento=1");
}else{
    header("Location: ../controllers/controllerUsuario.php?opcao=10");
}
 ?>