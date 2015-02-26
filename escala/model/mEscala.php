<?php

require_once '../Connections/conn_novo.php';
require_once 'core/Escala.php';

class mEscala extends Conecction {

    private $id = null;
    private $data = null;
    private $corretor = null;
    private $qtdBoi = 0;
    private $qtdVaca = 0;
    private $qtdNov = 0;
    private $qtdTouro = 0;
    private $pecuarista = null;
    private $duracao = null;
    private $lote = null;
    private $preEscala = 0;

    public function getPreEscala() {
        return $this->preEscala;
    }

    public function setPreEscala($preEscala) {
        $this->preEscala = $preEscala;
    }

    public function getLote() {
        if ($this->lote == "") {
            $this->setLote();
        }

        return $this->lote;
    }

    public function setLote($lote = "") {
        if ($lote == "") {

            $sql = sprintf("Select 
                        coalesce(max(a.`lote`)+1,1) as rs
                from
                        escala a
                where
                        a.`data` = '%s'", $this->getData());

            $rs = $this->RunSelect($sql);

            $this->lote = $rs[0]['rs'];
        } else {
            $this->lote = $lote;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
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

    public function setQtdBoi($qtdBoi = 0) {
        $this->qtdBoi = $qtdBoi;
    }

    public function getQtdVaca() {
        return $this->qtdVaca;
    }

    public function setQtdVaca($qtdVaca = 0) {
        $this->qtdVaca = $qtdVaca;
    }

    public function getQtdNov() {
        return $this->qtdNov;
    }

    public function setQtdNov($qtdNov = 0) {
        $this->qtdNov = $qtdNov;
    }

    public function getQtdTouro() {
        return $this->qtdTouro;
    }

    public function setQtdTouro($qtdTouro = 0) {
        $this->qtdTouro = $qtdTouro;
    }

    public function getPecuarista() {
        return $this->pecuarista;
    }

    public function setPecuarista($pequarista) {
        $this->pecuarista = $pequarista;
    }

    public function getDuracao() {
        $this->setDuracao();
        return $this->duracao;
    }

    public function setDuracao() {
        $total = ($this->getQtdBoi() + $this->getQtdNov() + $this->getQtdTouro() + $this->getQtdVaca());
        $res = ($total * 60) / 100;

        $this->duracao = round($res, 0);
    }
}
?>
