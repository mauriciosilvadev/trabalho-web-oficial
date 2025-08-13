<?php
require_once "conexao.inc.php";
require_once "genericDAO.inc.php";
require_once "../classes/servico.inc.php";

final class ServicoDAO
{
    private PDO $conn;
    private GenericDAO $decorator;

    public function __construct()
    {
        $c = new Conexao();

        $this->conn = $c->getConexao();
        $this->decorator = new GenericDAO($this->conn, "servicos");
    }

    public function insert(Servico $servico)
    {
        return $this->decorator->insert([
            "nome" => $servico->nome,
            "valor" => $servico->valor,
            "cidade" => $servico->cidade,
            "descricao" => $servico->descricao,
            "id_tipo" => $servico->idTipo,
            "id_prestador" => $servico->idPrestador
        ]);
    }

    public function getById($id): Servico | null
    {
        $servico = $this->decorator->find(["id" => $id, "esta_deletado" => false])[0];
        return ServicoDAO::assocToServico($servico);
    }

    public function getByIdUsuario($idUsuario): array
    {
        $servicosAssoc = $this->decorator->find(["id_prestador" => $idUsuario, "esta_deletado" => false]);
        return ServicoDAO::assocsToServicos($servicosAssoc);
    }

    public function update(Servico $servico)
    {
        $this->decorator->update([
            "id" => $servico->id
        ], [
            "nome" => $servico->nome,
            "valor" => $servico->valor,
            "cidade" => $servico->cidade,
            "descricao" => $servico->descricao,
            "id_tipo" => $servico->idTipo
        ]);
    }

    public function delete(int $id)
    {
        $this->decorator->update([
            "id" => $id
        ], [
            "esta_deletado" => 1
        ],);
    }

    public function getAll($idUsuario): array
    {
        $sql = $this->conn->prepare("
        SELECT 
            s.id as id,
            s.id_prestador as id_prestador,
            s.nome as nome,
            s.valor as valor,
            s.cidade as cidade,
            s.descricao as descricao,
            s.id_tipo as id_tipo
        FROM servicos s
        INNER JOIN datas_disponiveis d 
        ON s.id = d.id_servico
        INNER JOIN usuarios u
        ON s.id_prestador = u.id
        WHERE 
            s.esta_deletado = 0 AND
            d.disponivel = 1 AND
            d.data > CURRENT_DATE AND
            s.id_prestador != :idUsuario AND
            u.tipo = 'P' AND
            u.esta_deletado = 0
        GROUP BY d.id_servico");

        $sql->bindParam(":idUsuario", $idUsuario);

        $sql->execute();

        $servicosAssoc = $sql->fetchAll(PDO::FETCH_ASSOC);
        return ServicoDAO::assocsToServicos($servicosAssoc);
    }

    public function getAllToAdmin(): array{
        $servicosAssoc = $this->decorator->find(["esta_deletado" => 0]);
        return ServicoDAO::assocsToServicos($servicosAssoc);
    }

    public function getAllVendidosByIdVendaIdPerstador($idVenda, $idUsuario): array{
        $sql = $this->conn->prepare("
        SELECT 
            s.id as id,
            s.id_prestador as id_prestador,
            s.nome as nome,
            s.valor as valor,
            s.cidade as cidade,
            s.descricao as descricao,
            s.id_tipo as id_tipo
        FROM servicos s
        INNER JOIN datas_disponiveis d
        ON s.id = d.id_servico
        INNER JOIN vendas as v
        ON v.id = d.id_venda
        WHERE
            v.id = :idVenda AND
            s.id_prestador = :idUsuario
        GROUP BY s.id DESC    
        ");

        $sql->bindParam(":idVenda", $idVenda);
        $sql->bindParam(":idUsuario", $idUsuario);
        $sql->execute();

        $servicosAssoc = $sql->fetchAll(PDO::FETCH_ASSOC);

        return ServicoDAO::assocsToServicos($servicosAssoc);
    }

    public function getAllContratadosByIdVenda($idVenda): array{
        $sql = $this->conn->prepare("
        SELECT 
            s.id as id,
            s.id_prestador as id_prestador,
            s.nome as nome,
            s.valor as valor,
            s.cidade as cidade,
            s.descricao as descricao,
            s.id_tipo as id_tipo,
            u.nome as nome_prestador
        FROM servicos s
        INNER JOIN datas_disponiveis d
        ON s.id = d.id_servico
        INNER JOIN vendas as v
        ON v.id = d.id_venda
        INNER JOIN usuarios as u
        ON s.id_prestador = u.id
        WHERE
            v.id = :idVenda
        GROUP BY s.id DESC    
        ");

        $sql->bindParam(":idVenda", $idVenda);
        $sql->execute();

        $servicosAssoc = $sql->fetchAll(PDO::FETCH_ASSOC);

        return ServicoDAO::assocsToServicos($servicosAssoc);
    }

    public function find($busca): array
    {
        $sql = $this->conn->prepare("
        SELECT 
            s.id as id,
            s.id_prestador as id_prestador,
            s.nome as nome,
            s.valor as valor,
            s.cidade as cidade,
            s.descricao as descricao,
            s.id_tipo as id_tipo
        FROM servicos s
        INNER JOIN datas_disponiveis d 
        ON s.id = d.id_servico
        INNER JOIN tipos t
        ON s.id_tipo = t.id
        WHERE 
            s.esta_deletado = 0 AND
            d.disponivel = 1 AND
            d.data > CURRENT_DATE AND ".
            (is_numeric($busca) ? "s.valor = :busca" : "
            (
                s.nome LIKE :busca OR
                s.cidade LIKE :busca OR
                s.descricao LIKE :busca OR
                t.nome LIKE :busca
            )") . 
        " GROUP BY d.id_servico");

        if(!is_numeric($busca)){
            $busca = "%$busca%";
        }

        $sql->bindParam(":busca", $busca);
        $sql->execute();

        $servicosAssoc = $sql->fetchAll(PDO::FETCH_ASSOC);
        return ServicoDAO::assocsToServicos($servicosAssoc);
    }

    private static function assocToServico($data): Servico | null
    {
        if (!isset($data)) return null;

        $s = new Servico(
            $data["nome"],
            $data["valor"],
            $data["cidade"],
            $data["descricao"],
            $data["id_tipo"],
            $data["id_prestador"]
        );
        $s->id = $data["id"];

        if(isset($data["nome_prestador"])){
            $s->nomePrestador = $data["nome_prestador"];
        }

        return $s;
    }

    private static function assocsToServicos($data): array
    {
        if (!isset($data)) return [];

        $r = [];

        foreach ($data as $item) {
            $r[] = ServicoDAO::assocToServico($item);
        }

        return $r ?? [];
    }
}

?>
