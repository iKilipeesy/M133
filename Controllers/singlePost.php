<?php
    /*
 * Author: Kenny Betschart
 * Date: 29.12.2019
 * Project: myBlog
 * Filename: singlePost
 * Description: Controller to show a single post in the website 
 */

    require_once("../inc/init.php");
    

    //Get from clicking a post 
    if(isset($_GET["post_id"]) && $_GET["post_id"] != null){

        //Get the id of the post that was clicked
        $post_id = $_GET['post_id'];
                
        //Get the entire post list from the db (is this method named wrong? or are we getting all the posts from the bd to just display one? work with id here)
        $dbConnection = new DatabaseConnection();
        $data = $dbConnection->GetPostWithId($post_id);
        $dbConnection->CloseConnection();

        //Combine strings for dateauthor
        $date_author = $data->creationDate . " ". $data->firstName . " ". $data->lastName;

        //Build up a html for the post itself
        $singlePost = new Post ($data->title, $data->text, $date_author, $post_id);

        //Display the full post body including the post
        $fullPost = new View("fullPost", true, false);
        $fullPost->set_placeholder("post_id", $post_id);
        $fullPost->set_placeholder("Posts", $singlePost->innerhtml);

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