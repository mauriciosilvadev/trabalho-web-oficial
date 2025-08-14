<?php
require_once "../dao/usuarioDAO.inc.php";
require_once "../classes/usuario.inc.php";
$opcao = (int)$_REQUEST["opcao"];

$usuarioDao = new UsuarioDao();
if ($opcao == 1) { // Realiza o processo de autenticação do usuário
    session_start();

    $_SESSION["erros"] = [];
    $_SESSION["sucessos"] = [];

    try {
        // Captura os dados de email e senha enviados pelo formulário
        $email = $_REQUEST["email"];
        $senha = $_REQUEST["senha"];

        // Verifica as credenciais no banco de dados
        $usuario = $usuarioDao->autenticar($email, $senha);

        if ($usuario != null) {
            $_SESSION["usuario"] = $usuario;

            if ($_REQUEST["em_compra"] == 1) {
                header("Location: controllerVenda.php?opcao=2");
            } else {
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
} elseif ($opcao == 2) { // Encerra a sessão do usuário logado
    session_start();
    session_unset();
    header("Location: ../views/index.php");
} elseif ($opcao == 3) { // Cadastra um novo usuário no sistema
    session_start();
    try {
        // Define o tipo padrão como Cliente
        $tipo = 'C';

        // Se marcado como prestador, altera o tipo
        if (isset($_REQUEST["tipo"])) {
            $tipo = 'P';
        }

        $usuario = new Usuario(
            $_REQUEST["nome"],
            $_REQUEST["endereco"],
            $_REQUEST["cidade"],
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
} elseif ($opcao == 4) { // Busca dados do usuário logado para edição
    session_start();
    try {

        $_SESSION["usuario"] = $usuarioDao->getById($_SESSION["usuario"]->id);

        header("Location: ../views/formUsuarioAtualizar.php");
    } catch (Exception $e) {
        header("Location: controllerUsuario.php?opcao=2");
    }
} elseif ($opcao == 5) { // Atualiza informações pessoais do usuário
    session_start();
    try {
        // Define o tipo padrão como Cliente
        $tipo = 'C';

        // Se marcado como prestador, altera o tipo
        if (isset($_REQUEST["tipo"])) {
            $tipo = 'P';
        }

        // Cria objeto usuário com os novos dados (sem alterar a senha)
        $usuario = new Usuario(
            $_REQUEST["nome"],
            $_REQUEST["endereco"],
            $_REQUEST["cidade"],
            $_REQUEST["telefone"],
            $_REQUEST["cpf_cnpj"],
            strtotime($_REQUEST["dt_nascimento"]),
            $_REQUEST["email"],
            "",
            $tipo
        );
        $usuario->id = $_SESSION["usuario"]->id;

        // Atualiza os dados sem modificar a senha
        $usuarioDao->updateSemSenha($usuario);

        $_SESSION["usuario"] = $usuarioDao->autenticar($_REQUEST["email"],  $_SESSION["usuario"]->senha);

        $_SESSION["sucessos"][] = "Usuário atualizado com sucesso";
        header("Location: ../views/formUsuarioAtualizar.php");
    } catch (Exception $e) {
        $_SESSION["erros"][] = "Erro ao atualizar usuário";
        header("Location: ../views/formUsuarioAtualizar.php");
    }
} elseif ($opcao == 6) { // Altera a senha do usuário logado
    session_start();
    try {
        // Captura a nova senha informada
        $senha = $_REQUEST["senha"];

        $id = $_SESSION["usuario"]->id;

        // Atualiza apenas a senha do usuário
        $usuarioDao->updateSenha($id, $senha);

        $_SESSION["usuario"] = $usuarioDao->autenticar($_SESSION["usuario"]->email,  $senha);
        $_SESSION["sucessos"][] = "Senha atualizada com sucesso";
        header("Location: ../views/formUsuarioAtualizarSenha.php");
    } catch (Exception $e) {
        $_SESSION["erros"][] = "Erro ao atualizar a senha";
        header("Location: ../views/formUsuarioAtualizarSenha.php?erro=1");
    }
} elseif ($opcao == 7) { // Remove a conta do usuário do sistema
    session_start();
    try {
        // Obtém os dados do usuário logado
        $usuario = $_SESSION["usuario"];

        // Remove a conta do usuário do banco de dados
        $usuarioDao->delete($usuario->id);

        $_SESSION["sucessos"][] = "Usuário excluído com sucesso";
        header("Location: controllerUsuario.php?opcao=2");
    } catch (Exception $e) {
        $_SESSION["erros"][] = "Erro ao excluir usuário";
        header("Location: ../views/formUsuarioAtualizar.php");
    }
} elseif ($opcao == 10) { // Lista todos os usuários (acesso administrativo)
    session_start();

    // Verifica se o usuário está logado e é administrador
    if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"]->tipo != 'A') {
        header("Location: ../views/index.php");
    }

    // Busca todos os usuários cadastrados
    $usuarios = $usuarioDao->getAll();
    $_SESSION["usuarios"] = $usuarios;

    header("Location: ../views/exibirUsuarios.php");
} elseif ($opcao == 11) { // Busca usuário específico para edição pelo administrador
    session_start();

    // Verifica se o usuário está logado e é administrador
    if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"]->tipo != 'A') {
        header("Location: ../views/index.php");
    }

    // Carrega os dados do usuário selecionado para edição
    $_SESSION["usuarioAtualizar"] = $usuarioDao->getById($_REQUEST["id"]);
    header("Location: ../views/formUsuarioAtualizar.php");
} elseif ($opcao == 12) { // Atualiza dados de usuário pelo administrador
    session_start();
    // Define o tipo padrão como Cliente
    $tipo = 'C';

    // Se marcado como prestador, altera o tipo
    if (isset($_REQUEST["tipo"])) {
        $tipo = 'P';
    }

    // Cria objeto usuário com os dados recebidos
    $usuario = new Usuario(
        $_REQUEST["nome"],
        $_REQUEST["endereco"],
        $_REQUEST["cidade"],
        $_REQUEST["telefone"],
        $_REQUEST["cpf_cnpj"],
        strtotime($_REQUEST["dt_nascimento"]),
        $_REQUEST["email"],
        "",
        $tipo
    );
    $usuario->id = $_REQUEST["id"];

    // Atualiza os dados do usuário selecionado
    $usuarioDao->updateSemSenha($usuario);

    $_SESSION["usuarioAtualizar"] = $usuarioDao->getById($_REQUEST["id"]);

    $_SESSION["sucessos"][] = "Usuário atualizado com sucesso";
    header("Location: ../views/formUsuarioAtualizar.php");
} elseif ($opcao == 13) { // Exclui usuário selecionado pelo administrador
    $usuarioDao->delete($_REQUEST["id"]);
    header("Location: controllerUsuario.php?opcao=10");
}
