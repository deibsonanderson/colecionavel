<?php
session_start();
$url = '../';
require $url . 'dao/ItemDao.php';
require $url . 'class/Item.php';
require $url . 'class/Log.php';


class ItemController {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    //USADO
    public function validarItem($item) {
        $retorno = true;
        if ($item->getTitulo() == '' ||
                //$item->getImagem() == '' ||
                $item->getRegiao() == '' ||
                $item->getPlataforma() == '' ||
                $item->getTipo() == '' ||
                $item->getAvaliacao() == '') {
            $retorno = false;
        }
        return $retorno;
    }


    public function findItemByVideoGame() {
        $itemDao = new ItemDao();
        return $itemDao->findItemByVideoGame($_SESSION['userItem']->id);
    }    

    public function findItemByProgressos() {
        $itemDao = new ItemDao();
        return $itemDao->findItemByProgressos($_SESSION['userItem']->id);
    }


    public function findItemByMaiorTempo() {
            $itemDao = new ItemDao();
        return $itemDao->findItemByMaiorTempo($_SESSION['userItem']->id);
    }    

    public function findItemByMaisJogadas() {
            $itemDao = new ItemDao();
        return $itemDao->findItemByMaisJogadas($_SESSION['userItem']->id);
    }    

    public function findItemByMaisRecente() {
            $itemDao = new ItemDao();
        return $itemDao->findItemByMaisRecente($_SESSION['userItem']->id);
    }    

    public function findItemByMaisCaro() {
            $itemDao = new ItemDao();
        return $itemDao->findItemByMaisCaro($_SESSION['userItem']->id);
    }    

    public function findItemByAvaliado() {
            $itemDao = new ItemDao();
        return $itemDao->findItemByAvaliado($_SESSION['userItem']->id);
    }    

    public function findPortatilByAvaliado() {
            $itemDao = new ItemDao();
        return $itemDao->findPortatilByAvaliado($_SESSION['userItem']->id);
    }    

    public function findVideoGameByAvaliado() {
            $itemDao = new ItemDao();
        return $itemDao->findVideoGameByAvaliado($_SESSION['userItem']->id);
    } 

    public function findAdaptadorByAvaliado() {
            $itemDao = new ItemDao();
        return $itemDao->findAdaptadorByAvaliado($_SESSION['userItem']->id);
    }       

    public function findItemByCompletado() {
            $itemDao = new ItemDao();
        return $itemDao->findItemByCompletado($_SESSION['userItem']->id);
    }    

    public function getTotalValor() {
            $itemDao = new ItemDao();
        return $itemDao->getTotalValor($_SESSION['userItem']->id);
    }  

