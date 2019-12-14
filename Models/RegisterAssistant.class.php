
<?php

/*
* Author: Kenny Betschart
* Date: 14.12.2019
* Project: myBlog
* Filename: registerassistant.class
* Description: Class that calls db methods for registering a user 
*/


class RegisterAssistant{

    private $username;
    private $password;
    private $email;
    private $firstname;
    private $lastname;
    private $role;


    public function __construct($username, $password, $email, $firstname, $lastname, $role = 2){
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->role = $role;
    }


    //If no user with the given credentials already exists in the db, create one
    public function RegisterUser() {
            $dbConnection = new DatabaseConnection();

            //Does user exist?
            $alreadyExists = $dbConnection->DoesUserAlreadyExist($this->username, $this->email);
            
            //Create user if he doesn't exist already
            if(!$alreadyExists){
             
                $dbConnection->RegisterUser($this->username, $this->password, $this->email, $this->firstname, $this->lastname, $this->role);
                $dbConnection->CloseConnection();
                return true;
            }
            else
            {
                $dbConnection->CloseConnection();
                return false;
            }
            
            
    }

}

?>