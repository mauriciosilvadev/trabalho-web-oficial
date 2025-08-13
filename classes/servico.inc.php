<?php
require_once "dataDisponivel.inc.php";
require_once "tipo.inc.php";

final class Servico 
{
    private int $id;
    private Tipo $tipo;
    private array $datasDisponiveis;
    private bool $possuiServicoAFazer;
    private string $nomePrestador;

    
    public function __construct(
        private string $nome,
        private float $valor,
        private string $cidade,
        private string $descricao,
        private int $idTipo,
        private int $idPrestador
    ) {}

    public function __get ($name){
        return $this->$name;
    }

    public function __set($name, $value){
        $this->$name = $value;
    }

    public function getData($idData){
        foreach($this->datasDisponiveis as $data){
            if($data->id == $idData){
                return $data;
            }
        }
        return null;
    }

    // Serialization methods to handle session storage
    public function __sleep()
    {
        return ['id', 'tipo', 'datasDisponiveis', 'possuiServicoAFazer', 'nomePrestador', 'nome', 'valor', 'cidade', 'descricao', 'idTipo', 'idPrestador'];
    }

    public function __wakeup()
    {
        // Ensure all properties are properly initialized after unserialization
        if (!isset($this->datasDisponiveis)) {
            $this->datasDisponiveis = [];
        }
        if (!isset($this->id)) {
            $this->id = 0;
        }
        if (!isset($this->possuiServicoAFazer)) {
            $this->possuiServicoAFazer = false;
        }
        if (!isset($this->nomePrestador)) {
            $this->nomePrestador = '';
        }
    }
}
?>