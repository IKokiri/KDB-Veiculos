<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class VeiculoModel extends Model{

    private $table = "`veiculos`";
    private $model = "VeiculoModel";

    function read(){
        
        $sql = "SELECT * FROM ".$this->table." ";

        $query = $this->conn->prepare($sql);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model read) os registros");

        return $result;

    }

    function readLimit($data){
        
        $this->populate($data);

        $sql = "SELECT * FROM ".$this->table." limit :pagini,:pagfim";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':pagini', (int)$this->pagini, PDO::PARAM_INT);
        $query->bindValue(':pagfim', (int)$this->pagfim, PDO::PARAM_INT);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model readLimit) os registros");

        return $result;

    }


    function getId($data){
        
        $this->populate($data);

        $sql = "SELECT * FROM ".$this->table." 
        WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model getId) o registro $this->id");

        return $result;
    }

    function filter($data){
        
        $this->populate($data);

        $sql = "SELECT * FROM ".$this->table." 
        WHERE `email` LIKE :email;";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':email', "%".$this->term."%", PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Filtrou ($this->model getId) o registro");

        return $result;
    }    

    function create($data){
        
        $this->populate($data);
        
        $sql = "INSERT INTO ".$this->table." 
                    (`marca`,
                    `modelo`,
                    `placa`)
                    VALUES
                    (:marca,
                    :modelo,
                    :placa)";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $query->bindValue(':modelo', $this->modelo, PDO::PARAM_STR);
        $query->bindValue(':placa', $this->placa, PDO::PARAM_STR);
        
        $result = Database::executa($query); 
          
        $this->log->setInfo("Criou ($this->model create) o registro ". $this->conn->lastInsertId());

        return $result;
    }

    function update($data){

        $this->populate($data);

        $sql = "UPDATE ".$this->table." 
                SET
                `marca` = :marca,
                `modelo` = :modelo,
                `placa` = :placa
                WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':marca', $this->marca, PDO::PARAM_STR);        
        $query->bindValue(':modelo', $this->modelo, PDO::PARAM_STR);  
        $query->bindValue(':placa', $this->placa, PDO::PARAM_STR);
      
        $result = Database::executa($query);   

        $this->log->setInfo("Atualizaou ($this->model update) o registro $this->id");

        return $result;
    }

    function delete($data){

        $this->populate($data);

        $sql = "DELETE FROM ".$this->table." 
                    WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Removeu ($this->model delete) o registro $this->id");
        
        return $result;
    }


}

