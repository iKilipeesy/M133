<?php
/*
 * Author: Kenny Betschart
 * Date: 10.12.2019
 * Project: myBlog
 * Filename: LoginAssistanc.class
 * Description: Class for login and logout 
 */

class LoginAssistant{
    private $username;
    private $password;

    public function __construct($username, $password){
        $this->username = $username;
        $this->password = $password;

    }


    public function user_login(){

        // Check if the user is registered
        $dbConnection = new DatabaseConnection();
        $user = $dbConnection->IsUserRegistered($this->username, $this->password);
        $dbConnection->CloseConnection();

        // Save user in user session
        if(isset($user) && $user==true){
          return $user;
        }    
        
    }

    // Delete Session when the user logs out
    public function user_logout(){
        session_destroy();
    }
}




?>