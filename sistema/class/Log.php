<?php

class Log {

    private $id;
    private $data;
    private $descricao;
    private $idUser;
    private $idItem;
    private $icone;


    public function getId() {
        return $this->id;
    }

    public function getIcone() {
        return $this->icone;
    }    

    public function getData() {
        return $this->data;
    }


    public function getDescricao() {
        return $this->descricao;
    }


    public function getIdUser() {
        return $this->idUser;
    }            


    public function getIdItem() {
        return $this->idItem;
    }                

    public function setId($id) {
        $this->id = $id;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setIdUser($idUser) {
        $this->idUser = $idUser;
    }   

    public function setIcone($icone) {
        $this->icone = $icone;
    }                

    public function setIdItem($idItem) {
        $this->idItem = $idItem;
    }            


}

?>