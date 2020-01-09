<?
/*
 * Author: Kenny Betschart
 * Date: 10.12.2019
 * Project: myBlog
 * Filename: functions
 * Description: Controller for various function
 */

/*Required for the Login
* Gets the Data from the Post and creatds a new login Session*/
function user_login(){
    global $loginAssistant;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['username'])){

			//Entered Username and Password
			$username = $_POST['username'];
            $password = $_POST["password"];
            $loginAssistant = new LoginAssistant($username,$password);
            $_SESSION['User'] = $loginAssistant->user_login();
            
            //Goes back to the Homepage
            header("Location: index.php?page=0");
        
			
		}
	}
}

/* Required for the Logout (needed on nearly every Page)
*  Destroys the Session if one already exists, if by any mistake there is a user logged in
*  and cant logout because there is no session a new test  session and closes it again*/
function user_logout(){
    global $loginAssistant;

    //If the loginAssistant is not existing anymore create a new one to close the session
   if($loginAssistant == null){
       $loginAssistant = new LoginAssistant("temporary","temporary");
   }
	if(isset($_SESSION['User'])){
		if (isset($_POST["logout_button"])) {
			
			$loginAssistant->user_logout();
			header("Location: index.php?page=0");
		}
	}
}


function ShowPosts(){
	
	$post = new View("posts", true, false);
	
    // get a list of all posts from the DB
    $dbConnection = new DatabaseConnection();
    $data = $dbConnection->GetAllPosts();
    $dbConnection->CloseConnection();

	
	$amountOfRows = sizeof($data);
	
	if(isset($_GET["page"])){   
		if($_GET["page"] != NULL){
			$page = $_GET['page'];
        }
        else{
            header("Location: index.php?page=0");
        }
	}
	else{
        header("Location: index.php?page=0");
    }

	//Variables to replace the placeholders of the pageination
	$activePage = $page +1;
	$maxPages = intdiv($amountOfRows - 1, 5) + 1;

	//Gets the last and the first post of the current page
	$lastPost = ($page + 1) *5 - 1;
	$firstPost = $lastPost - 4;
 
    //Go through all posts and write them to HTML
    $htmlOutput = "";
	if($amountOfRows >= 5){     // if there are 5 or more 
		for ($i=$firstPost; $i <=$lastPost ; $i++) {

			if($i < sizeof($data) && $i >= 0){
                //create each post
                $temp = new Post($data[$i]["title"], $data[$i]["text"], 
                	$data[$i]["date"] . " ". $data[$i]["firstname"] . " ". $data[$i]["lastname"],
                	$data[$i]["postId"], $data[$i]['karma']); 

				$htmlOutput = $htmlOutput . $temp->innerhtml;
			}
		}
	}
	else{
		//If there are less then 4 entries
		//Go through all posts and write them to HTML
		for ($i=$firstPost; $i <=$amountOfRows - 1; $i++) {
			//create each post
			$temp = new Post($data[$i]["title"], $data[$i]["text"],
				$data[$i]["date"] . " ". $data[$i]["firstname"] . " ". $data[$i]['lastname'], $data[$i]['postId'], $data[$i]['karma']);
			$htmlOutput = $htmlOutput . $temp->innerhtml;
		}
    }

	SetPageination($amountOfRows, $page, $maxPages, $lastPost, $post, $activePage);

	//Display post preview on homepage
    $post->set_placeholder("Posts", $htmlOutput);
	$post->display();
	
}

function SetPageination($amountOfRows, $page, $maxPages, $lastPost, $post, $activePage){
	//When there are more posts than just on this site show the buttons to change pages
	if($amountOfRows >=6 ){
		$post->set_placeholder("next_page_button_link", "/myBlog/Controllers/index.php?page={next}");
		$post->set_placeholder("back_page_button_link", "/myBlog/Controllers/index.php?page={back}");
		
		//To switch between the posts
		if($page != 0){
			$post->set_placeholder("back", $page - 1);
		}
		else{
			$post->set_placeholder("back", $page);
		}

		if($page != $maxPages - 1){
			$post->set_placeholder("next", $page + 1);
		}
		else{
			$post->set_placeholder("next", $page);
		}

	}	
	// if there are 5 or less then 5 posts the Buttons will be hidden
	else{
		$post->set_placeholder("next_page_button_link", '');
		$post->set_placeholder("back_page_button_link", '');
		$post->set_placeholder("visible", 'hidden="hidden"');
	}
	
	//NEXT page
	if($amountOfRows <= $lastPost + 1){
		$post->set_placeholder("on_off_NEXT", 'disabled');
	}
	//PREVIOUS page
	else if($page == 0){
		$post->set_placeholder("on_off_PREVIOUS", 'disabled');
	}

	//Replaces placeholders with the right numbers
	$post->set_placeholder("activePage", $activePage);
	$post->set_placeholder("maxPages", $maxPages);
}
 ?>