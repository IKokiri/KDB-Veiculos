<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class ReservaModel extends Model{

    private $table = "`reservas`";
    private $model = "ReservaModel";

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
                    (`id_veiculo`,
                    `id_funcionario`,
                    `data_saida`,
                    `data_retorno`,
                    `local`,
                    `id_contrato`)
                    VALUES
                    (:id_veiculo,
                     :id_funcionario,
                     :data_saida,
                     :data_retorno,
                     :local,
                     :id_contrato)";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id_veiculo', $this->id_veiculo, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':data_saida', $this->data_saida, PDO::PARAM_STR);
        $query->bindValue(':data_retorno', $this->data_retorno, PDO::PARAM_STR);
        $query->bindValue(':local', $this->local, PDO::PARAM_STR);
        $query->bindValue(':id_contrato', $this->id_contrato, PDO::PARAM_STR);
        
        $result = Database::executa($query); 
          
        $this->log->setInfo("Criou ($this->model create) o registro ". $this->conn->lastInsertId());

        return $result;
    }

    function update($data){

        $this->populate($data);

        $sql = "UPDATE ".$this->table." 
                SET
                `id_veiculo` = :id_veiculo,
                `id_funcionario` = :id_funcionario,
                `data_saida` = :data_saida,
                `data_retorno` = :data_retorno,
                `local` = :local,
                `id_contrato` = :id_contrato
                WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':id_veiculo', $this->id_veiculo, PDO::PARAM_STR);        
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);  
        $query->bindValue(':data_saida', $this->data_saida, PDO::PARAM_STR);
        $query->bindValue(':data_retorno', $this->data_retorno, PDO::PARAM_STR);
        $query->bindValue(':local', $this->local, PDO::PARAM_STR);
        $query->bindValue(':id_contrato', $this->id_contrato, PDO::PARAM_STR);
      
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

