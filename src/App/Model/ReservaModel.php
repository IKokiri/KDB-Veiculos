<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;
use GuzzleHttp\Client;

class ReservaModel extends Model{

    private $table = "`reservas`";
    private $model = "ReservaModel";
    private $client;

    function read(){
        
        $sql = "SELECT * FROM ".$this->table." ";

        $query = $this->conn->prepare($sql);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model read) os registros");

        return $result;

    }

    function readLimit($data){
        
        $this->populate($data);

       $sql = "SELECT res.*,vei.marca,vei.modelo,vei.placa FROM ".$this->table." res
       INNER JOIN veiculos vei
       on res.id_veiculo = vei.id 
       order by res.data_retorno asc, res.data_retorno desc
       limit :pagini,:pagfim";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':pagini', (int)$this->pagini, PDO::PARAM_INT);
        $query->bindValue(':pagfim', (int)$this->pagfim, PDO::PARAM_INT);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model readLimit) os registros");

        return $result;

    }

    function filter($data){
        
        $this->populate($data);

        $sql = "SELECT res.*,vei.marca,vei.modelo,vei.placa FROM ".$this->table." res
       INNER JOIN veiculos vei
       on res.id_veiculo = vei.id
       where  
       `data_saida` LIKE :data_saida or
       `data_retorno` LIKE :data_retorno or  
       `local` LIKE :local or  
       `marca` LIKE :marca or  
       `modelo` LIKE :modelo or  
       `placa` LIKE :placa";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':data_saida', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':data_retorno', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':local', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':marca', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':modelo', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':placa', "%".$this->term."%", PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Filtrou ($this->model getId) o registro");

        return $result;
    }    


    function getId($data){

        $this->populate($data);

        $clientF = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://201.49.127.157:9003/gesstor/App/API/funcionarios.php',
        ]);         
        $response = $clientF->request('GET', '', []);
        $body = $response->getBody();
        $arr_func = json_decode($body,true);
        $clientC = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://201.49.127.157:9003/gesstor/App/API/contratos.php',
        ]);         
        $response = $clientC->request('GET', '', []);
        $body = $response->getBody();
        $arr_cont = json_decode($body,true);

        $sql = "SELECT res.*,vei.marca,vei.modelo,vei.placa FROM ".$this->table." res
         left join veiculos vei
         on res.id_veiculo = vei.id
         left join usuarios usu
         on res.id_funcionario = usu.id
        WHERE res.id = :id;";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);

        $id_funcionario = $result['result_array'][0]['id_funcionario'];
        $id_contrato = $result['result_array'][0]['id_contrato'];
            
        $result['result_array'][0]['funcionario']= $arr_func[$id_funcionario]['nome'];        
        $result['result_array'][0]['contrato']= $arr_cont[$id_contrato]['contrato'];
        $this->log->setInfo("Buscou ($this->model getId) o registro $this->id");

        return $result;
    }


    function create($data){
        
        $this->populate($data);
        
        $sql = "INSERT INTO ".$this->table." 
                    (`id_veiculo`,
                    `id_funcionario`,
                    `data_saida`,
                    `data_retorno`,
                    `data_retorno_previsto`,
                    `local`,
                    `observacao`,
                    `id_contrato`)
                    VALUES
                    (:id_veiculo,
                     :id_funcionario,
                     :data_saida,
                    :data_retorno,
                     :data_retorno_previsto,
                     :local,
                     :observacao,
                     :id_contrato)";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id_veiculo', $this->id_veiculo, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':data_saida', $this->data_saida, PDO::PARAM_STR);
        $query->bindValue(':data_retorno', $this->data_retorno, PDO::PARAM_STR);
        $query->bindValue(':data_retorno_previsto', $this->data_retorno_previsto, PDO::PARAM_STR);
        $query->bindValue(':local', $this->local, PDO::PARAM_STR);
        $query->bindValue(':observacao', $this->observacao, PDO::PARAM_STR);
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
                `data_retorno_previsto` = :data_retorno_previsto,
                `local` = :local,
                `id_contrato` = :id_contrato,
                `observacao` = :observacao
                WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':id_veiculo', $this->id_veiculo, PDO::PARAM_STR);        
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);  
        $query->bindValue(':data_saida', $this->data_saida, PDO::PARAM_STR);
        $query->bindValue(':data_retorno', $this->data_retorno, PDO::PARAM_STR);
        $query->bindValue(':data_retorno_previsto', $this->data_retorno_previsto, PDO::PARAM_STR);
        $query->bindValue(':local', $this->local, PDO::PARAM_STR);
        $query->bindValue(':observacao', $this->observacao, PDO::PARAM_STR);
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

