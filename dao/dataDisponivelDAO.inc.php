<?php
require_once "conexao.inc.php";
require_once "genericDAO.inc.php";
require_once "../classes/dataDisponivel.inc.php";
require_once "../utils/funcoesUteis.php";

final class DataDisponivelDAO
{
    private PDO $conn;
    private GenericDAO $decorator;
    private string $nomeDatabase = "datas_disponiveis";

    public function __construct() {
        $c = new Conexao();

        $this->conn = $c->getConexao();
        $this->decorator = new GenericDAO($this->conn, $this->nomeDatabase);
    }

    public function insert(DataDisponivel $dtDisponivel) {
        $this->decorator->insert([
            "id_servico" => $dtDisponivel->idServico, 
            "data" => parseISO($dtDisponivel->data), 
            "disponivel" => $dtDisponivel->disponivel
        ]);
    }

    public function findByIdServico(int $idServico) : array {
        $sql = $this->conn->prepare(
            "
                SELECT * 
                FROM $this->nomeDatabase
                WHERE id_servico = :id_servico AND data > CURRENT_DATE
                ORDER BY data ASC
            "
        );

        $sql->bindValue(":id_servico", $idServico);
        $sql->execute();

        $r = $sql->fetchAll(PDO::FETCH_ASSOC);

        return DataDisponivelDAO::assocsToDatasDisponiveis($r);
    }

    public function findAllContratadasByIdServico(int $idServico, int $idContratante) : array {
        $sql = $this->conn->prepare(
            "
                SELECT 
                    d.id as id, 
                    d.id_servico as id_servico, 
                    d.data as data, 
                    d.disponivel as disponivel,  
                    d.id_venda as id_venda, 
                    d.prestado as prestado
                FROM $this->nomeDatabase as d
                INNER JOIN vendas as v
                ON d.id_venda = v.id
                WHERE id_servico = :id_servico AND 
                disponivel = 0 AND
                v.id_contratante = :id_contratante
                ORDER BY data ASC
            "
        );

        $sql->bindValue(":id_contratante", $idContratante);
        $sql->bindValue(":id_servico", $idServico);
        $sql->execute();

        $r = $sql->fetchAll(PDO::FETCH_ASSOC);

        return DataDisponivelDAO::assocsToDatasDisponiveis($r);
    }

    public function findAllByIdServicoIdVenda(int $idServico, int $idVenda) : array {
        $sql = $this->conn->prepare(
            "
                SELECT 
                    d.id as id, 
                    d.id_servico as id_servico, 
                    d.data as data, 
                    d.disponivel as disponivel,  
                    d.id_venda as id_venda, 
                    d.prestado as prestado
                FROM $this->nomeDatabase as d
                INNER JOIN vendas as v
                ON id_venda = v.id
                WHERE id_servico = :id_servico AND 
                disponivel = 0 AND
                v.id = :idVenda
                ORDER BY data ASC
            "
        );

        $sql->bindValue(":id_servico", $idServico);
        $sql->bindValue(":idVenda", $idVenda);
        $sql->execute();

        $r = $sql->fetchAll(PDO::FETCH_ASSOC);

        return DataDisponivelDAO::assocsToDatasDisponiveis($r);
    }

    public function findByIdServicoParaVenda(int $idServico) : array {
        $sql = $this->conn->prepare(
            "
                SELECT * 
                FROM $this->nomeDatabase
                WHERE id_servico = :id_servico AND disponivel = 1 AND data > CURRENT_DATE
                ORDER BY data ASC
            "
        );

        $sql->bindValue(":id_servico", $idServico);
        $sql->execute();

        $r = $sql->fetchAll(PDO::FETCH_ASSOC);

        return DataDisponivelDAO::assocsToDatasDisponiveis($r);
    }

    public function update(array $datasDisponiveis, int $idServico) {
        $this->decorator->delete(["id_servico" => $idServico, "disponivel" => 1]);

        foreach($datasDisponiveis as $d) {
            $this->insert(new DataDisponivel($idServico, strtotime($d), true));
        }
    }

    public function vendaEfetuada(int $idDataDisponivel, int $idVenda) {
        $this->decorator->update(["id" => $idDataDisponivel], ["id_venda" => $idVenda, "disponivel" => 0]);
    }

    public function marcarComoPrestado(int $idDataDisponivel) {
        $this->decorator->update(["id" => $idDataDisponivel], ["prestado" => 1]);
    }

    private static function assocToDataDisponivel($data) : DataDisponivel{
        if(!isset($data)) return null;

        $d = new DataDisponivel(
            $data["id_servico"], 
            strtotime($data["data"]), 
            $data["disponivel"], 
            $data["id_venda"] ?? 0,
            $data["prestado"] ?? 0
        );
        
        $d->id = $data["id"];
        
        return $d;
    }

    private static function assocsToDatasDisponiveis($data) : array{
        if(!isset($data)) return [];

        $r = [];
        foreach($data as $item){
            $r[] = DataDisponivelDAO::assocToDataDisponivel($item);
        }

        return $r;
    }
}
?>