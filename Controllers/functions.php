<?
/*
 * Author: Kenny Betschart
 * Date: 10.12.2019
 * Project: myBlog
 * Filename: functions
 * Description: Controller for various function
 */

 // Loads class automatically
function __autoload($class){
    $class_file = __DIR__."/../Models/".ucfirst($class).".class.php";
    
	if(file_exists($class_file)) {
		include_once($class_file);
    } 
    else {
		die("Class $class couldn't be found!");
	}
}

// Required for the Login (needed on nearly every Page)
// Gets the Data from the Post and creats a new login Session
function user_login(){
    global $loginAssistant;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['username'])){

			//Entered Username and Password
			$username = $_POST['username'];
            $password = $_POST["password"];
            $loginAssistant = new LoginAssistant($username,$password);
            $_SESSION['user'] = $loginAssistant->user_login();
            
            //Generate a secure token using openssl_random_pseudo_bytes.
			if (empty($_SESSION['token'])) {
				$_SESSION['token'] = bin2hex(random_bytes(32));
			}
			$token = $_SESSION['token'];
            
            //Goes back to the Homepage
            header("Location: index.php?page=0");
        
			
		}
	}
}

// Required for the Logout (needed on nearly every Page)
// Destroys the Session if one already exists, if by any mistake there is a user logged in
// and cant logout because there is no session a new test  session and closes it again
function user_logout(){
    global $loginAssistant;

    // if the loginAssistant is not existing anymore create a new one to close the session
   if($loginAssistant == null){
       $loginAssistant = new LoginAssistant("temporary","temporary");
   }
	if(isset($_SESSION['user'])){
		if (isset($_POST["logout_button"])) {
			if(isset($_POST['token']) && hash_equals($_SESSION['token'], $_POST['token'])){
				$loginAssistant->user_logout();
				header("Location: index.php?page=0");
			}
			else{
				header("Location: index.php?page=0");
			}
		}
	}
}
 ?>