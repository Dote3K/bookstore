<?php
interface DAOInterface {
    public function selectAll(): array; // Phương thức trả về mảng
    public function selectById($id); // Không có kiểu trả về
    public function insert($object): int; // Phương thức trả về int
    public function update($object): int; // Phương thức trả về int
    public function delete($id): int; // Phương thức trả về int
}
?>
