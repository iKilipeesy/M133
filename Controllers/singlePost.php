<?php
    /*
 * Author: Kenny Betschart
 * Date: 29.12.2019
 * Project: myBlog
 * Filename: singlePost
 * Description: Controller to show a single post in the website 
 */

    require_once("../inc/init.php");
    $karma;
    $post_id;
    
    //Get from clicking a post 
    if(isset($_GET["post_id"]) && $_GET["post_id"] != null){

        //Get the id of the post that was clicked
        $post_id = $_GET['post_id'];
                
        //Get the entire post list from the db (is this method named wrong? or are we getting all the posts from the bd to just display one? work with id here)
        $dbConnection = new DatabaseConnection();
        $data = $dbConnection->GetPostWithId($post_id);

        //Combine strings for dateauthor
        $date_author = $data->creationDate . " ". $data->firstName . " ". $data->lastName;

        //Display the full post body including the post
        $fullPost = new View("entirePost", true, false);
        $fullPost->set_placeholder("date_author", "$date_author");
        $fullPost->set_placeholder("title", $data->title);
        $fullPost->set_placeholder("text", $data->text);

        $karma = $data->karma;
        $fullPost->set_placeholder("KarmaValue", $karma);

        $dbConnection->CloseConnection();

    } 
    else{
        //Error
        header("Location: index.php?page=0");
    }

    //Display Page
    $header->display();
    $nav->display();
    $fullPost->display();
    $footer->display();
    

?>