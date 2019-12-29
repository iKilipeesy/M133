<?php
    /*
    * Author: Kenny Betschart
    * Date: 14.12.2019
    * Project: myBlog
    * Filename: register
    * Description: Controller for registering a new user
    */

    require_once(__DIR__."/../inc/init.php");
    // if there are GET PARAMETERS

    // normal link 
    if(isset($_GET["link"])){   
        if($_GET["link"] == "signup_form"){
            $register = new View("signup",true,false);
            $register->set_placeholder("ERROR MESSAGE", "" );
            
        }
    }
    // if there are POST PARAMETERS
    else if(isset($_POST["signup_button_form"])){
        $register = new View("signup",true,false);

        if($_POST != array() && $_POST["signup_passw"] == $_POST["signup_cpassw"]){          
            //User data            
            $password = $_POST["signup_passw"];
            $username = $_POST['signup_username'];
            $email = $_POST['signup_email'];
            $firstname = $_POST['signup_fname'];
            $lastname = $_POST['signup_lname'];
                
            //Register user
            $registerAsisstant = new RegisterAssistant($username,$password,$email,$firstname,$lastname);
            $userCreated = $registerAsisstant->RegisterUser();

            // if the user has been created
            if($userCreated){
                // redirect to home
                Header("Location: index.php?page=0"); 
            }
            else
            {
                // display an error Message
                $register->set_placeholder("ERROR MESSAGE", "A user with these credentials already exists");
            }

        }
        else if ($_POST != array())
        {
            //Unmatching passwords error
            $register->set_placeholder("ERROR MESSAGE", "Your Passwords don't match");
           
        }

    }

    //Display all components
    $header->display();
    $nav->display();
    $register->display();
    $footer->display();
?>