<?php
class NhaXuatBan {
    private $maNxb;
    private $ten;
    private $diaChi;
    private $sdt;
    private $email;

    // Constructor
    public function __construct($maNxb, $ten, $diaChi = null, $sdt = null, $email = null) {
        $this->maNxb = $maNxb;
        $this->ten = $ten;
        $this->diaChi = $diaChi;
        $this->sdt = $sdt;
        $this->email = $email;
    }

    // Getter và Setter cho maNxb
    public function getMaNxb() {
        return $this->maNxb;
    }

    public function setMaNxb($maNxb) {
        $this->maNxb = $maNxb;
    }

    // Getter và Setter cho ten
    public function getTen() {
        return $this->ten;
    }

    public function setTen($ten) {
        $this->ten = $ten;
    }

    // Getter và Setter cho diaChi
    public function getDiaChi() {
        return $this->diaChi;
    }

    public function setDiaChi($diaChi) {
        $this->diaChi = $diaChi;
    }

    // Getter và Setter cho sdt
    public function getSdt() {
        return $this->sdt;
    }

    public function setSdt($sdt) {
        $this->sdt = $sdt;
    }

    // Getter và Setter cho email
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
}
?>
