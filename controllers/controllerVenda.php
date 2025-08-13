<?php
require_once '../classes/venda.inc.php';
require_once '../dao/vendaDAO.inc.php';
require_once '../utils/funcoesUteis.php';
require_once '../dao/dataDisponivelDAO.inc.php';
require_once '../classes/dataDisponivel.inc.php';
require_once '../classes/usuario.inc.php';
require_once '../classes/item.inc.php';
require_once '../dao/servicoDAO.inc.php';


$opcao = 0;

if (isset($_REQUEST["opcao"]) && is_numeric($_REQUEST["opcao"])) {
    $opcao = (int)$_REQUEST["opcao"];
}

$vendaDAO = new VendaDAO();
$datasDAO = new DataDisponivelDAO();
$servicoDAO = new ServicoDAO();

switch ($opcao) {
    case 1: //insert
        session_start();
        $venda = new Venda(
            $_SESSION["usuario"]->id,
            $_SESSION["soma"],
            $_REQUEST["pag"]
        );

        $id_venda = $vendaDAO->insert($venda);

        foreach ($_SESSION["carrinho"] as $item) {
            foreach ($item->getDatas() as $data) {
                $datasDAO->vendaEfetuada($data->id, $id_venda);
            }
        }

        $_SESSION["carrinho"] = [];

        $_SESSION["sucessos"][] = "Compra realizada com sucesso!";
        header("Location: ../views/exibirCarrinho.php");
        break;
    case 2: //verificar se está logado
        session_start();

        if (isset($_SESSION["usuario"])) {
            header("Location: ../views/dadosCompra.php");
        } else {
            header("Location: ../views/formUsuarioLogin.php?em_compra=1");
        }
        break;
    case 3: //get servios vendidos
        session_start();
        $idUsuario = $_SESSION["usuario"]->id;

        $vendas = $vendaDAO->getAllVendidosByIdUsuario($idUsuario);

        foreach ($vendas as $venda) {
            $servicos = $servicoDAO->getAllVendidosByIdVendaIdPerstador($venda->id, $idUsuario);

            $datas = [];
            foreach ($servicos as $servico) {
                $datas = $datasDAO->findAllByIdServicoIdVenda($servico->id, $venda->id);

                $item = new item($servico);
                $item->addDatas($datas);

                $venda->addItem($item);
            }
        }

        $_SESSION["vendas_feitas"] = $vendas;

        header("Location: ../views/exibirServicosVendidos.php");
        break;

    case 4: //get serviços contratados
        session_start();
        $idUsuario = $_SESSION["usuario"]->id;

        $vendas = $vendaDAO->getAllContratadosByIdUsuario($idUsuario);

        foreach ($vendas as $venda) {
            $servicos = $servicoDAO->getAllContratadosByIdVenda($venda->id);

            $datas = [];

            foreach ($servicos as $servico) {
                $datas = $datasDAO->findAllByIdServicoIdVenda($servico->id, $venda->id);

                $item = new item($servico);
                $item->addDatas($datas);

                $venda->addItem($item);
            }
        }

        $_SESSION["vendas_feitas"] = $vendas;

        header("Location: ../views/exibirServicosContratados.php");
        break;
    case 10: //get all by id usuário para admin visualizar serviços vendidos
        session_start();
        $idUsuario = $_SESSION["usuario"]->id;

        $vendas = $vendaDAO->getAllVendidos();

        foreach ($vendas as $venda) {
            $servicos = $servicoDAO->getAllContratadosByIdVenda($venda->id);

            $datas = [];

            foreach ($servicos as $servico) {
                $datas = $datasDAO->findAllByIdServicoIdVenda($servico->id, $venda->id);

                $item = new item($servico);
                $item->addDatas($datas);

                $venda->addItem($item);
            }
        }

        $_SESSION["vendas_feitas"] = $vendas;

        header("Location: ../views/exibirServicosVendidos.php");
        break;
}
