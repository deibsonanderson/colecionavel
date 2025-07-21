<?php

class Item {

    private $id;
    private $dataCadastro;
    private $titulo;
    private $descricao;
    private $imagem;
    private $procedencia;
    private $regiao;
    private $valorPago;
    private $valorAtual;
    private $plataforma;
    private $tipo;
    private $codigo;
    private $complemento;
    private $avaliacao;
    private $localPrimeiro;
    private $localSegundo;
    private $localTerceiro;
    private $flagCartuchoDisco;
    private $flagReplica;
    private $flagProtetor;
    private $flagCdDvdGdBd; 
    private $flagCaixa;
    private $flagManual; 
    private $flagBerco;
    private $flagPanfleto; 
    private $flagPoster;
    private $flagNotaFiscal; 
    private $flagLacrado; 
    private $flagLuva;
	private $flagRetrocompativel;
    private $idUser;
    private $status;
    private $progressao;
    private $possui;
    private $situacao;
    private $totalItens;
    private $genero;
    private $produtora;
    private $publicadora;
    private $numJogadas;
    private $tempo;
	private $quantidade;
    private $screenshot1;
    private $screenshot2;
    private $screenshot3;
    private $screenshot4;


    function getTempo() {
        return $this->tempo;
    }

    function setTempo($tempo) {
        $this->tempo = $tempo;
    }


    function getNumJogadas() {
        return $this->numJogadas;
    }

    function setNumJogadas($numJogadas) {
        $this->numJogadas = $numJogadas;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function getGenero() {
        return $this->genero;
    }

    function setGenero($genero) {
        $this->genero = $genero;
    }

    function getProdutora() {
        return $this->produtora;
    }

    function setProdutora($produtora) {
        $this->produtora = $produtora;
    }

    function getPublicadora() {
        return $this->publicadora;
    }

    function setPublicadora($publicadora) {
        $this->publicadora = $publicadora;
    }



    function getIdUser() {
        return $this->idUser;
    }

    function setIdUser($idUser) {
        $this->idUser = $idUser;
    }


    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }


    function getProgressao() {
        return $this->progressao;
    }

    function setProgressao($progressao) {
        $this->progressao = $progressao;
    }


    function getSituacao() {
        return $this->situacao;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function getPossui() {
        return $this->possui;
    }

    function setPossui($possui) {
        $this->possui = $possui;
    }

    function getTotalItens() {
        return $this->totalItens;
    }

    function setTotalItens($totalItens) {
        $this->totalItens = $totalItens;
    }
    	
    function getFlagCartuchoDisco() {
        return $this->flagCartuchoDisco;
    }

    function getFlagReplica() {
        return $this->flagReplica;
    }

    function getFlagProtetor() {
        return $this->flagProtetor;
    }

    function getFlagCdDvdGdBd() {
        return $this->flagCdDvdGdBd;
    }

    function getFlagCaixa() {
        return $this->flagCaixa;
    }

    function getFlagManual() {
        return $this->flagManual;
    }

    function getFlagBerco() {
        return $this->flagBerco;
    }

    function getFlagPanfleto() {
        return $this->flagPanfleto;
    }

    function getFlagPoster() {
        return $this->flagPoster;
    }

    function getFlagNotaFiscal() {
        return $this->flagNotaFiscal;
    }

    function getFlagLacrado() {
        return $this->flagLacrado;
    }

    function getFlagLuva() {
        return $this->flagLuva;
    }

    function setFlagCartuchoDisco($flagCartuchoDisco) {
        $this->flagCartuchoDisco = $flagCartuchoDisco;
    }

    function setFlagReplica($flagReplica) {
        $this->flagReplica = $flagReplica;
    }

    function setFlagProtetor($flagProtetor) {
        $this->flagProtetor = $flagProtetor;
    }

    function setFlagCdDvdGdBd($flagCdDvdGdBd) {
        $this->flagCdDvdGdBd = $flagCdDvdGdBd;
    }

    function setFlagCaixa($flagCaixa) {
        $this->flagCaixa = $flagCaixa;
    }

    function setFlagManual($flagManual) {
        $this->flagManual = $flagManual;
    }

    function setFlagBerco($flagBerco) {
        $this->flagBerco = $flagBerco;
    }

    function setFlagPanfleto($flagPanfleto) {
        $this->flagPanfleto = $flagPanfleto;
    }

    function setFlagPoster($flagPoster) {
        $this->flagPoster = $flagPoster;
    }

    function setFlagNotaFiscal($flagNotaFiscal) {
        $this->flagNotaFiscal = $flagNotaFiscal;
    }

    function setFlagLacrado($flagLacrado) {
        $this->flagLacrado = $flagLacrado;
    }

    function setFlagLuva($flagLuva) {
        $this->flagLuva = $flagLuva;
    }
	
	function setFlagRetrocompativel($flagRetrocompativel) {
        $this->flagRetrocompativel = $flagRetrocompativel;
    }
        
	function getFlagRetrocompativel() {
        return $this->flagRetrocompativel;
    }		
		
    public function getId() {
        return $this->id;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function getProcedencia() {
        return $this->procedencia;
    }

    public function getRegiao() {
        return $this->regiao;
    }


    public function getPlataforma() {
        return $this->plataforma;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function getAvaliacao() {
        return $this->avaliacao;
    }

    public function getLocalPrimeiro() {
        return $this->localPrimeiro;
    }

    public function getLocalSegundo() {
        return $this->localSegundo;
    }

    public function getLocalTerceiro() {
        return $this->localTerceiro;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function setProcedencia($procedencia) {
        $this->procedencia = $procedencia;
    }

    public function setRegiao($regiao) {
        $this->regiao = $regiao;
    }

    public function setPlataforma($plataforma) {
        $this->plataforma = $plataforma;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    public function setAvaliacao($avaliacao) {
        $this->avaliacao = $avaliacao;
    }

    public function setLocalPrimeiro($localPrimeiro) {
        $this->localPrimeiro = $localPrimeiro;
    }

    public function setLocalSegundo($localSegundo) {
        $this->localSegundo = $localSegundo;
    }

    public function setLocalTerceiro($localTerceiro) {
        $this->localTerceiro = $localTerceiro;
    }

    public function getValorPago() {
        return $this->valorPago;
    }

    public function getValorAtual() {
        return $this->valorAtual;
    }

    public function setValorPago($valorPago) {
        $this->valorPago = $valorPago;
    }

    public function setValorAtual($valorAtual) {
        $this->valorAtual = $valorAtual;
    }

    function getScreenshot1() {
        return $this->screenshot1;
    }

    function setScreenshot1($screenshot1) {
        $this->screenshot1 = $screenshot1;
    }


    function getScreenshot2() {
        return $this->screenshot2;
    }

    function setScreenshot2($screenshot2) {
        $this->screenshot2 = $screenshot2;
    }


    function getScreenshot3() {
        return $this->screenshot3;
    }

    function setScreenshot3($screenshot3) {
        $this->screenshot3 = $screenshot3;
    }


    function getScreenshot4() {
        return $this->screenshot4;
    }

    function setScreenshot4($screenshot4) {
        $this->screenshot4 = $screenshot4;
    }






}

?>