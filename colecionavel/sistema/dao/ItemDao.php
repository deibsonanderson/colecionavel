<?php

$url = '../';
require 'Dados.php';

class ItemDao extends Dados {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }
    
    //USADO
    public function addItem($item) {
        try {            
            $sql = "INSERT INTO `tb_game_item` (`id`, 
                                                `data_cadastro`, 
                                                `data_update`, 
                                                `titulo`, 
                                                `descricao`, 
                                                `imagem`, 
                                                `procedencia`, 
                                                `regiao`, 
                                                `valor_pago`, 
                                                `valor_atual`, 
                                                `plataforma`, 
                                                `tipo`, 
                                                `codigo`, 
                                                `complemento`, 
                                                `avaliacao`, 
                                                `local_primeiro`, 
                                                `local_segundo`, 
                                                `local_terceiro`,
                                                `flag_cartucho_disco`,
                                                `flag_replica`,
                                                `flag_protetor`,
                                                `flag_cd_dvd`,
                                                `flag_caixa`,
                                                `flag_manual`, 
                                                `flag_berco`,
                                                `flag_panfleto`, 
                                                `flag_poster`,
                                                `flag_nota_fiscal`, 
                                                `flag_lacrado`, 
                                                `flag_luva`,
                                                `id_user`,   
                                                `status`,
                                                `progressao`,
                                                `situacao`,
                                                `possui`,
                                                `genero`,
                                                `produtora`,
												`quantidade`,												
                                                `tempo`,
                                                `num_jogadas`,    
                                                `publicadora`) 
                                                VALUES 
                                                (NULL, 
                                                 NOW(),
                                                 NOW(), 
                                                '" . $item->getTitulo() . "', 
                                                '" . $item->getDescricao() . "', 
                                                '" . $item->getImagem() . "', 
                                                '" . $item->getProcedencia() . "', 
                                                '" . $item->getRegiao() . "', 
                                                '" . $item->getValorPago() . "', 
                                                '" . $item->getValorAtual() . "', 
                                                '" . $item->getPlataforma() . "',  
                                                '" . $item->getTipo() . "', 
                                                '" . $item->getCodigo() . "', 
                                                '" . $item->getComplemento() . "',  
                                                '" . $item->getAvaliacao() . "', 
                                                '" . $item->getLocalPrimeiro() . "',  
                                                '" . $item->getLocalSegundo() . "', 
                                                '" . $item->getLocalTerceiro() . "',
                                                '" . $item->getFlagCartuchoDisco() . "',  
                                                '" . $item->getFlagReplica() . "',  
                                                '" . $item->getFlagProtetor() . "',  
                                                '" . $item->getFlagCdDvdGdBd() . "',   
                                                '" . $item->getFlagCaixa() . "',  
                                                '" . $item->getFlagManual() . "',   
                                                '" . $item->getFlagBerco() . "',  
                                                '" . $item->getFlagPanfleto() . "',   
                                                '" . $item->getFlagPoster() . "',  
                                                '" . $item->getFlagNotaFiscal() . "',   
                                                '" . $item->getFlagLacrado() . "',
                                                '" . $item->getFlagLuva() . "',   
                                                '" . $item->getIdUser() . "',   
                                                '" . $item->getStatus() . "',   
                                                '" . $item->getProgressao() . "',   
                                                '" . $item->getSituacao() . "',
                                                '" . $item->getPossui() . "',   
                                                '" . $item->getGenero() . "',   
                                                '" . $item->getProdutora() . "', 
												'" . $item->getQuantidade() . "', 
                                                '" . $item->getTempo() . "',
                                                '" . $item->getNumJogadas() . "', 
                                                '" . $item->getPublicadora() . "')";

            
            $item->setId($this->carregarDados($sql,null)); 

            $this->carregarDados("UPDATE `tb_game_item` SET `screenshot1` = '" . $item->getScreenshot1() . "' WHERE `id` = " . $item->getId() . "",null); 
            $this->carregarDados("UPDATE `tb_game_item` SET `screenshot2` = '" . $item->getScreenshot2() . "' WHERE `id` = " . $item->getId() . "",null); 
            $this->carregarDados("UPDATE `tb_game_item` SET `screenshot3` = '" . $item->getScreenshot3() . "' WHERE `id` = " . $item->getId() . "",null); 
            $this->carregarDados("UPDATE `tb_game_item` SET `screenshot4` = '" . $item->getScreenshot4() . "' WHERE `id` = " . $item->getId() . "",null); 

            return $item->getId();


        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }

    //USADO
    public function findAllItem($filter) {
        try {
            
            $sql = "SELECT  gi.`id`, 
                            DATE_FORMAT(gi.`data_cadastro`, '%d/%m/%Y') as data_cadastro, 
                            gi.`titulo`, 
                            gi.`descricao`, 
                            gi.`imagem`, 
                            gi.`procedencia`,
			                gi.`regiao`, 
                            gi.`valor_pago`, 
                            gi.`valor_atual`, 
                            gi.`plataforma`, 
                            gi.`tipo`, 
                            gi.`codigo`, 
                            gi.`complemento`, 
                            gi.`avaliacao`, 
                            gi.`local_primeiro`, 
                            gi.`local_segundo`, 
                            gi.`local_terceiro`,
                            gi.`flag_cartucho_disco`,
                            gi.`flag_replica`,
                            gi.`flag_protetor`,
                            gi.`flag_cd_dvd`,
                            gi.`flag_caixa`,
                            gi.`flag_manual`, 
                            gi.`flag_berco`,
                            gi.`flag_panfleto`, 
                            gi.`flag_poster`,
                            gi.`flag_nota_fiscal`, 
                            gi.`flag_lacrado`, 
                            gi.`flag_luva`,
                            gi.`id_user`,   
                            gi.`status`,
                            gi.`progressao`,
                            gi.`situacao`,
                            gi.`genero`,
                            gi.`produtora`,
							gi.`quantidade`,	
                            gi.`publicadora`,
                            gi.`screenshot1`,
                            gi.`screenshot2`,
                            gi.`screenshot3`,
                            gi.`screenshot4`,
                            gi.`tempo`,
                            gi.`num_jogadas`,                                                         
                            gi.`possui`                            
                            FROM `tb_game_item` gi ".$filter;
            return $this->carregarDados($sql,false);

        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }

    //USADO
    public function updateItem($item) {
        try {
            
            $sql = "UPDATE `tb_game_item` SET   `data_update` =  NOW(),
                                                `titulo` =  '" . $item->getTitulo() . "', 		
                                                `descricao` =  '" . $item->getDescricao() . "', 		
                                                `imagem` =  '" . $item->getImagem() . "', 		
                                                `procedencia` =  '" . $item->getProcedencia() . "', 		
                                                `regiao` =  '" . $item->getRegiao() . "', 		
                                                `valor_pago` =  '" . $item->getValorPago() . "', 		
                                                `valor_atual` =  '" . $item->getValorAtual() . "', 		
                                                `plataforma` =  '" . $item->getPlataforma() . "',  		
                                                `tipo` =  '" . $item->getTipo() . "', 		
                                                `codigo` =  '" . $item->getCodigo() . "', 		
                                                `complemento` =  '" . $item->getComplemento() . "',  		
                                                `avaliacao` =  '" . $item->getAvaliacao() . "', 		
                                                `local_primeiro` =  '" . $item->getLocalPrimeiro() . "',  		
                                                `local_segundo` =  '" . $item->getLocalSegundo() . "', 		
                                                `local_terceiro` = '" . $item->getLocalTerceiro() . "',
                                                `flag_cartucho_disco` =  '" . $item->getFlagCartuchoDisco() . "',
                                                `flag_replica` =  '" . $item->getFlagReplica() . "',
                                                `flag_protetor` =  '" . $item->getFlagProtetor() . "',
                                                `flag_cd_dvd`  =  '" . $item->getFlagCdDvdGdBd() . "',
                                                `flag_caixa`  =  '" . $item->getFlagCaixa() . "',
                                                `flag_manual`  =  '" . $item->getFlagManual() . "',
                                                `flag_berco` =  '" . $item->getFlagBerco() . "',
                                                `flag_panfleto`  =  '" . $item->getFlagPanfleto() . "',
                                                `flag_poster` =  '" . $item->getFlagPoster() . "',
                                                `flag_nota_fiscal`  =  '" . $item->getFlagNotaFiscal() . "',
                                                `flag_lacrado`  =  '" . $item->getFlagLacrado() . "',
                                                `flag_luva`  =  '" . $item->getFlagLuva() . "',   
                                                `id_user`  =  '" . $item->getIdUser() . "',    
                                                `status`  =  '" . $item->getStatus() . "',    
                                                `progressao`  =  " . $item->getProgressao() . ",    
                                                `situacao`  =  '" . $item->getSituacao() . "',    
                                                `genero`  =  '" . $item->getGenero() . "',    
                                                `quantidade`  =  '" . $item->getQuantidade() . "',
                                                `publicadora`  =  '" . $item->getPublicadora() . "',												
                                                `produtora`  =  '" . $item->getProdutora() . "',
                                                `tempo`  =  '" . $item->getTempo() . "',
                                                `num_jogadas`  =  '" . $item->getNumJogadas() . "',
                                                `possui`  =  '" . $item->getPossui() . "'    
                                                WHERE `id` = " . $item->getId() . "";

            $this->carregarDados($sql,null); 

            $this->carregarDados("UPDATE `tb_game_item` SET `screenshot1` = '" . $item->getScreenshot1() . "' WHERE `id` = " . $item->getId() . "",null); 
            $this->carregarDados("UPDATE `tb_game_item` SET `screenshot2` = '" . $item->getScreenshot2() . "' WHERE `id` = " . $item->getId() . "",null); 
            $this->carregarDados("UPDATE `tb_game_item` SET `screenshot3` = '" . $item->getScreenshot3() . "' WHERE `id` = " . $item->getId() . "",null); 
            return $this->carregarDados("UPDATE `tb_game_item` SET `screenshot4` = '" . $item->getScreenshot4() . "' WHERE `id` = " . $item->getId() . "",null); 


        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }

    //USADO
    public function deleteItem($item) {
        try {
            
            $sql = "DELETE FROM `tb_game_item` WHERE `id` = " . $item->getId() . "";
            return $this->carregarDados($sql,null); 

        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }

    //USADO
    public function findItemByFilter($filter = null) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            DATE_FORMAT(gi.`data_cadastro`, '%d/%m/%Y') as data_cadastro, 
                            gi.`titulo`, 
                            gi.`descricao`,                            
                            gi.`procedencia`,
                            gi.`imagem`, 
			                gi.`regiao`, 
                            gi.`valor_pago`, 
                            gi.`valor_atual`, 
                            gi.`plataforma`, 
                            gi.`tipo`, 
                            gi.`codigo`, 
                            gi.`complemento`, 
                            gi.`avaliacao`, 
                            gi.`local_primeiro`, 
                            gi.`local_segundo`, 
                            gi.`local_terceiro`,
                            gi.`flag_cartucho_disco`,
                            gi.`flag_replica`,
                            gi.`flag_protetor`,
                            gi.`flag_cd_dvd`,
                            gi.`flag_caixa`,
                            gi.`flag_manual`, 
                            gi.`flag_berco`,
                            gi.`flag_panfleto`, 
                            gi.`flag_poster`,
                            gi.`flag_nota_fiscal`, 
                            gi.`flag_lacrado`, 
                            gi.`flag_luva`,
                            gi.`id_user`,   
                            gi.`status`,
                            gi.`progressao`,
                            gi.`situacao`,
                            gi.`genero`,
                            gi.`produtora`,
                            gi.`publicadora`,
                            gi.`tempo`,
                            gi.`num_jogadas`,
							gi.`quantidade`,
                            gi.`screenshot1`,
                            gi.`screenshot2`,
                            gi.`screenshot3`,
                            gi.`screenshot4`,                                                                                                               
                            gi.`possui`
                            FROM `tb_game_item` gi " . $filter;
            //die($sql);                
            return $this->carregarDados($sql,false);            
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }

    //USADO
    public function findItemById($filter = null,$isJson) {
        try {
            
            $sql = "SELECT  gi.`id`, 
                            DATE_FORMAT(gi.`data_cadastro`, '%d/%m/%Y') as data_cadastro, 
                            gi.`titulo`, 
                            gi.`descricao`, 
                            gi.`imagem`, 
                            gi.`procedencia`,
			                gi.`regiao`, 
                            gi.`valor_pago`, 
                            gi.`valor_atual`, 
                            gi.`plataforma`, 
                            gi.`tipo`, 
                            gi.`codigo`, 
                            gi.`complemento`, 
                            gi.`avaliacao`, 
                            gi.`local_primeiro`, 
                            gi.`local_segundo`, 
                            gi.`local_terceiro`,
                            gi.`flag_cartucho_disco`,
                            gi.`flag_replica`,
                            gi.`flag_protetor`,
                            gi.`flag_cd_dvd`,
                            gi.`flag_caixa`,
                            gi.`flag_manual`, 
                            gi.`flag_berco`,
                            gi.`flag_panfleto`, 
                            gi.`flag_poster`,
                            gi.`flag_nota_fiscal`, 
                            gi.`flag_lacrado`, 
                            gi.`flag_luva`,
                            gi.`id_user`,   
                            gi.`status`,
                            gi.`progressao`,
                            gi.`situacao`,
                            gi.`genero`,
                            gi.`produtora`,
							gi.`quantidade`,
                            gi.`publicadora`,
                            gi.`screenshot1`,
                            gi.`screenshot2`,
                            gi.`screenshot3`,
                            gi.`screenshot4`,  
                            gi.`tempo`,
                            gi.`num_jogadas`,                                                                                                                                         
                            gi.`possui`                            
                            FROM `tb_game_item` gi " . $filter;
            if($isJson === true){
                $conexao = $this->ConectarBanco();
                $query = mysqli_query($conexao,$sql) or die('Erro na execução do listar com filtro!');
                $html = $this->montarRetornoObjeto($query);
                $this->FecharBanco($conexao);               
                return $html; 
            }else{                
                return $this->carregarDados($sql,true);
            }
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    } 


    public function findItemByVideoGame($idUser) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            DATE_FORMAT(gi.`data_cadastro`, '%d/%m/%Y') as data_cadastro, 
                            gi.`titulo`,                             
                            gi.`plataforma`, 
                            gi.`tipo`, 
                            gi.`status`,
                            gi.`situacao`,
                            gi.`regiao`,
                            gi.`produtora`,
							gi.`quantidade`,
                            gi.`publicadora`,                           
                            gi.`possui`
                            FROM `tb_game_item` gi 
                            WHERE (gi.`tipo` = 'Console' OR gi.`tipo` = 'Portátil') AND gi.`id_user` = ".$idUser;
            
             return $this->carregarDados($sql,false);         
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }       
    

    public function findItemByProgressos($idUser) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            gi.`titulo`,                             
                            gi.`progressao`, 
                            gi.`imagem`,
                            gi.`status`                            
                            FROM `tb_game_item` gi 
                            WHERE  gi.`id_user` = ".$idUser."
                            AND (gi.`tipo` = 'Jogo Digital' OR gi.`tipo` = 'Jogo Físico') 
                            ORDER BY gi.`data_update` DESC
                            LIMIT 0, 10";
            
            return $this->carregarDados($sql,false);         
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }
	
    public function getTotalValor($idUser) {
        try {
			
            $sql = "SELECT SUM(valor_pago) as total_pago, SUM(valor_atual) as total_atual FROM `tb_game_item` WHERE id_user = ".$idUser;
            
            return $this->carregarDados($sql,false);         
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }

    
    //USADO
    public function getTotalItens($filter = null) {
        try {

            $conexao = $this->ConectarBanco();
            $total = 0;
            $sql = "SELECT  COUNT(gi.`id`) AS totalItens FROM `tb_game_item` gi " . $filter;
            
            $query = mysqli_query($conexao, $sql) or die('Erro na execução do get Total!');
            while ($objItem = mysqli_fetch_object($query)) {
                $total = $objItem;
            }
            $this->FecharBanco($conexao);

            return $total;
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }
	
    //USADO
    public function carregarDados($sql, $isObject){
            $conexao = $this->ConectarBanco();
            $html = null;
            //die($sql);
            $query = mysqli_query($conexao, $sql) or die('Erro na execução da query!');
            if($isObject === true){
                $html = $this->montarRetornoObjetoJson($query);
            }else if($isObject === false){
                $html = $this->montarRetornoArrayJson($query);
            }else{
                $html = mysqli_insert_id($conexao);//$query;
            }
            $this->FecharBanco($conexao);        
            return $html;
    }

    //USADO
    public function montarRetornoArrayJson($query) {
        $array = array();       
        while ($objItem = mysqli_fetch_object($query)) {
            $array[] = $objItem;            
        }
        return json_encode($array);
    }
    
    //USADO
    public function montarRetornoObjetoJson($query) {
        $retorno = null;
        while ($objItem = mysqli_fetch_object($query)) {
            $retorno = $objItem;
        }
        return json_encode($retorno);
    }    

    public function montarRetornoObjeto($query) {
        $retorno = null;
        while ($objItem = mysqli_fetch_object($query)) {
            $retorno = $objItem;
        }
        return $retorno;
    }    




    public function findItemByMaiorTempo($idUser) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            gi.`titulo`,
                            gi.`imagem`               
                            FROM `tb_game_item` gi 
                            WHERE gi.`tempo` = (SELECT MAX(tempo) FROM tb_game_item WHERE id_user = ".$idUser.") 
                            AND (gi.`tipo` = 'Jogo Digital' OR gi.`tipo` = 'Jogo Físico') 
                            AND gi.`id_user` = ".$idUser." ORDER BY rand()";
            
            return $this->carregarDados($sql,true);         
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }

    public function findItemByMaisJogadas($idUser) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            gi.`titulo`,
                            gi.`imagem`               
                            FROM `tb_game_item` gi 
                            WHERE gi.`num_jogadas` = (SELECT MAX(`num_jogadas`) FROM tb_game_item WHERE `id_user` = ".$idUser."
                                AND (`tipo` = 'Jogo Digital' OR `tipo` = 'Jogo Físico') ) 
                                AND gi.`id_user` = ".$idUser."
                            ORDER BY rand()";


     
            //die($sql);
            return $this->carregarDados($sql,true);         
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }


    public function findItemByMaisRecente($idUser) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            gi.`titulo`,
                            gi.`imagem`               
                            FROM `tb_game_item` gi 
                            WHERE gi.`data_cadastro` = (SELECT MAX(data_cadastro) FROM tb_game_item WHERE id_user = ".$idUser.")                             
                            AND gi.`id_user` = ".$idUser." ORDER BY rand()";
            
            return $this->carregarDados($sql,true);         
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }  

    public function findItemByMaisCaro($idUser) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            gi.`titulo` ,
                            gi.`imagem`              
                            FROM `tb_game_item` gi 
                            WHERE gi.`valor_pago` = (SELECT MAX(valor_pago) FROM tb_game_item WHERE id_user = ".$idUser.") 
                            AND gi.`id_user` = ".$idUser." ORDER BY rand()";
            
            return $this->carregarDados($sql,true);         
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }                   


    public function findItemByAvaliado($idUser) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            gi.`titulo` ,
                            gi.`imagem`              
                            FROM `tb_game_item` gi 
                            WHERE gi.`avaliacao` = (SELECT MAX(avaliacao) FROM tb_game_item WHERE id_user = ".$idUser.") 
                            AND gi.`id_user` = ".$idUser."
                            AND (gi.`tipo` = 'Jogo Digital' OR gi.`tipo` = 'Jogo Físico') 
                            ORDER BY rand()";
            
            return $this->carregarDados($sql,true);         
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    } 


    public function findPortatilByAvaliado($idUser) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            gi.`titulo`,
                            gi.`imagem`               
                            FROM `tb_game_item` gi 
                            WHERE gi.`avaliacao` = (SELECT MAX(avaliacao) FROM tb_game_item WHERE id_user = ".$idUser." AND tipo = 'Portátil' ) 
                            AND gi.`id_user` = ".$idUser."
                            AND gi.`tipo` = 'Portátil' 
                            ORDER BY rand()";
            
            return $this->carregarDados($sql,true);         
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }


    public function findVideoGameByAvaliado($idUser) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            gi.`titulo` ,
                            gi.`imagem`              
                            FROM `tb_game_item` gi 
                            WHERE gi.`avaliacao` = (SELECT MAX(avaliacao) FROM tb_game_item WHERE id_user = ".$idUser." AND tipo = 'Console') 
                            AND gi.`id_user` = ".$idUser."
                            AND gi.`tipo` = 'Console'
                            ORDER BY rand()";
            
            return $this->carregarDados($sql,true);         
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }     


    public function findAdaptadorByAvaliado($idUser) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            gi.`titulo` ,
                            gi.`imagem`              
                            FROM `tb_game_item` gi 
                            WHERE gi.`avaliacao` = (SELECT MAX(avaliacao) FROM tb_game_item WHERE id_user = ".$idUser." AND tipo = 'Adaptador') 
                            AND gi.`id_user` = ".$idUser."
                            AND gi.`tipo` = 'Adaptador'
                            ORDER BY rand()";
            
            return $this->carregarDados($sql,true);         
        } catch (Exception $e) {
            $arr = array('message' => 'Erro durante a execução da Base de Dados!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }       


    public function findItemByCompletado($idUser) {
        try {           
            $sql = "SELECT  gi.`id`, 
                            gi.`titulo`,
                            gi.`imagem`               
                            FROM `tb_game_item` gi 
                            WHERE gi.`progressao` = (SELECT MAX(progressao) FROM tb_game_item WHERE id_user = ".$idUser.") 
                            AND gi.`id_user` = ".$idUser."
                            AND (gi.`tipo` = 'Jogo Digital' OR gi.`tipo` = 'Jogo Físico') 
                            ORDER BY rand()";
            
            return $this->carregarDados($sql,true);         
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
  

}

?>