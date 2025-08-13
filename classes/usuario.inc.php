<?php
final class Usuario 
{
    private int $id;
    private bool $possuiServicosFuturosAPrestar;
    private bool $possuiServicosFuturosContratados;

    public function __construct(
        private string $nome,
        private string $endereco,
        private string $telefone,
        private string $cpf_cnpj,
        private int $dtNascimento,
        private string $email,
        private string $senha,
        private string $tipo
    ) {}

    function __get($name) {
        return $this->$name;
    }

    function __set($name, $value) {
        $this->$name = $value;
    }

    function setDtNascimento(string $value){
        $this->dt_nascimento = strtotime($value);
    }

    // Serialization methods to handle session storage
    public function __sleep()
    {
        return ['id', 'possuiServicosFuturosAPrestar', 'possuiServicosFuturosContratados', 'nome', 'endereco', 'telefone', 'cpf_cnpj', 'dtNascimento', 'email', 'senha', 'tipo'];
    }

    public function __wakeup()
    {
        // Ensure all properties are properly initialized after unserialization
        if (!isset($this->id)) {
            $this->id = 0;
        }
        if (!isset($this->possuiServicosFuturosAPrestar)) {
            $this->possuiServicosFuturosAPrestar = false;
        }
        if (!isset($this->possuiServicosFuturosContratados)) {
            $this->possuiServicosFuturosContratados = false;
        }
    }
}
?>