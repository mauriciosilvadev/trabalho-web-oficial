<?php
require_once "conexao.inc.php";
require_once "genericDAO.inc.php";
require_once "../classes/tipo.inc.php";

final class TipoDAO
{
    private PDO $conn;
    private GenericDAO $decorator;

    public function __construct() {
        $c = new Conexao();

        $this->conn = $c->getConexao();
        $this->decorator = new GenericDAO($this->conn, "tipos");
    }

    
    public function getById($id) : Tipo | null {
        $r = $this->decorator->find(["id" => $id]);

        $retorno = null;

        if(isset($r)){
            $retorno = TipoDAO::assocToTipo($r[0]);
        }
        
        return $retorno;
    }

    public function getAll() : array | null{
        $r = $this->decorator->find();

        return TipoDAO::assocsToTipos($r);
    }

    private static function assocToTipo($data) : Tipo | null {
        if(!isset($data)) return null;

        $t = new Tipo($data["nome"]);
        $t->id= $data["id"];

        return $t;
    }

    private static function assocsToTipos($data) : array {
        if(!isset($data)) return [];
        
        $r = [];

        foreach($data as $item){
            $r[] = TipoDAO::assocToTipo($item);
        }

        return $r;
    }
}



?>