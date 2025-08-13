<?php
final class Tipo
{
    private int $id;
   
    public function __construct(
        private string $nome
    ) {}

    public function __get ($name){
        return $this->$name;
    }

    public function __set($name, $value){
        $this->$name = $value;
    }

    // Serialization methods to handle session storage
    public function __sleep()
    {
        return ['id', 'nome'];
    }

    public function __wakeup()
    {
        // Ensure all properties are properly initialized after unserialization
        if (!isset($this->id)) {
            $this->id = 0;
        }
        if (!isset($this->nome)) {
            $this->nome = '';
        }
    }
}
?>