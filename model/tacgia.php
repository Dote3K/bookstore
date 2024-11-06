<?php
class tacgia{
    private $matacgia;
    private $tentacgia;
    private $ngaysinh;
    private $tieusu;
    public function __construct($matacgia,$tentacgia,$ngaysinh,$tieusu)
    {
        $this->matacgia= $matacgia;
        $this->tentacgia=$tentacgia;
        $this->ngaysinh=$ngaysinh;
        $this->tieusu=$tieusu;
    }
    function getmatacgia(){
        return $this->matacgia;
    }
    function setmatacgia($matacgia){
        $this->matacgia=$matacgia;
    }
    function gettentacgia(){
        return $this->tentacgia;
    }
    function settentacgia($tentacgia){
        $this->tentacgia=$tentacgia;
    }
    function getngaysinh(){
        return $this->ngaysinh;
    }
    function setngaysinh($ngaysinh){
        $this->ngaysinh=$ngaysinh;
    }
    function gettieusu(){
        return $this->tieusu;
    }
    function settieusu($tieusu){
        $this->tieusu=$tieusu;
    }
}
?>