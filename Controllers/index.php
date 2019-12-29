<?/*
*   Projekt:           myBlog
*   Datum:             10.12.2019  
*   Description:       Homepage of the website
*   Author:            Kenny Betschart         
*/

require_once("../inc/init.php");

// display Page
$header->display();
$nav->display();

// shows all posts (5 posts on each page);
ShowPosts();
   
//display Page
$footer->display();

?>