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
    
    $_SESSION["erros"] = [];
    $_SESSION["sucessos"] = [];
    
    try {
        // Validações do lado servidor
        $erros = [];
        
        // Validação de campos obrigatórios
        if (empty(trim($_REQUEST["nome"]))) {
            $erros[] = "O campo Nome Completo é obrigatório";
        }
        if (empty(trim($_REQUEST["email"]))) {
            $erros[] = "O campo Email é obrigatório";
        }
        if (empty(trim($_REQUEST["endereco"]))) {
            $erros[] = "O campo Endereço é obrigatório";
        }
        if (empty(trim($_REQUEST["cidade"]))) {
            $erros[] = "O campo Cidade é obrigatório";
        }
        if (empty(trim($_REQUEST["telefone"]))) {
            $erros[] = "O campo Telefone é obrigatório";
        }
        if (empty(trim($_REQUEST["cpf_cnpj"]))) {
            $erros[] = "O campo CPF/CNPJ é obrigatório";
        }
        if (empty($_REQUEST["dt_nascimento"])) {
            $erros[] = "O campo Data de Nascimento é obrigatório";
        }
        if (empty($_REQUEST["senha"])) {
            $erros[] = "O campo Senha é obrigatório";
        }
        
        // Validação de email
        if (!empty($_REQUEST["email"]) && !filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) {
            $erros[] = "Email inválido";
        }
        
        // Validação de senha
        if (!empty($_REQUEST["senha"])) {
            $senha = $_REQUEST["senha"];
            if (strlen($senha) < 8) {
                $erros[] = "A senha deve ter no mínimo 8 caracteres";
            }
            if (!preg_match('/[A-Z]/', $senha)) {
                $erros[] = "A senha deve conter pelo menos uma letra maiúscula";
            }
            if (!preg_match('/[a-z]/', $senha)) {
                $erros[] = "A senha deve conter pelo menos uma letra minúscula";
            }
            if (!preg_match('/[0-9]/', $senha)) {
                $erros[] = "A senha deve conter pelo menos um número";
            }
            if (!preg_match('/[!@#$%^&*]/', $senha)) {
                $erros[] = "A senha deve conter pelo menos um caractere especial (!@#$%^&*)";
            }
        }
        
        // Validação de idade
        if (!empty($_REQUEST["dt_nascimento"])) {
            $dataNasc = new DateTime($_REQUEST["dt_nascimento"]);
            $hoje = new DateTime();
            $idade = $hoje->diff($dataNasc)->y;
            
            if ($idade < 18) {
                $erros[] = "O usuário deve ter 18 anos ou mais";
            }
        }
        
        // Se há erros, retorna para o formulário
        if (!empty($erros)) {
            $_SESSION["erros"] = $erros;
            header("Location: ../views/formUsuario.php");
            exit();
        }
        
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
        $_SESSION["erros"][] = "Erro ao cadastrar usuário: " . $e->getMessage();
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
    
    $_SESSION["erros"] = [];
    $_SESSION["sucessos"] = [];
    
    try {
        $usuario_atual = $_SESSION["usuario"];
        
        // Define o tipo padrão como Cliente
        $tipo = 'C';

        // Se marcado como prestador, altera o tipo
        if (isset($_REQUEST["tipo"])) {
            $tipo = 'P';
        }
        
        // Se o usuário está mudando de Prestador para Cliente, verifica se tem serviços cadastrados
        if ($usuario_atual->tipo == 'P' && $tipo == 'C') {
            require_once "../dao/servicoDAO.inc.php";
            $servicoDao = new ServicoDAO();
            $servicosUsuario = $servicoDao->getByIdUsuario($usuario_atual->id);
            
            if (!empty($servicosUsuario)) {
                $_SESSION["erros"][] = "Não é possível alterar o tipo de conta para Cliente pois você possui serviços cadastrados. Exclua todos os serviços antes de fazer esta alteração.";
                header("Location: ../views/formUsuarioAtualizar.php");
                exit();
            }
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
        $_SESSION["erros"][] = "Erro ao atualizar usuário: " . $e->getMessage();
        header("Location: ../views/formUsuarioAtualizar.php");
    }
} elseif ($opcao == 6) { // Altera a senha do usuário logado
    session_start();
    
    $_SESSION["erros"] = [];
    $_SESSION["sucessos"] = [];
    
    try {
        // Validações do lado servidor
        $erros = [];
        $senha = $_REQUEST["senha"];
        
        // Validação de senha
        if (empty($senha)) {
            $erros[] = "O campo Senha é obrigatório";
        } else {
            if (strlen($senha) < 8) {
                $erros[] = "A senha deve ter no mínimo 8 caracteres";
            }
            if (!preg_match('/[A-Z]/', $senha)) {
                $erros[] = "A senha deve conter pelo menos uma letra maiúscula";
            }
            if (!preg_match('/[a-z]/', $senha)) {
                $erros[] = "A senha deve conter pelo menos uma letra minúscula";
            }
            if (!preg_match('/\d/', $senha)) {
                $erros[] = "A senha deve conter pelo menos um número";
            }
            if (!preg_match('/[!@#$%^&*]/', $senha)) {
                $erros[] = "A senha deve conter pelo menos um caractere especial (!@#$%^&*)";
            }
        }
        
        // Se há erros, retorna para o formulário
        if (!empty($erros)) {
            $_SESSION["erros"] = $erros;
            header("Location: ../views/formUsuarioAtualizarSenha.php");
            exit();
        }

        $id = $_SESSION["usuario"]->id;

        // Atualiza apenas a senha do usuário
        $usuarioDao->updateSenha($id, $senha);

        $_SESSION["usuario"] = $usuarioDao->autenticar($_SESSION["usuario"]->email,  $senha);
        $_SESSION["sucessos"][] = "Senha atualizada com sucesso";
        header("Location: ../views/formUsuarioAtualizarSenha.php");
    } catch (Exception $e) {
        $_SESSION["erros"][] = "Erro ao atualizar a senha: " . $e->getMessage();
        header("Location: ../views/formUsuarioAtualizarSenha.php");
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
    
    $_SESSION["erros"] = [];
    $_SESSION["sucessos"] = [];
    
    try {
        $usuario_atual = $usuarioDao->getById($_REQUEST["id"]);
        
        // Define o tipo padrão como Cliente
        $tipo = 'C';

        // Se marcado como prestador, altera o tipo
        if (isset($_REQUEST["tipo"])) {
            $tipo = 'P';
        }
        
        // Se o usuário está mudando de Prestador para Cliente, verifica se tem serviços cadastrados
        if ($usuario_atual->tipo == 'P' && $tipo == 'C') {
            require_once "../dao/servicoDAO.inc.php";
            $servicoDao = new ServicoDAO();
            $servicosUsuario = $servicoDao->getByIdUsuario($usuario_atual->id);
            
            if (!empty($servicosUsuario)) {
                $_SESSION["erros"][] = "Não é possível alterar o tipo de conta para Cliente pois este usuário possui serviços cadastrados. Exclua todos os serviços antes de fazer esta alteração.";
                header("Location: ../views/formUsuarioAtualizar.php");
                exit();
            }
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
    } catch (Exception $e) {
        $_SESSION["erros"][] = "Erro ao atualizar usuário: " . $e->getMessage();
        header("Location: ../views/formUsuarioAtualizar.php");
    }
} elseif ($opcao == 13) { // Exclui usuário selecionado pelo administrador
    $usuarioDao->delete($_REQUEST["id"]);
    header("Location: controllerUsuario.php?opcao=10");
}
