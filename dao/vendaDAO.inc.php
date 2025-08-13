<?php
require_once "conexao.inc.php";
require_once "genericDAO.inc.php";
require_once "../classes/venda.inc.php";
require_once "../utils/funcoesUteis.php";

final class VendaDAO
{
    private PDO $conn;
    private GenericDAO $decorator;

    public function __construct()
    {
        $c = new Conexao();

        $this->conn = $c->getConexao();
        $this->decorator = new GenericDAO($this->conn, "vendas");
    }

    public function insert(Venda $venda): int
    {
        $this->decorator->insert([
            "id_contratante" => $venda->idContratante,
            "valor" => $venda->valor,
            "forma_pagamento" => $venda->formaPagamento,
            "data" => parseISO($venda->data)
        ]);

        return $this->conn->lastInsertId();
    }

    //retornar todos os serviços contratados por um usuário
    public function getAllContratadosByIdUsuario($id)
    {
        $sql = $this->conn->prepare("
            SELECT 
                v.id as id,
                v.id_contratante as id_contratante,
                v.valor as valor,
                v.forma_pagamento as forma_pagamento,
                v.data as data
            FROM vendas v
            WHERE 
                v.id_contratante = :id
            ORDER BY v.data DESC");

        $sql->bindParam(":id", $id);
        $sql->execute();

        $servicosAssoc = $sql->fetchAll(PDO::FETCH_ASSOC);
        $servicosObj = VendaDAO::assocsToVendas($servicosAssoc);

        return $servicosObj;
    }

    //retornar todos os serviços vendidos por um usuário
    public function getAllVendidosByIdUsuario($id)
    {
        $sql = $this->conn->prepare("
            SELECT 
                v.id as id,
                v.id_contratante as id_contratante,
                v.valor as valor,
                v.forma_pagamento as forma_pagamento,
                v.data as data
            FROM vendas v
            INNER JOIN datas_disponiveis d
            ON v.id = d.id_venda
            INNER JOIN servicos s
            ON s.id = d.id_servico
            WHERE 
                s.id_prestador = :id_usuario
            GROUP BY v.id
            ORDER BY v.data DESC");

        $sql->bindParam(":id_usuario", $id);
        $sql->execute();

        $servicosAssoc = $sql->fetchAll(PDO::FETCH_ASSOC);
        $servicosObj = VendaDAO::assocsToVendas($servicosAssoc);

        return $servicosObj;
    }

    public function getAllVendidos()
    {
        $assoc = $this->decorator->find();

        return VendaDAO::assocsToVendas($assoc);
    }

    private static function assocToVenda($data): Venda | null
    {
        if (!isset($data)) return null;

        $v = new Venda(
            $data["id_contratante"],
            $data["valor"],
            $data["forma_pagamento"]
        );
        $v->id = $data["id"];
        $v->data = strtotime($data["data"]);

        return $v;
    }

    private static function assocsToVendas($data): array
    {
        if (!isset($data)) return [];

        $vendas = [];
        foreach ($data as $venda) {
            $vendas[] = VendaDAO::assocToVenda($venda);
        }

        return $vendas;
    }
}
