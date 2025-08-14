<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Loja virtual Des Web</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <!-- <header class="bg-primary bg-gradient shadow-sm mb-4">
    <div class="container">
      <div class="row align-items-center py-3">
        <div class="col-md-6">
          <h1 class="h3 text-white mb-0 fw-bold">
            <i class="fas fa-store me-2"></i>
            Loja Virtual Des Web
          </h1>
        </div>
        <div class="col-md-6 text-md-end">
          <small class="text-white-50">
            <i class="fas fa-clock me-1"></i>
            Sistema de Serviços Online
          </small>
        </div>
      </div>
    </div>
  </header> -->

  <div class="container">
    <?php
    require_once "../classes/usuario.inc.php";
    session_start();

    $menu = "V";

    if (isset($_SESSION["usuario"]) && $_SESSION["usuario"] instanceof Usuario) {
      $menu = $_SESSION["usuario"]->tipo;
    }

    require_once "menu$menu.inc.php";
    ?>