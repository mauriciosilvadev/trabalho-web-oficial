<?php
require_once "item.inc.php";
final class Venda
{
    private int $id;
    private int $data;
    private array $itens = [];

    public function __construct(
        private int $idContratante,
        private float $valor,
        private string $formaPagamento
    ) {
        $this->data = strtotime("now");
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function addItem(item $item)
    {
        $this->itens[] = $item;
    }

    public function __sleep()
    {
        return ['id', 'data', 'itens', 'idContratante', 'valor', 'formaPagamento'];
    }

    public function __wakeup()
    {
        if (!isset($this->itens)) {
            $this->itens = [];
        }
        if (!isset($this->data)) {
            $this->data = strtotime("now");
        }
    }
}
