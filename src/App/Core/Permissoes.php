<?php

namespace App\Core;
use PDO;

class Permissoes {

    protected $conn;
    protected $log;
    private $modulos;
    private $telas;

    function __construct(){
        $this->modulos=[
            "LoginController"=>[
                'permissao' => 0,
                'funcoes' => [
                        'getLogin'=>0,
                        'verificarLogado'=>1,
                        'deslogar'=>1
                    ]
            ],
            "UsuarioController"=>[
                'permissao' => 1,
                'funcoes' => [
                        'create'=>1,
                        'read'=>1,
                        'getId'=>1,
                        'update'=>1,
                        'delete'=>1,
                        'filter'=>1,
                        'readLimit'=>1,
                        'readUserOc'=>1
                    ]
            ],
            "VeiculoController"=>[
                'permissao' => 1,
                'funcoes' => [
                        'create'=>1,
                        'read'=>1,
                        'getId'=>1,
                        'update'=>1,
                        'delete'=>1,
                        'filter'=>1,
                        'readLimit'=>1
                    ]
            ],
            "ReservaController"=>[
                'permissao' => 1,
                'funcoes' => [
                        'create'=>1,
                        'read'=>1,
                        'getId'=>1,
                        'update'=>1,
                        'delete'=>1,
                        'filter'=>1,
                        'readLimit'=>1
                    ]
            ],
            "Gosth"=>[
                'permissao' => 0,
                'funcoes' => [
                        'gosth'=>0
                    ]
            ],
        ];

        $this->telas = [

            [
                'nome'=>"Usuários",
                'caminho'=>"usuario.php",
                'permissao'=>1
            ],
            [
                'nome'=>"Veículos",
                'caminho'=>"veiculo.php",
                'permissao'=>1
            ],
            [
                'nome'=>"Reservas",
                'caminho'=>"reserva.php",
                'permissao'=>1
            ],
            [
                'nome'=>"Login",
                'caminho'=>"",
                'permissao'=>1
            ],  
        ];
        
    }   
    /**
     * RETORNA AS TELAS QUE O USUÁRIO TEM PERMISSÃO DE ACESSO
     */
    function telasUsuario($dadosUsuario){  
        
        $t = [];
        
        $telas = $this->telas;
 
        foreach($telas as $tela){
            
            $tel = $this->permissao($tela,$dadosUsuario);
           
            if($tel){
                $t['telas'][] = $tela;
            }

        }

        return $t;
    }

    function permissaoUsuario($class,$method,$dadosUsuario){
        
        $permissaoClass = $this->modulos[$class]['permissao'];
        $permissaoMethod = $this->modulos[$class]['funcoes'][$method];
        $permissaoUser = $dadosUsuario['permissao'];

        $key = array_key_exists($method, $this->modulos[$class]['funcoes']);
      
      
        if($key && $permissaoUser >= $permissaoClass && $permissaoUser >= $permissaoMethod){
            return true;
        }
        
        return false;
        

    }

    /**
     * verifica se a permissão do usuário é equivalente ao acesso
     */
    private function permissao($tela,$dadosUsuario){
        
        if($dadosUsuario['permissao'] >= $tela['permissao']){
            return $tela;
        }

        return false;

    }
    
}