<?php
class theloai{
    private $matheloai; 
    private $tentheloai;

    public function __construct($matheloai, $tentheloai)
    {
        $this->matheloai = $matheloai;
        $this->tentheloai = $tentheloai;
    }
    function getmatheloai(){
        return $this->matheloai;
    }
    function setmatheloai($matheloai){
        $this->matheloai=$matheloai;
    }

    function gettentheloai(){
        return $this->tentheloai;
    }
    function settentheloai($tentheloai){
        $this->tentheloai=$tentheloai;
    }
}
?>