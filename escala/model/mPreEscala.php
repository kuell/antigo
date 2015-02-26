<?php

require_once '../Connections/conn_novo.php';

class mPreEscala extends Conecction{

    private $id = null;
    private $data = null;
    private $corretor = null;
    private $pequarista = null;
    private $qtdBoi = 0;
    private $qtdVaca = 0;
    private $qtdNov = 0;
    private $qtdTouro = 0;
    private $situacao = null;

    public function getSituacao() {
        return $this->situacao;
    }

    public function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getIdCorretor() {
        return $this->idCorretor;
    }

    public function setIdCorretor($idCorretor) {
        $this->idCorretor = $idCorretor;
    }

    public function getPequarista() {
        return $this->pequarista;
    }

    public function setPequarista($pequarista) {
        $this->pequarista = $pequarista;
    }

    public function getCorretor() {
        return $this->corretor;
    }

    public function setCorretor($corretor) {
        $this->corretor = $corretor;
    }

    public function getQtdBoi() {
        return $this->qtdBoi;
    }

    public function setQtdBoi($qtdBoi) {
        $this->qtdBoi = $qtdBoi;
    }

    public function getQtdVaca() {
        return $this->qtdVaca;
    }

    public function setQtdVaca($qtdVaca) {
        $this->qtdVaca = $qtdVaca;
    }

    public function getQtdNov() {
        return $this->qtdNov;
    }

    public function setQtdNov($qtdNov) {
        $this->qtdNov = $qtdNov;
    }

    public function getQtdTouro() {
        return $this->qtdTouro;
    }

    public function setQtdTouro($qtdTouro) {
        $this->qtdTouro = $qtdTouro;
    }

}

?>
