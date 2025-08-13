<?php
require_once "servico.inc.php";
require_once "dataDisponivel.inc.php";

final class item
{
    private array $datas = [];
    public function __construct(
        private Servico $servico
    ) {}

    public function getServico(): ?Servico
    {
        if (!isset($this->servico) || !($this->servico instanceof Servico)) {
            return null;
        }
        return $this->servico;
    }

    public function getData(int $id): ?DataDisponivel
    {
        foreach ($this->datas as $data) {
            if ($data->id == $id) {
                return $data;
            }
        }

        return null;
    }

    public function getDatas(): array
    {
        return $this->datas ?? [];
    }

    public function addData(DataDisponivel $data)
    {
        $this->datas[] = $data;
    }

    public function addDatas(array $datas)
    {
        $this->datas = array_merge($this->datas, $datas);
    }

    public function removeData(int $id)
    {
        $this->datas = array_filter($this->datas, function ($data) use ($id) {
            return $data->id != $id;
        });
    }

    public function __sleep()
    {
        return ['datas', 'servico'];
    }

    public function __wakeup() {}
}
