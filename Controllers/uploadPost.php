<?php
    /*
    * Author: Kenny Betschart
    * Date: 14.12.2019
    * Project: myBlog
    * Filename: uploadPost
    * Description: Controller for uploading a new post
    */

    require_once(__DIR__."/../inc/init.php");
    // if there are GET PARAMETERS

    // normal link 
    if(isset($_GET["link"])){   
        if($_GET["link"] == "uploadPost"){
            $upload = new View("UploadPost",true,false);
            $upload->set_placeholder("ERROR MESSAGE", "" );      
        }
    }

    else if(isset($_POST["UploadPostButton"])){
        $upload = new View("UploadPost",true,false);

        //Checks if a post with this title already exists
        $articleTitle = htmlspecialchars($_POST["UploadPostTitle"]);
        $dbConnection = new DatabaseConnection();
        $title_exists = $dbConnection->DoesPostTitleAlreadyExist($articleTitle);

        // if the title already exists display an error Message
        if($title_exists == true){
            $upload->set_placeholder("ERROR MESSAGE", "An Article with this title already exists!" );         
        }
        // if the article is a new one save it and redirect to frontpage
        else{
            $date = date("o:n:d");

            $articleText = htmlspecialchars($_POST["UploadPostText"]);
            $userid = $_SESSION['User']->userId;
            $dbConnection->UploadPost($date, $articleTitle, $articleText, $userid);
            $dbConnection->CloseConnection();

            //redirect
            header("Location: index.php?page=0");
        }
    }


    //Display all components
    $header->display();
    $nav->display();
    $upload->display();
    $footer->display();
?>  