<?php

$url = '../';
require 'Dados.php';

class UserDao extends Dados {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function findUserByFilter($filter = null) {
        try {
            $conexao = $this->ConectarBanco();
            $sql = "SELECT  us.`id`, 
                            us.`nome`, 
                            us.`email`, 
                            us.`data_nascimento`, 
                            us.`telefone`, 
                            us.`foto`, 
                            us.`fundo`, 
                            us.`descricao`, 
                            us.`site`, 
                            us.`senha` 
                            FROM `tb_game_user` us WHERE " . $filter;

            
            $query = mysqli_query($conexao,$sql);
            $html = $this->montarRetornoObjeto($query);
            $this->FecharBanco($conexao);

            return $html;
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }  



    public function findUserById($idUser) {
        try {
            $conexao = $this->ConectarBanco();
            $sql = "SELECT  us.`id`, 
                            us.`nome`, 
                            us.`email`, 
                            us.`data_nascimento`, 
                            us.`telefone`, 
                            us.`foto`,
                            us.`fundo`, 
                            us.`descricao`, 
                            us.`site`                            
                            FROM `tb_game_user` us WHERE us.`id` = " . $idUser;

            
            $query = mysqli_query($conexao,$sql);
            $html = $this->montarRetornoObjetoJson($query);
            $this->FecharBanco($conexao);

            return $html;
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }       

    public function montarRetornoObjeto($query) {
        $retorno = null;
        while ($objItem = mysqli_fetch_object($query)) {
            $retorno = $objItem;
        }
        return $retorno;
    }

    public function montarRetornoObjetoJson($query) {
        $retorno = null;
        while ($objItem = mysqli_fetch_object($query)) {
            $retorno = $objItem;
        }
        return json_encode($retorno);
    }    

    //USADO
    public function montarRetornoArrayJson($query) {
        $array = array();       
        while ($objItem = mysqli_fetch_object($query)) {
            $array[] = $objItem;            
        }
        return json_encode($array);
    }


    public function findAllLog($idUser) {
        try {           
            $conexao = $this->ConectarBanco();
            $sql = "SELECT  log.`id`, 
                            log.`descricao`,
                            log.`id_item`,
                            i.`titulo`,
                            log.`icone`,                  
                            log.`data`                                                      
                            FROM `tb_game_log` log 
                            INNER JOIN `tb_game_item` i ON (i.`id` = log.`id_item`)
                            WHERE  log.`id_user` = ".$idUser."
                             ORDER BY log.`data` DESC
                            LIMIT 0, 10";
            $query = mysqli_query($conexao,$sql);
            $html = $this->montarRetornoArrayJson($query);
            $this->FecharBanco($conexao);

            return $html;      
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }



   
    //USADO
    public function addLog($log) {
        try {
            
            $conexao = $this->ConectarBanco();
            $html = null;
            $sql = "INSERT INTO `tb_game_log` (`id`, 
                                                `id_user`, 
                                                `descricao`,
                                                `id_item`,
                                                `icone`,
                                                `data`)                                                
                                                VALUES 
                                                (NULL, 
                                                 '" . $log->getIdUser() . "', 
                                                 '" . $log->getDescricao() . "', 
                                                 '" . $log->getIdItem() . "', 
                                                 '" . $log->getIcone() . "', 
                                                 NOW())";

            $query = mysqli_query($conexao, $sql) or die('Erro na execução da query!');
            $this->FecharBanco($conexao);        
            return $query;

        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }  


    public function updateUser($user) {
        try {
            $conexao = $this->ConectarBanco();
            $html = null;
            $sql = "UPDATE `tb_game_user` SET   `nome` =  '" . $user->getNome() . "',       
                                                `descricao` =  '" . $user->getDescricao() . "',         
                                                `telefone` =  '" . $user->getTelefone() . "',         
                                                `site` =  '" . $user->getSite() . "',       
                                                `data_nascimento` =  '" . $user->getDataNascimento() . "',        
                                                `email` =  '" . $user->getEmail() . "',
                                                `foto` =  '" . $user->getFoto() . "',
                                                `fundo` =  '" . $user->getFundo() . "'
                                                WHERE `id` = " . $user->getId() . "";

            $query = mysqli_query($conexao, $sql) or die('Erro na execução da query!');
            $this->FecharBanco($conexao);        
            return $query;

        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    } 


    public function updateSenha($user) {
        try {
            $conexao = $this->ConectarBanco();
            $html = null;
            $sql = "UPDATE `tb_game_user` SET   `senha` =  '" . $user->getSenha() . "'
                                                WHERE `id` = " . $user->getId() . "";

            $query = mysqli_query($conexao, $sql) or die('Erro na execução da query!');
            $this->FecharBanco($conexao);        
            return $query;

        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }                  

}

?>