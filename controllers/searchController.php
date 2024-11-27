<?php
require_once 'C:/Users/Acer/Documents/GitHub/bookstore/DAO/sachDAO.php';

class searchController {
    private $sachDAO;

    public function __construct() {
        $this->sachDAO = new sachDAO();
    }
    public function search(){
        $keyWord = "";
        if(isset($_POST['search']) && !empty($_POST['search'])){
            $keyWord = $_POST['search'];
            $sachs = $this->sachDAO->searchBooks($keyWord);
        }
        require "view/search.php";
    }
}