    //USADO
    public function addItem($data) {
        $itemDao = new ItemDao();

        $item = new Item();
        $item->setTitulo($data->titulo);
        $item->setDataCadastro($data->data_cadastro);
        $item->setDescricao($data->descricao);

        if ($data->imagem != '') {
            if ($this->validarImagem($data->imagem)) {
                $item->setImagem($this->setImagemFile($data->imagem));
            }
        }

        $item->setProcedencia($data->procedencia);
        $item->setRegiao($data->regiao);
        $item->setValorPago($data->valor_pago);
        $item->setValorAtual($data->valor_atual);
        $item->setPlataforma($data->plataforma);
        $item->setTipo($data->tipo);
        $item->setCodigo($data->codigo);
        $item->setComplemento($data->complemento);
        $item->setAvaliacao($data->avaliacao);
        $item->setLocalPrimeiro($data->local_primeiro);
        $item->setLocalSegundo($data->local_segundo);
        $item->setLocalTerceiro($data->local_terceiro);
        $item->setFlagCartuchoDisco($data->flag_cartucho_disco);
        $item->setFlagReplica($data->flag_replica);
        $item->setFlagProtetor($data->flag_protetor);
        $item->setFlagCdDvdGdBd($data->flag_cd_dvd);
        $item->setFlagCaixa($data->flag_caixa);
        $item->setFlagManual($data->flag_manual);
        $item->setFlagBerco($data->flag_berco);
        $item->setFlagPanfleto($data->flag_panfleto);
        $item->setFlagPoster($data->flag_poster);
        $item->setFlagNotaFiscal($data->flag_nota_fiscal);
        $item->setFlagLacrado($data->flag_lacrado);
        $item->setFlagLuva($data->flag_luva);
		$item->setFlagRetrocompativel($data->flag_retrocompativel);
        $item->setTempo($data->tempo);
        $item->setNumJogadas($data->num_jogadas);
        $item->setStatus($data->status);
        $item->setProgressao($data->progressao);
        $item->setPossui($data->possui);
        $item->setSituacao($data->situacao);
        $item->setGenero($data->genero);
        $item->setProdutora($data->produtora);
        $item->setPublicadora($data->publicadora);
		$item->setQuantidade($data->quantidade);
        $item->setScreenshot1($this->checarImagemUpdate($data->screenshot1,null,1));
        $item->setScreenshot2($this->checarImagemUpdate($data->screenshot2,null,2));
        $item->setScreenshot3($this->checarImagemUpdate($data->screenshot3,null,3));
        $item->setScreenshot4($this->checarImagemUpdate($data->screenshot4,null,4));            

        $item->setIdUser($_SESSION['userItem']->id);

        if ($this->validarItem($item)) {            
            $item->setId($itemDao->addItem($item));

            $log = new Log();
            $log->setDescricao('Cadastro um novo '.$item->getTipo().' de nome XXX');
            $log->setIdUser($item->getIdUser());
            $log->setIdItem($item->getId());
            $log->setIcone('fa-plus');

            $itemDao->addLog($log);

            http_response_code();

            $arr = array('id'=> $item->getId(), 'message' => 'Item cadastrado com sucesso!');
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
        } else {
            $arr = array('message' => 'Campos Obrigatorios devem ser preenchidos!'); //etc
            header('HTTP/1.1 400 Bad Request');
            echo json_encode($arr);
            http_response_code(400);
        }
    }

    public function checarImagemUpdate($imagem,$idUser,$posicao){
        $saida = '';
        if ($imagem != '') {
            if ($this->validarImagem($imagem)) {                
                if($idUser !== null){
                    $this->deleteImagem($idUser,$posicao);
                }
                $saida = $this->setImagemFile($imagem);
            } else {
                $img = str_replace('./sistema/uploads/', '', $imagem);
                $img = str_replace('./assets/img/', '', $img);
                $img = str_replace('/', '', $img);
                $saida = str_replace('./sistema/uploads/', '', $img);
            }
        }
        return $saida;        
    }


