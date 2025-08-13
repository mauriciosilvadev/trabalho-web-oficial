<?php
require_once "../dao/usuarioDAO.inc.php";
require_once "../classes/usuario.inc.php";
$opcao = (int)$_REQUEST["opcao"];

$usuarioDao = new UsuarioDao();
switch ($opcao) {
    case 1: //Login
        session_start();

        $_SESSION["erros"] = [];
        $_SESSION["sucessos"] = [];

        try {
            //recupero as informações do login
            $email = $_REQUEST["email"];
            $senha = $_REQUEST["senha"];

            //passa o email e senha para ser autenticado pelo usuarioDao
            $usuario = $usuarioDao->autenticar($email, $senha);

            if ($usuario != null) {
                $_SESSION["usuario"] = $usuario;

                if($_REQUEST["em_compra"] == 1){
                    header("Location: controllerVenda.php?opcao=2");
                }else{
                    header("Location: ../views/index.php");
                }
                
            } else {
                $complemento = $_REQUEST["em_compra"] == 1 ? "?em_compra=1" : "";

                $_SESSION["erros"][] = "Usuário não encontrado";
                header("Location: ../views/formUsuarioLogin.php" . $complemento);
            }
        } catch (Exception $e) {
            $_SESSION["erros"][] = "Ocorreu um erro ao fazer o login";
            header("Location: ../views/formUsuarioLogin.php");
        }
        break;
    case 2: //Logout
        session_start();
        session_unset();
        header("Location: ../views/index.php");
        break;
    case 3: //insert
        session_start();
        try {
            $tipo = 'C';

            if (isset($_REQUEST["tipo"])) {
                $tipo = 'P';
            }

            $usuario = new Usuario(
                $_REQUEST["nome"],
                $_REQUEST["endereco"],
                $_REQUEST["telefone"],
                $_REQUEST["cpf_cnpj"],
                strtotime($_REQUEST["dt_nascimento"]),
                $_REQUEST["email"],
                $_REQUEST["senha"],
                $tipo
            );

            $usuarioDao->insert($usuario);

            $_SESSION["sucessos"][] = "Usuário cadastrado com sucesso";

            header("Location: ../views/formUsuarioLogin.php");
        } catch (Exception $e) {
            $_SESSION["erros"][] = "Erro ao cadastrar usuário";
            header("Location: ../views/formUsuario.php");
        }
        break;

    case 4: //get by id
        session_start();
        try {

            $_SESSION["usuario"] = $usuarioDao->getById($_SESSION["usuario"]->id);

            header("Location: ../views/formUsuarioAtualizar.php");
        } catch (Exception $e) {
            header("Location: controllerUsuario.php?opcao=2");
        }
        break;
    case 5: //update
        session_start();
        try {
            $tipo = 'C';

            if (isset($_REQUEST["tipo"])) {
                $tipo = 'P';
            }

            $usuario = new Usuario(
                $_REQUEST["nome"],
                $_REQUEST["endereco"],
                $_REQUEST["telefone"],
                $_REQUEST["cpf_cnpj"],
                strtotime($_REQUEST["dt_nascimento"]),
                $_REQUEST["email"],
                "",
                $tipo
            );
            $usuario->id = $_SESSION["usuario"]->id;

            $usuarioDao->updateSemSenha($usuario);

            $_SESSION["usuario"] = $usuarioDao->autenticar($_REQUEST["email"],  $_SESSION["usuario"]->senha);

            $_SESSION["sucessos"][] = "Usuário atualizado com sucesso";
            header("Location: ../views/formUsuarioAtualizar.php");
        } catch (Exception $e) {
            $_SESSION["erros"][] = "Erro ao atualizar usuário";
            header("Location: ../views/formUsuarioAtualizar.php");
        }
        break;
    case 6: //update senha
        session_start();
        try {
            $senha = $_REQUEST["senha"];

            $id = $_SESSION["usuario"]->id;

            $usuarioDao->updateSenha($id, $senha);

            $_SESSION["usuario"] = $usuarioDao->autenticar($_SESSION["usuario"]->email,  $senha);
            $_SESSION["sucessos"][] = "Senha atualizada com sucesso";
            header("Location: ../views/formUsuarioAtualizarSenha.php");
        } catch (Exception $e) {
            $_SESSION["erros"][] = "Erro ao atualizar a senha";
            header("Location: ../views/formUsuarioAtualizarSenha.php?erro=1");
        }
        break;
    case 7: //deleção
        session_start();
        try {
            $usuario = $_SESSION["usuario"];

            $usuarioDao->delete($usuario->id);

            $_SESSION["sucessos"][] = "Usuário excluído com sucesso";
            header("Location: controllerUsuario.php?opcao=2");
        } catch (Exception $e) {
            $_SESSION["erros"][] = "Erro ao excluir usuário";
            header("Location: ../views/formUsuarioAtualizar.php");
        }
        break;
    case 10: //get all
        session_start();

        if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"]->tipo != 'A') {
            header("Location: ../views/index.php");
        }

        $usuarios = $usuarioDao->getAll();
        $_SESSION["usuarios"] = $usuarios;

        header("Location: ../views/exibirUsuarios.php");
        session_start();
        break;
    case 11: //get by id to admin
        session_start();

        if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"]->tipo != 'A') {
            header("Location: ../views/index.php");
        }

        $_SESSION["usuarioAtualizar"] = $usuarioDao->getById($_REQUEST["id"]);
        header("Location: ../views/formUsuarioAtualizar.php");
        break;
    case 12: //update users
        session_start();
        $tipo = 'C';

        if (isset($_REQUEST["tipo"])) {
            $tipo = 'P';
        }

        $usuario = new Usuario(
            $_REQUEST["nome"],
            $_REQUEST["endereco"],
            $_REQUEST["telefone"],
            $_REQUEST["cpf_cnpj"],
            strtotime($_REQUEST["dt_nascimento"]),
            $_REQUEST["email"],
            "",
            $tipo
        );
        $usuario->id = $_REQUEST["id"];

        $usuarioDao->updateSemSenha($usuario);

        $_SESSION["usuarioAtualizar"] = $usuarioDao->getById($_REQUEST["id"]);

        $_SESSION["sucessos"][] = "Usuário atualizado com sucesso";
        header("Location: ../views/formUsuarioAtualizar.php");
        break;
    case 13:
        $usuarioDao->delete($_REQUEST["id"]);
        header("Location: controllerUsuario.php?opcao=10");
        break;
}
