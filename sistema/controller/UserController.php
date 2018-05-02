<?php

session_start();
$url = '../';
require $url . 'dao/UserDao.php';
require $url . 'class/Log.php';
require $url . 'class/User.php';

class UserController {

    public function login($request) {
        $user = new User();
        $user->setEmail($request->username);
        $user->setSenha($request->password);
        $retorno = null;
        $objeto = null;
        if ($this->validarCampoUser($user->getEmail(),$user->getSenha())) {
            if($user->getEmail() === 'convidado' && $user->getSenha() === 'convidado'){
                $convidado = new stdClass();
                $convidado->id = 1;
                $convidado->nome = 'Convidado' ;
                $convidado->email =  'convidado@email.com';
                $convidado->site =  'http://dicaseprogramacao.com.br';
                $convidado->senha =  'convidado';

                $retorno = array(0 => 'correct' ,1 => $convidado);
                $_SESSION['userItem'] = $convidado;                
            }else{
                $objeto = $this->findUserByFilter($user->getEmail(), $user->getSenha());
                if($objeto->email == $user->getEmail() && $objeto->senha == $user->getSenha()){
                    $retorno = array(0 => 'correct' ,1 => $objeto);
                    $_SESSION['userItem'] = $objeto;                
                }else{
                    $retorno = array(0 => 'wrong' );
                }
            }
        } else {
            $retorno = array(0 => 'wrong' );
        }

        return json_encode($retorno);
    }
    
    
    public function findUserByFilter($email, $senha) {
        $userDao = new UserDao();
        $filter = ($email != null || $email != '') ? " us.email = '" . $email . "'" : "";
        $filter .= ($senha != null || $senha != '') ? " AND us.senha = '" . $senha . "'" : "";

        return $userDao->findUserByFilter($filter);
    }


    public function findUserById() {
        if(isset($_SESSION['userItem']) && $_SESSION['userItem']->id !== null){
            $userDao = new UserDao();
            return $userDao->findUserById($_SESSION['userItem']->id);
        }else{
            $arr = array('message' => 'Usuário inexistente!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(401);
        }
    }    

    public function validarCampoUser($email, $password) {
        $retorno = true;
        if ($email == '' || $password == '') {
            $retorno = false;
        }
        return $retorno;
    }



    public function findAllLog(){
        if(isset($_SESSION['userItem']) && $_SESSION['userItem']->id !== null){
            $userDao = new UserDao();
            return $userDao->findAllLog($_SESSION['userItem']->id);
        }else{
            $arr = array('message' => 'Usuário inexistente!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(401);
        }
    }


    public function addLog($data) {
        if(isset($_SESSION['userItem']) && $_SESSION['userItem']->id !== null){
            $userDao = new userDao();

            $log = new Log();
            $log->setDescricao($data->descricao);
            $log->setIdUser($_SESSION['userItem']->id);   
            $log->setIdItem($data->id_item);       
            $log->setIcone($data->icone);
            
            $userDao->addLog($log);
            http_response_code();
            $arr = array('message' => 'Log cadastrado com sucesso!');
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
        }else{
            $arr = array('message' => 'Usuário inexistente!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(401);
        }
    }

    public function validarUser($user) {
        $retorno = true;
        if ($user->getNome() == '') {
            $retorno = false;
        }
        return $retorno;
    }

    //USADO
    public function updateUser($data) {
        $userDao = new UserDao();

        $user = new User();
        $user->setId($data->id);
        $user->setNome($data->nome);
        $user->setDescricao($data->descricao);

        
        if($data->data_nascimento !== null || $data->data_nascimento !== ''){
            $seconds = $data->data_nascimento / 1000;
            $user->setDataNascimento(date("Y-m-d H:i:s", $seconds));    
        }

        if ($data->foto != '') {
            if ($this->validarImagem($data->foto)) {                
                $this->deleteImagem($user->getId(),1);
                $user->setFoto($this->setImagemFile($data->foto));
            } else {
                $img = str_replace('./sistema/uploads/', '', $data->foto);
                $img = str_replace('./assets/img/', '', $img);
                $img = str_replace('/', '', $img);
                $user->setFoto(str_replace('./sistema/uploads/', '', $img));
            }
        }    

        if ($data->fundo != '') {
            if ($this->validarImagem($data->fundo)) {                
                $this->deleteImagem($user->getId(),2);
                $user->setFundo($this->setImagemFile($data->fundo));
            } else {
                $img = str_replace('./sistema/uploads/', '', $data->fundo);
                $img = str_replace('./assets/img/', '', $img);
                $img = str_replace('/', '', $img);
                $user->setFundo(str_replace('./sistema/uploads/', '', $img));
            }
        }                
        $user->setEmail($data->email);
        $user->setTelefone($data->telefone);
        $user->setSite($data->site);
        
        if($this->validarUser($user) && isset($_SESSION['userItem']) && $_SESSION['userItem']->id !== null && $_SESSION['userItem']->id != 1){
            $userDao->updateUser($user);
            http_response_code();
            $arr = array('id' => $user->getId(), 'message' => 'Dados do usuário atualizado com sucesso!'); 
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);      
        }else{
            $arr = array('id' => $user->getId(), 'message' => 'Campos Obrigatorios devem ser preenchidos!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
        }
    }


    public function updateSenha($data) {
        $userDao = new UserDao();
        $valido = false;
        $user = new User();
        $user->setId($data->id);
        $user->setSenha($data->senha_nova);

        if($data->senha_nova !== '' && 
            $data->senha_nova !== null &&
            $data->senha_confirm !== '' && 
            $data->senha_confirm !== null){

            if($data->senha_nova === $data->senha_confirm){
                $userDao->updateSenha($user);
                http_response_code();
                $arr = array('id' => $user->getId(), 'message' => 'Senha atualizada com sucesso!'); 
                header('HTTP/1.1 201 Created');
                echo json_encode($arr);     
            }else{
                $arr = array('id' => $user->getId(), 'message' => 'Senhas divergentes!'); //etc
                header('HTTP/1.1 201 Created');
                echo json_encode($arr);
                http_response_code(500);                
            }
        }else{
            $arr = array('id' => $user->getId(), 'message' => 'Campos Obrigatorios devem ser preenchidos!'); //etc
            header('HTTP/1.1 201 Created');
            echo json_encode($arr);
            http_response_code(500);
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
        file_put_contents($path . $filename_path, $decoded);
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
        $item = $this->findUserById($id,true);
        switch ($posicao) {
            case 1:
                $arquivoExclusao = $item->foto;
                break;
            case 2:
                $arquivoExclusao = $item->fundo;
                break;            
        }       

        if (!empty($arquivoExclusao)) {
            if (file_exists("../uploads/" . $arquivoExclusao)) {
                unlink("../uploads/" . $arquivoExclusao);
            }
        }
    }              

}
