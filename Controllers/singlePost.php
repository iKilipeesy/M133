<?php
    /*
 * Author: Kenny Betschart
 * Date: 29.12.2019
 * Project: myBlog
 * Filename: singlePost
 * Description: Controller to show a single post in the website 
 */

    require_once("../inc/init.php");
    $errorMessage = "";
    //Get the id of the post that was clicked
    $post_id = $_GET['post_id'];
    
    //If a karma buttons has been pressed update the karma value
    if ( isset($_POST["upvoteButton"]) || isset($_POST["downvoteButton"]) ) {
        if ( isset($_SESSION["User"]) ) {
            $dbConnection = new DatabaseConnection();
            $data = $dbConnection->GetPostWithId($post_id);

            if( isset($_POST["upvoteButton"]) ){

                $dbConnection->UpdatePostKarma( $_GET["post_id"], $data->karma + 1);
            }
            else if( isset($_POST["downvoteButton"]) ){
                $dbConnection->UpdatePostKarma( $_GET["post_id"], $data->karma - 1);
            }

            $dbConnection->CloseConnection();
        }
        else{
            $errorMessage = "You need to be logged in to rate a post!";
        }
    }
    

    //Get from clicking a post 
    if(isset($_GET["post_id"]) && $_GET["post_id"] != null){
        
        //Get the post again so the updated karma value gets displayed
        $dbConnection = new DatabaseConnection();
        $data = $dbConnection->GetPostWithId($post_id);
        
        //Combine strings for dateauthor
        $date_author = $data->creationDate . " ". $data->firstName . " ". $data->lastName;

        //Display the full post body including the post
        $fullPost = new View("entirePost", true, false);
        $fullPost->set_placeholder("date_author", "$date_author");
        $fullPost->set_placeholder("title", $data->title);
        $fullPost->set_placeholder("text", $data->text);
        $fullPost->set_placeholder("amountOfKarma", $data->karma);
        $fullPost->set_placeholder("ERROR MESSAGE", $errorMessage);
        //PostId for the link
		$fullPost->set_placeholder("post_id", $_GET["post_id"]);

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

?>