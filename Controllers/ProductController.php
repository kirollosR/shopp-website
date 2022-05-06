<?php
require_once 'C:\xampp\htdocs\estore\Models\user.php';
require_once 'C:\xampp\htdocs\estore\Controllers\DBController.php';
@require_once 'C:\xampp\htdocs\estore\Models\product.php';


class ProductController
{
    protected $db;

    //1. Open connection
    //2. Run query
    //3. Close connection
    public function getCategories(){
        $this->db = new DBController;

        if($this->db->openConnection()){
            $query = "SELECT * FROM categories";
            return $this->db->select($query);
        }else{
            echo "Error in DataBase connection";
            return false;
        }
    }

    public function addProduct(product $product){
        $this->db = new DBController;

        if($this->db->openConnection()){
            $query =
                "INSERT INTO products
                 VALUES ('','$product->name','$product->description','$product->price',
                         '$product->quantity','$product->image',$product->categoryId)";
            return $this->db->insert($query);
        }else{
            echo "Error in DataBase connection";
            return false;
        }
    }

    public function getAllProducts(){
        $this->db = new DBController;

        if($this->db->openConnection()){
            $query = "SELECT products.id, products.name,description,price,quantity, categories.name as 'category',products.categoryId
                      FROM products,categories
                      WHERE products.categoryId = categories.id";
            return $this->db->select($query);
        }else{
            echo "Error in DataBase connection";
            return false;
        }
    }

    public function getAllProductsWithImages(){
        $this->db = new DBController;

        if($this->db->openConnection()){
            $query = "SELECT products.id, products.name,description,price,quantity,image, categories.name as 'category',products.categoryId
                      FROM products,categories
                      WHERE products.categoryId = categories.id";
            return $this->db->select($query);
        }else{
            echo "Error in DataBase connection";
            return false;
        }
    }

    public function getCategoryProducts($id){
        $this->db = new DBController;

        if($this->db->openConnection()){
            $query = "SELECT products.id, products.name,description,price,quantity,image, categories.name as 'category',products.categoryId
                      FROM products,categories
                      WHERE products.categoryId = categories.id
                      AND categories.id = $id";
            return $this->db->select($query);
        }else{
            echo "Error in DataBase connection";
            return false;
        }
    }

    public function deleteProduct($productId){
        $this->db = new DBController;

        if($this->db->openConnection()){
            $query =
                "delete from products
                 where products.id = $productId";
            return $this->db->delete($query);
        }else{
            echo "Error in DataBase connection";
            return false;
        }
    }
}