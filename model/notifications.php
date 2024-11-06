<?php
class Notification {
    private $id;
    private $maKhachHang; 
    private $maDonHang; 
    private $message;
    private $status;
    private $createdAt; 

    // Constructor
    public function __construct($id, $maKhachHang, $maDonHang, $message, $status, $createdAt = null) {
        $this->id = $id;
        $this->maKhachHang = $maKhachHang;
        $this->maDonHang = $maDonHang;
        $this->message = $message;
        $this->status = $status;
        $this->createdAt = $createdAt ?? date('Y-m-d H:i:s');
    }


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }


    public function getMaKhachHang() {
        return $this->maKhachHang;
    }

    public function setMaKhachHang($maKhachHang) {
        $this->maKhachHang = $maKhachHang;
    }


    public function getMaDonHang() {
        return $this->maDonHang;
    }

    public function setMaDonHang($maDonHang) {
        $this->maDonHang = $maDonHang;
    }


    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

  
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

  
    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }
}
?>
