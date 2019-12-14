<?
/*
 * Author: Kenny Betschart
 * Date: 03.12.2019
 * Project: myBlog
 * Filename: constants
 * Description: Class for defining constants
 */

// DB Login
define("DB_NAME","blog");
define("DB_USER","root");
define("DB_USER_PASSWORD","");
define("DB_HOST_ADDRESS","localhost");

// File Paths
define("VIEWS_PATH", "Views/");
define("DATABASE_FUNC", "DatabaseConnection.class.php");

define("SIGN_UP_CONTROLLER_LINK","/myBlog/Controllers/register.php?link=signup_form");
define("CREATE_POST_CONTROLLER_LINK","/myBlog/Controllers/new_post.php?link=new_post");
define("HOME_CONTROLLER_LINK", "/myBlog/Controllers/index.php?page=0");
?>