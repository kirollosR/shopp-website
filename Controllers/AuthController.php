<?php
require_once 'C:\xampp\htdocs\estore\Models\user.php';
require_once 'C:\xampp\htdocs\estore\Controllers\DBController.php';

class AuthController
{
    protected $db;

    //1. Open connection
    //2. Run query
    //3. Close connection
    public function login(user $user){
        //object from the database controller
        $this->db = new DBController;

        if($this->db->openConnection()){ // open connection to DB
            $query=
                "select * from users 
                 where email = '$user->email' and password = '$user->password'";

            $result = $this->db->select($query);
            if($result === false){
                echo "Error in query";
                $this->db->closeConnection();
                return false;
            }else{
                if(count($result)==0){
                    session_start(); //create a session 3ashan fe kol el pages yeb2a be nafs el data beta3to
                    $_SESSION['errorMsg'] = "You have entered wrong email or password";
                    $this->db->closeConnection();
                    return false;
                }else{
                    session_start();
                    $_SESSION['userId'] = $result[0]["id"];
                    $_SESSION['userName'] = $result[0]["name"];
                    $_SESSION['userRole'] = $result[0]["roleId"];
                    $this->db->closeConnection();
                    return true;
                }
            }
        }else{
            echo "Error in DataBase connection";
            return false;
        }
    }

    public function register (user $user)
    {
        $this->db = new DBController;

        if ($this->db->openConnection()) {
            $query =
                "INSERT INTO users(name,email,password,roleId)
                 VALUES ('$user->name','$user->email','$user->password',2)";

            $result = $this->db->insert($query);
            if ($result != false) {
                session_start();

                $_SESSION['userId'] = $result;
                $_SESSION['userName'] = $user->name;
                $_SESSION['userRole'] = 2;

                $this->db->closeConnection();
                return true;
            } else {
                $_SESSION["errorMsg"] = "Something went wrong.. Try again";
                $this->db->closeConnection();
                return false;
            }
        } else {
            echo "Error in DataBase connection";
            return false;
        }
    }

    public function isAuthenticated($roleId){
        if(!isset($_SESSION["userRole"])){  //authentication
            return false;
        }else if($_SESSION["userRole"]!= $roleId) { //authorization
            return false;
        }else{
            return true;
        }
    }
}