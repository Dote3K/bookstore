<?php
class doanhthuDAO{
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }
    public function getDoanhThuNgay($date){

        $sql = "
        SELECT 
    DATE(dh.ngay_dat_hang) AS ngay_dat_hang,
    SUM(dh.tong) as doanh_thu,
    SUM(dh.tong - (s.gia_mua * ctdh.so_luong)) AS loi_nhuan,
    SUM(ctdh.so_luong) AS so_luong,
    COUNT(DISTINCT ctdh.ma_don_hang) AS so_don
FROM 
    donhang dh
JOIN 
    chitietdonhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang
JOIN 
    sach s ON ctdh.ma_sach = s.ma_sach
WHERE
    dh.trang_thai = 'DA_GIAO'
    AND DATE(dh.ngay_dat_hang) = ?
GROUP BY
    DATE(dh.ngay_dat_hang);";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        return $stmt->get_result();

    }
    public function getChiTietDoanhThuThang($month, $year){
        $sql = "
        SELECT 
    DATE(dh.ngay_dat_hang) AS ngay_dat_hang,
    SUM(dh.tong) as doanh_thu,
    SUM(dh.tong - (s.gia_mua * ctdh.so_luong)) AS loi_nhuan,
    SUM(ctdh.so_luong) AS so_luong,
    COUNT(DISTINCT ctdh.ma_don_hang) AS so_don
FROM 
    donhang dh
JOIN 
    chitietdonhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang
JOIN 
    sach s ON ctdh.ma_sach = s.ma_sach
WHERE
    dh.trang_thai = 'DA_GIAO'
    AND MONTH(dh.ngay_dat_hang) = ?
    AND YEAR(dh.ngay_dat_hang) = ?
GROUP BY
    DATE(dh.ngay_dat_hang);
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        return $stmt->get_result();

    }
    public function getChiTietDoanhThuNam($yearonly){

        $sql = "
        SELECT 
    DATE(dh.ngay_dat_hang) AS ngay_dat_hang,
    SUM(dh.tong) as doanh_thu,
    SUM(dh.tong - (s.gia_mua * ctdh.so_luong)) AS loi_nhuan,
    SUM(ctdh.so_luong) AS so_luong,
    COUNT(DISTINCT ctdh.ma_don_hang) AS so_don
FROM 
    donhang dh
JOIN 
    chitietdonhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang
JOIN 
    sach s ON ctdh.ma_sach = s.ma_sach
WHERE
    dh.trang_thai = 'DA_GIAO'
    AND YEAR(dh.ngay_dat_hang) = ?
GROUP BY
    MONTH(dh.ngay_dat_hang);";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $yearonly);
        $stmt->execute();
        return $stmt->get_result();

    }
    public function getDoanhThuThang($month, $year)
    {
        $sql = "SELECT 
    MONTH(dh.ngay_dat_hang) AS ngay_dat_hang,
    SUM(dh.tong) as doanh_thu,
    SUM(dh.tong - (s.gia_mua * ctdh.so_luong)) AS loi_nhuan,
    SUM(ctdh.so_luong) AS so_luong,
    COUNT(DISTINCT ctdh.ma_don_hang) AS so_don
    FROM 
    donhang dh
JOIN 
    chitietdonhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang
JOIN 
    sach s ON ctdh.ma_sach = s.ma_sach
WHERE
    dh.trang_thai = 'DA_GIAO'
    AND MONTH(dh.ngay_dat_hang) = ?
    AND YEAR(dh.ngay_dat_hang) = ?
GROUP BY
    MONTH(dh.ngay_dat_hang);";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getDoanhThuNam($yearonly){
        $sql ="SELECT  
    YEAR(dh.ngay_dat_hang) AS ngay_dat_hang,
    SUM(dh.tong) AS doanh_thu,
    SUM(dh.tong - (s.gia_mua * ctdh.so_luong)) AS loi_nhuan,
    SUM(ctdh.so_luong) AS so_luong,
    COUNT(DISTINCT ctdh.ma_don_hang) AS so_don
FROM 
    donhang dh
JOIN 
    chitietdonhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang
JOIN 
    sach s ON ctdh.ma_sach = s.ma_sach
WHERE
    dh.trang_thai = 'DA_GIAO'
    AND YEAR(dh.ngay_dat_hang) = ?
GROUP BY
    YEAR(dh.ngay_dat_hang);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",  $yearonly);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getBestSellerNgay($date){
        $sql = "SELECT 
    s.anh_bia as anh_bia,
    s.ten_sach,
    SUM(ctdh.so_luong) AS so_luong_ban
FROM 
    donhang dh
JOIN 
    chitietdonhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang
JOIN 
    sach s ON ctdh.ma_sach = s.ma_sach
WHERE 
    dh.trang_thai = 'DA_GIAO'
    AND DATE(dh.ngay_dat_hang) = ?
GROUP BY 
    s.ma_sach
ORDER BY 
    so_luong_ban DESC;
";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getBestSellerThang($month, $year){
        $sql = "SELECT 
    s.anh_bia as anh_bia,
    s.ten_sach,
    SUM(ctdh.so_luong) AS so_luong_ban
FROM 
    donhang dh
JOIN 
    chitietdonhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang
JOIN 
    sach s ON ctdh.ma_sach = s.ma_sach
WHERE 
    dh.trang_thai = 'DA_GIAO'
    AND MONTH(dh.ngay_dat_hang) = ?
    AND YEAR(dh.ngay_dat_hang) = ?
GROUP BY 
    s.ma_sach
ORDER BY 
    so_luong_ban DESC;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getBestSellerNam($yearonly){
        $sql = "SELECT 
    s.anh_bia as anh_bia,
    s.ten_sach as ten_sach,
    SUM(ctdh.so_luong) AS so_luong_ban
FROM 
    donhang dh
JOIN 
    chitietdonhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang
JOIN 
    sach s ON ctdh.ma_sach = s.ma_sach
WHERE 
    dh.trang_thai = 'DA_GIAO'
    AND YEAR(dh.ngay_dat_hang) = ?
GROUP BY 
    s.ma_sach
ORDER BY 
    so_luong_ban DESC;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $yearonly);
        $stmt->execute();
        return $stmt->get_result();
    }
}