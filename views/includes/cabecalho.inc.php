<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Loucos por Serviços</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">
  <?php
  require_once "../classes/usuario.inc.php";
  session_start();

  $menu = "V";

  if (isset($_SESSION["usuario"]) && $_SESSION["usuario"] instanceof Usuario) {
    $menu = $_SESSION["usuario"]->tipo;
  }

  require_once "menu$menu.inc.php";
  ?>

  <div class="container flex-grow-1">