<?php
    /*
    * Author: Kenny Betschart
    * Date: 14.12.2019
    * Project: myBlog
    * Filename: uploadPost
    * Description: Controller for uploading a new post
    */

    require_once(__DIR__."/../inc/init.php");

    //Display the site if it was opened with the link
    if(isset($_GET["link"])){   
        if($_GET["link"] == "uploadPost"){
            $upload = new View("UploadPost",true,false);
            $upload->set_placeholder("ERROR MESSAGE", "" );      
        }
    }

    //Display the site if it was refreshed because of an update
    else if(isset($_POST["UploadPostButton"])){
        $upload = new View("UploadPost",true,false);

        //Check if the input fields have benn filled out
        if ($_POST["UploadPostTitle"] != null && $_POST["UploadPostText"] != null) {
            $dbConnection = new DatabaseConnection();

            $postTitle = htmlspecialchars($_POST["UploadPostTitle"]);

            //If the title already exists display an error Message
            if( $dbConnection->DoesPostTitleAlreadyExist($postTitle) ){
                $upload->set_placeholder("ERROR MESSAGE", "A Post with this title already exists!" );        
            }
            //If it's a new Post save it and redirect to the homepage
            else{
                $date = date("o:n:d");

                $postText = htmlspecialchars($_POST["UploadPostText"]);
                $userid = $_SESSION['User']->userId;
                $dbConnection->UploadPost($date, $postTitle, $postText, $userid);
                $dbConnection->CloseConnection();

                //Redirect
                header("Location: index.php?page=0");
            }

        }
        else{
            $upload->set_placeholder("ERROR MESSAGE", "You need to Fill out all the input fields!");
        }
        
    }


    //Display all components
    $header->display();
    $nav->display();
    $upload->display();
?>  