<?php
// có class chứa các function thực thi xử lý logic 
class ProductController
{
    public $modelProduct;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();
    }

    public function Home()
    {
        require_once './views/trangchu.php';
    }
    
    public function Admin()
    {
        require_once './views/admin.php';
    }
}
