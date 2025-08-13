<?php

final class GenericDAO 
{
    public function __construct(
        private PDO $conn, 
        private string $tableName,
        private ?string $className = null,
    ) {} 

    public function find(array $fieldsValues = null) : array | null {
        $findClause = "";

        if(isset($fieldsValues)){
            $findClause = " WHERE " . $this->getClause($fieldsValues, " AND ");
        }

        $sql = $this->conn->prepare(
        "
            SELECT * 
            FROM $this->tableName
        " 
            . $findClause
        );

        foreach ($fieldsValues as $key => $value) {
            $sql->bindValue(":" . $key, $value);
        }

        $sql->execute();
        $result = null;

        if($sql->rowCount() > 0){
            if(isset($this->className)){
                $result = $sql->fetchAll(PDO::FETCH_CLASS, $this->className);
            }else{
                $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        
        return $result;
    }

    public function insert(array $data) : int {
        $collumns = implode(", ", array_keys($data));
        $values =   ":" . implode(", :", array_keys($data));

        $sql = $this->conn->prepare(
        "
            INSERT INTO $this->tableName ($collumns) 
            VALUES ($values)
        "
        );

        foreach ($data as $key => $value) {
            $sql->bindValue(":" . $key, $value);
        }

        $sql->execute();

        return $this->conn->lastInsertId();
    }

    public function update(array $wheres, array $sets) {
        $setClause = $this->getClause($sets, ", ");
        $whereClause = $this->getClause($wheres, " AND ");
    
        $sql = $this->conn->prepare(
            "UPDATE $this->tableName 
            SET " . $setClause . 
            " WHERE " . $whereClause
        );
    
        foreach ($sets as $key => $value) {
            $sql->bindValue(":" . $key, $value);
        }

        foreach ($wheres as $key => $value) {
            $sql->bindValue(":" . $key, $value);
        }
    
        $sql->execute();
    }

    public function delete(array $fieldsValues) {
        $findClause = $this->getClause($fieldsValues, " AND ");

        $sql = $this->conn->prepare("DELETE FROM $this->tableName WHERE " . $findClause);

        foreach ($fieldsValues as $key => $value) {
            $sql->bindValue(":" . $key, $value);
        }

        $sql->execute();
    }

    private function getClause(array $fieldsValues, string $sep) : string{
        $clauses = [];

        foreach (array_keys($fieldsValues) as $key) {
            $clauses[] = "$key = :$key";
        }

        return implode($sep, $clauses);
    }
}
?>