<?
/*
 * Author: Kenny Betschart
 * Date: 03.12.2019
 * Project: myBlog
 * Filename: init
 * Description: File for initializing other files
 */


    session_start();
    $loginAssistant = null;

    /*************************Require files*******************************/
    if(file_exists(__DIR__."/constants.php")) {
        require_once(__DIR__."/constants.php");
    } 
    else {
        die("Constants file couldn't be found!");
    }

    if(file_exists(__DIR__."/../Models/DatabaseConnection.class.php")) {
        require_once(__DIR__."/../Models/DatabaseConnection.class.php");
    } 
    else {
        die("DatabaseConnection class file couldn't be found!");
    }

    if(file_exists(__DIR__."/../Models/View.class.php")) {
        require_once(__DIR__."/../Models/View.class.php");
    } 
    else {
        die("View class file couldn't be found!");
    }

    if(file_exists(__DIR__."/../Controllers/functions.php")) {
        require_once(__DIR__."/../Controllers/functions.php");
    } 
    else {
        die("Functions file couldn't be found!");
    }
    /**************************************************************************/

    // Check if user has logged in or logged out
    user_login();
    user_logout();

    // Load generic UI (Footer Header Login Navigation Logout)
    $header = new View("header",true,false);

    //Load proper login window and menu - might be able to export this
    if(isset($_SESSION['user'])){
        // Load the Navbar for logged in users
        $nav = new View("navbar_loggedin", true, false);
    
    }
    else{
        // Load the navbar for new users
        $nav = new View("navbar_standard", true, false);

    }

    $footer = new View("footer", true, false);
 ?>