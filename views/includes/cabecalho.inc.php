<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loja virtual Des Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
        <div class="container">
<?php
    require_once "../classes/usuario.inc.php";
    session_start();
    
    $menu = "V";

    if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] instanceof Usuario){
      $menu = $_SESSION["usuario"]->tipo;
    }

    require_once "menu$menu.inc.php";
?>          