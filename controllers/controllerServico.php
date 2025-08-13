<?php
require_once "../classes/usuario.inc.php";
require_once "../dao/usuarioDAO.inc.php";
require_once "../dao/servicoDAO.inc.php";
require_once "../dao/dataDisponivelDAO.inc.php";
require_once "../dao/tipoDAO.inc.php";

$opcao = 0;

if (isset($_REQUEST["opcao"]) && is_numeric($_REQUEST["opcao"])) {
    $opcao = (int)$_REQUEST["opcao"];
}

$servicoDAO = new ServicoDAO();
$datasDAO = new DataDisponivelDAO();
$tipoDAO = new TipoDAO();
$usuarioDAO = new UsuarioDAO();

switch ($opcao) {
    case 1: //get all by usuario
        session_start();
        $idUsuario = $_SESSION["usuario"]->id;
        $servicos = $servicoDAO->getByIdUsuario($idUsuario);

        foreach ($servicos as $servico) {
            $servico->tipo = $tipoDAO->getById($servico->idTipo);
            $datasDisponiveis = $datasDAO->findByIdServico($servico->id);

            $servico->possuiServicoAFazer = possuiServicoAFazer($datasDisponiveis);
        }

        $_SESSION["servicos"] = $servicos;

        header("Location: ../views/exibirServicos.php");
        break;
    case 2: //insert
        session_start();
        try {
            $servico = new Servico(
                $_REQUEST["nome"],
                $_REQUEST["valor"],
                $_REQUEST["cidade"],
                trim($_REQUEST["descricao"]),
                $_REQUEST["tipo"],
                $_SESSION["usuario"]->id
            );

            $idServico = $servicoDAO->insert(
                $servico
            );

            $datas = [];

            if (isset($_REQUEST["datas"])) {
                $datas = $_REQUEST["datas"];
            }

            foreach ($datas as $data) {
                $data = new DataDisponivel($idServico, strtotime($data), true);
                $datasDAO->insert($data);
            }

            header("Location: controllerServico.php?opcao=1");
        } catch (Exception $e) {
            $_SESSION["erros"][] = "Erro ao inserir serviço";
            header("Location: controllerTipo.php?opcao=2");
        }
        break;
    case 3: //get by id
        session_start();
        $servico = getServicoById($_REQUEST["id"]);
        $_SESSION["servico"] = $servico;

        header("Location: controllerTipo.php?opcao=2");
        break;
    case 4: //atualizar
        session_start();

        try {
            $servico = new Servico(
                $_REQUEST["nome"],
                $_REQUEST["valor"],
                $_REQUEST["cidade"],
                trim($_REQUEST["descricao"]),
                $_REQUEST["tipo"],
                $_REQUEST["idPrestador"]
            );
            $servico->id = $_REQUEST["id"];

            $servicoDAO->update($servico);

            $datas = [];

            if (isset($_REQUEST["datas"])) {
                $datas = $_REQUEST["datas"];
            }

            $datasDAO->update($datas, $servico->id);

            $servico = getServicoById($servico->id);
            $_SESSION["servico"] = $servico;
            $_SESSION["sucessos"][] = "Serviço atualizado com sucesso";
            header("Location: controllerTipo.php?opcao=2");
        } catch (Exception $e) {
            $_SESSION["erros"][] = "Erro ao atualizar serviço";
            header("Location: controllerTipo.php?opcao=2");
        }
        break;
    case 5: //delete
        session_start();
        $servicoDAO->delete($_REQUEST["id"]);

        header("Location: controllerServico.php?opcao=1");
        break;
    case 6: //get all
        session_start();
        $idUsuario = 0;

        if (isset($_SESSION["usuario"])) {
            $idUsuario = $_SESSION["usuario"]->id;
        }

        $opcaoRedirecionamento = $_REQUEST["opcao_redirecionamento"] ?? 1;
        $servicos = $servicoDAO->getAll($idUsuario);

        foreach ($servicos as $servico) {
            $servico->tipo = $tipoDAO->getById($servico->idTipo);
            $servico->datasDisponiveis = $datasDAO->findByIdServicoParaVenda($servico->id);
            $servico->nomePrestador = $usuarioDAO->getNameById($servico->idPrestador);
        }

        $_SESSION["servicos"] = $servicos;
        header("Location: controllerCarrinho.php?opcao=" . $opcaoRedirecionamento);
        break;
    case 7: //busca
        session_start();
        $busca = $_REQUEST["busca"];

        $servicos = $servicoDAO->find($busca);

        foreach ($servicos as $servico) {
            $servico->tipo = $tipoDAO->getById($servico->idTipo);
            $servico->datasDisponiveis = $datasDAO->findByIdServicoParaVenda($servico->id);
            $servico->nomePrestador = $usuarioDAO->getNameById($servico->idPrestador);
        }

        $_SESSION["servicos"] = $servicos;
        $_SESSION["busca"] = $busca;

        header("Location: controllerCarrinho.php?opcao=1");
        break;

    case 8: //marca como prestado
        session_start();
        $datasDAO->marcarComoPrestado($_REQUEST["id"]);
        header("Location: controllerVenda.php?opcao=4");
        break;

    case 10: //get all Admin
        session_start();

        //validar usuário
        if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"]->tipo != 'A') {
            header("Location: ../controllers/controllerUsuario.php?opcao=2");
        }

        $servicos = $servicoDAO->getAllToAdmin();

        foreach ($servicos as $servico) {
            $servico->tipo = $tipoDAO->getById($servico->idTipo);
            $servico->datasDisponiveis = $datasDAO->findByIdServico($servico->id);
            $servico->nomePrestador = $usuarioDAO->getNameById($servico->idPrestador);
            $servico->possuiServicoAFazer = possuiServicoAFazer($servico->datasDisponiveis);
        }

        $_SESSION["servicos"] = $servicos;
        header("Location: ../views/exibirServicosAdmin.php");
        break;
}

function possuiServicoAFazer($datasDisponiveis)
{
    foreach ($datasDisponiveis as $d) {
        if (!$d->disponivel && $d->data > strtotime('today')) {
            return true;
        }
    }

    return false;
}

function getServicoById(int $id): Servico
{
    global $servicoDAO, $tipoDAO, $datasDAO;

    $servico = $servicoDAO->getById($id);
    $servico->tipo = $tipoDAO->getById($servico->idTipo);
    $servico->datasDisponiveis = $datasDAO->findByIdServico($servico->id) ?? [];

    return $servico;
}
