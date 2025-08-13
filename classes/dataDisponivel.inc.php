<?php
final class DataDisponivel {
    private int $id;
    
    public function __construct(
        private int $idServico,
        private int $data,
        private bool $disponivel = true,
        private int $idVenda = 0,
        private bool $prestado = false
    ) { }

    public function __set($name, $value){
        $this->$name = $value;
    }
    
    public function __get($name){
        return $this->$name;
    }

    public function setData(string $value) {
        $this->data = strtotime($value);
    }

    // Serialization methods to handle session storage
    public function __sleep()
    {
        return ['id', 'idServico', 'data', 'disponivel', 'idVenda', 'prestado'];
    }

    public function __wakeup()
    {
        // Ensure all properties are properly initialized after unserialization
        if (!isset($this->id)) {
            $this->id = 0;
        }
    }
}
?>