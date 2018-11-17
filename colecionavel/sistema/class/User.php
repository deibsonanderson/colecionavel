<?php

class User {

	private $id;
	private $nome;
	private $email;
	private $senha;
	private $data_nascimento;
	private $telefone;
	private $site;
	private $descricao;
	private $foto;
    private $fundo;


    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getDataNascimento() {
        return $this->data_nascimento;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getSite() {
        return $this->site;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setDataNascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setSite($site) {
        $this->site = $site;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function getFundo() {
        return $this->fundo;
    }

    public function setFundo($fundo) {
        $this->fundo = $fundo;
    }


}


?>