    //USADO
    public function updateItem($data) {
        $itemDao = new ItemDao();

        $item = new Item();
        $item->setId($data->id);
        $item->setTitulo($data->titulo);
        $item->setDataCadastro($data->data_cadastro);
        $item->setDescricao($data->descricao);

        if ($data->imagem != '') {
            if ($this->validarImagem($data->imagem)) {                
                $this->deleteImagem($item->getId(),0);
                $item->setImagem($this->setImagemFile($data->imagem));
            } else {
                $img = str_replace('./sistema/uploads/', '', $data->imagem);
                $img = str_replace('./assets/img/', '', $img);
                $img = str_replace('/', '', $img);
                $item->setImagem(str_replace('./sistema/uploads/', '', $img));
            }
        }        

        $item->setProcedencia($data->procedencia);
        $item->setRegiao($data->regiao);
        $item->setValorPago($data->valor_pago);
        $item->setValorAtual($data->valor_atual);
        $item->setPlataforma($data->plataforma);
        $item->setTipo($data->tipo);
        $item->setCodigo($data->codigo);
        $item->setComplemento($data->complemento);
        $item->setAvaliacao($data->avaliacao);
        $item->setLocalPrimeiro($data->local_primeiro);
        $item->setLocalSegundo($data->local_segundo);
        $item->setLocalTerceiro($data->local_terceiro);
        $item->setFlagCartuchoDisco($data->flag_cartucho_disco);
        $item->setFlagReplica($data->flag_replica);
        $item->setFlagProtetor($data->flag_protetor);
        $item->setFlagCdDvdGdBd($data->flag_cd_dvd);
        $item->setFlagCaixa($data->flag_caixa);
        $item->setFlagManual($data->flag_manual);
        $item->setFlagBerco($data->flag_berco);
        $item->setFlagPanfleto($data->flag_panfleto);
        $item->setFlagPoster($data->flag_poster);
        $item->setFlagNotaFiscal($data->flag_nota_fiscal);
        $item->setFlagLacrado($data->flag_lacrado);
        $item->setFlagLuva($data->flag_luva);
		$item->setFlagRetrocompativel($data->flag_retrocompativel);
        $item->setTempo($data->tempo);
        $item->setNumJogadas($data->num_jogadas);
        $item->setStatus($data->status);
        $item->setProgressao($data->progressao);
        $item->setPossui($data->possui);
        $item->setSituacao($data->situacao);
        $item->setGenero($data->genero);
        $item->setProdutora($data->produtora);
        $item->setPublicadora($data->publicadora);  
        $item->setIdUser($_SESSION['userItem']->id);
		$item->setQuantidade($data->quantidade);
        $item->setScreenshot1($this->checarImagemUpdate($data->screenshot1,$item->getId(),1));
        $item->setScreenshot2($this->checarImagemUpdate($data->screenshot2,$item->getId(),2));
        $item->setScreenshot3($this->checarImagemUpdate($data->screenshot3,$item->getId(),3));
        $item->setScreenshot4($this->checarImagemUpdate($data->screenshot4,$item->getId(),4));

        if($this->validarItem($item)){
            $itemDao->updateItem($item);
            http_response_code();
            $arr = array('id' => $item->getId(), 'message' => 'Item atualizado com sucesso!'); 
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);      
        }else{
            $arr = array('id' => $item->getId(), 'message' => 'Campos Obrigatorios devem ser preenchidos!'); //etc
            header('HTTP/1.1 400 Bad Request');
            echo json_encode($arr);
            http_response_code(400);
        }
    }    

    //USADO
    public function findAllItem($request) {
        $itemDao = new ItemDao();
        $filter = ' WHERE gi.id_user = '.$_SESSION['userItem']->id;
        $filter .= " ORDER BY gi.titulo ASC ";        
        
        return $itemDao->findItemByFilter($filter);
    }

    //USADO
    public function pagination($request){
        $pagina = 0;
        $totalPagina = 5;
        if($request !== null && $request["skip"] !== null && $request["skip"] !== '' && $request["take"] !== null && $request["take"] !== ''){
            $pagina = $request["skip"];
            $totalPagina = $request["take"];
        }
        return ' LIMIT ' . $pagina . ' , ' . $totalPagina;
    }

    //USADO
    public function findItemByFilter($request) {
        $itemDao = new ItemDao();
        $filter = ' WHERE gi.id_user = '.$_SESSION['userItem']->id;
        $filter .= ($request["procedencia"] != null || $request["procedencia"] != '') ? " AND gi.procedencia = '" . $request["procedencia"] . "'" : "";
        $filter .= ($request["regiao"] != null || $request["regiao"] != '') ? " AND gi.regiao = '" . $request["regiao"] . "'" : "";
        $filter .= ($request["status"] != null || $request["status"] != '') ? " AND gi.status = '" . $request["status"] . "'" : "";
        $filter .= ($request["publicadora"] != null || $request["publicadora"] != '') ? " AND gi.publicadora LIKE '%" . $this->catacterRemove($request["publicadora"]) . "%'" : "";
        $filter .= ($request["produtora"] != null || $request["produtora"] != '') ? " AND gi.produtora LIKE '%" . $this->catacterRemove($request["produtora"]) . "%'" : "";
        $filter .= ($request["possui"] != null || $request["possui"] != '') ? " AND gi.possui = '" . $request["possui"] . "'" : "";
        $filter .= ($request["situacao"] != null || $request["situacao"] != '') ? " AND gi.situacao LIKE '%" . $request["situacao"] . "%'" : "";
        
		$filter .= $this->mountArrayByFilter($request["plataforma"],'gi.plataforma');
		$filter .= $this->mountArrayByFilter($request["genero"],'gi.genero');
		$filter .= $this->mountArrayByFilter($request["tipo"],'gi.tipo');
		$filter .= $this->mountComplementFilter($request["complemento"]);
		
        if($request["titulo"] != null || $request["titulo"] != ''){
          $sqlFilter = " AND ( gi.titulo LIKE '%" . $this->catacterRemove($request["titulo"]) . "%' ";  
          $sqlFilter .= " OR gi.genero LIKE '%" . $this->catacterRemove($request["titulo"]) . "%' ";  
          $sqlFilter .= " OR gi.descricao LIKE '%" . $this->catacterRemove($request["titulo"]) . "%' ";  
          $sqlFilter .= " OR gi.procedencia LIKE '%" . $this->catacterRemove($request["titulo"]) . "%' ";
          $sqlFilter .= " OR gi.regiao LIKE '%" . $this->catacterRemove($request["titulo"]) . "%' ";
          $sqlFilter .= " OR gi.plataforma LIKE '%" . $this->catacterRemove($request["titulo"]) . "%' ";
          $sqlFilter .= " OR gi.tipo LIKE '%" . $this->catacterRemove($request["titulo"]) . "%' ";
          $sqlFilter .= " OR gi.situacao LIKE '%" . $this->catacterRemove($request["titulo"]) . "%' ";
          $sqlFilter .= " OR gi.publicadora LIKE '%" . $this->catacterRemove($request["titulo"]) . "%' ) "; 
          $filter .= $sqlFilter;  
        }                

        header('X-Total-Registros: '.$itemDao->getTotalItens($filter)->totalItens);
        $filter .= ($request["ordem"] != null || $request["ordem"] != '') ? " ORDER BY gi." . $request["ordem"] . " ASC " : " ORDER BY RAND() ";
        
        $filter .= $this->pagination($request);

        return $itemDao->findItemByFilter($filter);
    }
	
	public function mountArrayByFilter($array, $field){
		$filter = '';
		if($array != null && count($array) > 0){
			foreach ($array as $objeto) {
				$sqlFilter .= "'".$objeto."',";
			}
			$filter .= ' AND '.$field.' IN (' .substr($sqlFilter,0,-1).') ';
		}
		return $filter;
	}
	
	public function mountComplementFilter($array){
		$filter = '';
		if($array != null && count($array) > 0){
			foreach ($array as $objeto) {
				$converted = json_decode($objeto);
				if($converted[1][1] != ''){
					$filter .= " AND gi.".$converted[1][0]." = '".$converted[1][1]."'";
				}
			}			
		}		
		return $filter;
	}

    //USADO
    public function findItemById($id,$isJson) {
        $itemDao = new ItemDao();
        if ($id == '') {
            return 'erro';
        } else {
            $filter = ' WHERE gi.id_user = '.$_SESSION['userItem']->id;
            $filter .= " AND gi.id = " . $id . "";
        }
        return $itemDao->findItemById($filter,$isJson);
    }


    //USADO
    public function getTotalItens($filter) {
        $itemDao = new ItemDao();
        return $itemDao->getTotalItens($filter);
    }

    //USADO
    public function findItemByCountGames() {
        $itemDao = new ItemDao();
        $objeto = new stdClass(); 
        $filter = ' WHERE gi.id_user = '.$_SESSION['userItem']->id;    
        $objeto->concluido = $itemDao->getTotalItens($filter." AND (gi.`tipo` = 'Jogo Digital' OR gi.`tipo` = 'Jogo Físico') AND gi.status = 'C' AND gi.id_user = ".$_SESSION['userItem']->id)->totalItens;
        $objeto->pendente = $itemDao->getTotalItens($filter." AND (gi.`tipo` = 'Jogo Digital' OR gi.`tipo` = 'Jogo Físico') AND gi.status = 'P' AND gi.id_user = ".$_SESSION['userItem']->id)->totalItens;
        $objeto->andamento = $itemDao->getTotalItens($filter." AND (gi.`tipo` = 'Jogo Digital' OR gi.`tipo` = 'Jogo Físico') AND gi.status = 'E' AND gi.id_user = ".$_SESSION['userItem']->id)->totalItens;
		$objeto->abandonado = $itemDao->getTotalItens($filter." AND (gi.`tipo` = 'Jogo Digital' OR gi.`tipo` = 'Jogo Físico') AND gi.status = 'A' AND gi.id_user = ".$_SESSION['userItem']->id)->totalItens;
		$objeto->pausado = $itemDao->getTotalItens($filter." AND (gi.`tipo` = 'Jogo Digital' OR gi.`tipo` = 'Jogo Físico') AND gi.status = 'W' AND gi.id_user = ".$_SESSION['userItem']->id)->totalItens;
        return json_encode($objeto);
    }    

    
    //USADO
    public function deleteItem($data) {
        $itemDao = new ItemDao();
        $item = new Item();
        $item->setId($data);
        if($item->getId() == '' || $item->getId() == null){
            $arr = array('id' => $item->getId(), 'message' => 'Campo obrigatorio não foi passado!'); //etc
            header('HTTP/1.1 400 Bad Request');
            echo json_encode($arr);
            http_response_code(400);
        }else{
            $this->deleteImagemAll($item->getId());
            $itemDao->deleteItem($item);            
            http_response_code();
            $arr = array('id' => $item->getId(), 'message' => 'Item removido com sucesso!');
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            
        }

    }

    //USADO
    function validarLogin(){
        if(isset($_SESSION['userItem']) && $_SESSION['userItem']->id !== null){
            return true;
        }else{
            return false;
        }
    }   

	public function tamanhoImagem($imagem, $largura) {
		$tam_img = getimagesize($imagem);
		if ($tam_img[0] > $largura) {
			return false;
		} else {
			return true;
		}
	}

	public function redimensionaImg($path, $imagem, $largura) {
		$arquivo_origem = $path . '/' . $imagem;
		$arquivo_destino = $arquivo_origem;
		$nome_arquivo_destino = $imagem;
		$ext = exif_imagetype($arquivo_origem);
		
		if ($ext === 2) {
			$img_origem = imagecreatefromjpeg($arquivo_origem);
		}
		if ($ext === 1) {
			$img_origem = imagecreatefromgif($arquivo_origem);
		}
		if ($ext === 3) {
			$img_origem = imagecreatefrompng($arquivo_origem);
		}

		if (imagesx($img_origem) > $largura) {
			$nova_largura = $largura;
			$nova_altura = $nova_largura * imagesy($img_origem) / imagesx($img_origem);
			$img_destino = imagecreatetruecolor($nova_largura, $nova_altura);
			imagecopyresampled($img_destino, $img_origem, 0, 0, 0, 0, $nova_largura, $nova_altura, imagesx($img_origem), imagesy($img_origem));

			if ($ext === 2) {
				imageJPEG($img_destino, $arquivo_destino, 85);
			}
			if ($ext === 1) {
				imageGIF($img_destino, $arquivo_destino);
			}
			if ($ext === 3) {
				imagePNG($img_destino, $arquivo_destino);
			}
		}

		return $nome_arquivo_destino;
	}
	

    //Old
    public function setImagemFile($imagem) {
		$path = "../uploads/";
        if (strstr($imagem, 'data:image/jpeg;base64,') || strstr($imagem, 'data:image/jpg;base64,')) {
            $base64 = str_replace('data:image/jpeg;base64,', '', $imagem);
            $filename_path = md5(time() . uniqid()) . ".jpg";
        } else if (strstr($imagem, 'data:image/png;base64,')) {
            $base64 = str_replace('data:image/png;base64,', '', $imagem);
            $filename_path = md5(time() . uniqid()) . ".png";
        }
        $decoded = base64_decode($base64);
        file_put_contents("../uploads/" . $filename_path, $decoded);
		if (!$this->tamanhoImagem($path.$filename_path, 640)) {
			$this->redimensionaImg($path, $filename_path, 640);
		}		
        return $filename_path;
    }


    //Old
    public function validarImagem($imagem) {
        $retorno = true;
        if (strripos($imagem, 'data:image') === false) {
            $retorno = false;
        }
        return $retorno;
    }

    //Old
    public function deleteImagem($id,$posicao) {
        $item = $this->findItemById($id,true);
        $arquivoExclusao = '';
        switch ($posicao) {
            case 0:
                $arquivoExclusao = $item->imagem;                 
            break;
            case 1:
                $arquivoExclusao = $item->screenshot1;                
            break;
            case 2:
                $arquivoExclusao = $item->screenshot2;               
            break;
            case 3:
                $arquivoExclusao = $item->screenshot3;                
            break;
            case 4:            
                $arquivoExclusao = $item->screenshot4;                
            break;           
        }
        if (!empty($arquivoExclusao) && $arquivoExclusao !== 'default.jpg') {
            if (file_exists("../uploads/" . $arquivoExclusao)) {
                unlink("../uploads/" . $arquivoExclusao);
            }
        }
    }


    public function deleteImagemAll($id) {
        $item = $this->findItemById($id,true);
        $array = array();
        $array[] = $item->imagem;                 
        $array[] = $item->screenshot1;                
        $array[] = $item->screenshot2;               
        $array[] = $item->screenshot3;                
        $array[] = $item->screenshot4;                

        foreach ($array as $arquivoExclusao) {
            if (!empty($arquivoExclusao) && $arquivoExclusao !== 'default.jpg') {
                if (file_exists("../uploads/" . $arquivoExclusao)) {
                    unlink("../uploads/" . $arquivoExclusao);
                }
            }   
        }
        
    }
	
	public function findAllItemNewItem($id) {
        $itemDao = new ItemDao();
		$filter = ' WHERE gi.id_user = '.$_SESSION['userItem']->id;
        if($id != '' && $id != null){
			$filter .= ' AND gi.id = '.$id;
		}
		$filter .= " ORDER BY gi.titulo ASC ";
		$itens = json_decode($itemDao->findItemByFilter($filter));
        $array = array();
		foreach(json_decode($itemDao->findItemByFilter($filter)) as $data){
			$item = new stdClass();
			$item->number = (integer)$data->id;
			$item->title = $data->titulo;
			$item->createDate = $data->data_cadastro;
			$item->description = $data->descricao;
			$item->image = $data->imagem;
			$item->provenance = $data->procedencia;
			$item->region = $data->regiao;
			$item->pricePaid = (double)$data->valor_pago;
			$item->currentPrice = (double)$data->valor_atual;
			$item->platform = $data->plataforma;
			$item->type = $data->tipo;
			$item->code = $data->codigo;
			$item->complement = (integer) $data->complemento;
			$item->evaluation = (integer) $data->avaliacao;			
			$item->localStorage = array($data->local_primeiro,$data->local_segundo,$data->local_terceiro);
			
			$item->flagDiscCartridge = (boolean) $this->booleanConverter($data->flag_cartucho_disco);
			$item->flagReplica = (boolean) $this->booleanConverter($data->flag_replica);
			$item->flagProtector = (boolean) $this->booleanConverter($data->flag_protetor);
			$item->flagCdDvdGdBd = (boolean) $this->booleanConverter($data->flag_cd_dvd);
			$item->flagBox = (boolean) $this->booleanConverter($data->flag_caixa);
			$item->flagManual = (boolean) $this->booleanConverter($data->flag_manual);
			$item->flagCrib = (boolean) $this->booleanConverter($data->flag_berco);
			$item->flagPaintpamphlet = (boolean) $this->booleanConverter($data->flag_panfleto);
			$item->flagPoster = (boolean) $this->booleanConverter($data->flag_poster);
			$item->flagInvoice = (boolean) $this->booleanConverter($data->flag_nota_fiscal);
			$item->flagSealed = (boolean) $this->booleanConverter($data->flag_lacrado);
			$item->flagGlover = (boolean) $this->booleanConverter($data->flag_luva);
			$item->flagRetrocompativel = (boolean) $this->booleanConverter($data->flag_retrocompativel);
			$item->quantidade = (integer) $data->quantidade;
			$item->timeOfPlays = (integer) $data->tempo;
			$item->numberOfPlays = (integer) $data->num_jogadas;
			$item->status = $data->status;
			$item->progression = (integer) $data->progressao;
			$item->isHaveGame = (boolean) $this->booleanConverter($data->possui);
			$item->situation = $data->situacao;
			$item->genre = $data->genero;
			$item->producer = $data->produtora;
			$item->publisher = $data->publicadora;
			$item->active = (boolean) true; 
			$item->screenshots = array($data->screenshot1,$data->screenshot2,$data->screenshot3,$data->screenshot4);
			$array[] = $item;
		}
        return json_encode($array);
    }
	
	public function booleanConverter($value){
		if($value == "0"){
			return false;
		}else{
			return true;
		}
	}

    public function catacterRemove($string){
        /* matriz de entrada
        $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','Ã','Â','É','Ê','Í','Ó','Ô','Õ','Ú','Ü','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
        // matriz de saída
        $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','A','E','E','I','O','O','O','U','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
        return str_replace($what, $by, $string);*/
        return $string;
    }

}

?>
