<?php
require_once "../classes/item.inc.php";
require_once "../classes/servico.inc.php";


$opcao = (int)$_REQUEST["opcao"];

if ($opcao == 1 || $opcao == 2) {
    session_start();

    $carrinho = $_SESSION["carrinho"];
    $servicos = $_SESSION["servicos"];

    foreach ($carrinho as $item) {
        $servico = $item->getServico();
        if ($servico === null) {
            continue;
        }
        $s = buscarServicoById($servicos, $servico->id);

        if ($s == null) {
            continue;
        }

        foreach ($item->getDatas() as $data) {
            $s->datasDisponiveis = array_filter($s->datasDisponiveis, function ($d) use ($data) {
                return $d->id != $data->id;
            });
        }
    }

    $_SESSION["servicos"] = $servicos;

    if ($opcao == 1) {
        header("Location: ../views/servicosVenda.php");
    } else {
        header("Location: ../views/exibirCarrinho.php");
    }
} elseif ($opcao == 3) { // adicionar as datas no carrinho
    session_start();

    $idServico = (int)$_REQUEST["id_servico"];
    $idDatas = $_REQUEST["id_datas"];

    if (!isset($idDatas) || sizeof($idDatas) == 0) {
        header("Location: ../views/exibirCarrinho.php");
    } else {
        $carrinho = [];
        if (isset($_SESSION["carrinho"])) {
            $carrinho = $_SESSION["carrinho"];
        }

        $item = buscarItemNoCarrinhoById($carrinho, $idServico);
        $servicos = $_SESSION["servicos"];

        $servico = null;
        foreach ($servicos as $s) {
            if ($s->id == $idServico) {
                $servico = $s;
                break;
            }
        }

        if ($item == null && $servico !== null) {
            $item = new item($servico);
            $carrinho[] = $item;
        }

        foreach ($idDatas as $idData) {
            $qtdItensNoCarrinho = 0;
            foreach ($carrinho as $item) {
                $qtdItensNoCarrinho += sizeof($item->getDatas());
            }
            if ($qtdItensNoCarrinho == 5) {
                $_SESSION["erros"][] = "Limite de 5 serviços no carrinho atingido";
                break;
            }
            if ($servico !== null) {
                $data = $servico->getData($idData);
                if ($data !== null) {
                    $item->addData($data);
                }
            }
        }

        $_SESSION["carrinho"] = $carrinho;

        header("Location: controllerCarrinho.php?opcao=2");
    }
} elseif ($opcao == 4) { // remover data do carrinho
    session_start();
    $idServico = (int)$_REQUEST["id_servico"];
    $idData = (int)$_REQUEST["id_data"];

    $carrinho = $_SESSION["carrinho"];

    $item = buscarItemNoCarrinhoById($carrinho, $idServico);

    if ($item !== null) {
        $item->removeData($idData);
    }
    $_SESSION["carrinho"] = $carrinho;
    header("Location: controllerServico.php?opcao=6&opcao_redirecionamento=2");
} elseif ($opcao == 5) { // limpar 
    session_start();
    unset($_SESSION["carrinho"]);
    $_SESSION["carrinho"] = [];
    header("Location: controllerServico.php?opcao=6&opcao_redirecionamento=2");
}

function buscarItemNoCarrinhoById($carrinho, $id)
{
    foreach ($carrinho as $item) {
        $servico = $item->getServico();
        if ($servico !== null && $servico->id == $id) {
            return $item;
        }
    }
    return null;
}

function buscarServicoById($servicos, $id)
{
    foreach ($servicos as $servico) {
        if ($servico->id == $id) {
            return $servico;
        }
    }
    return null;
}
