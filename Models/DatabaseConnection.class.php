<?
/*
 * Author: Kenny Betschart
 * Date: 07.12.2019
 * Project: myBlog
 * Description: Database connection class
 */

class DatabaseConnection{  

    private $connection;

    private $db_name;
    private $db_username;
    private $db_password;
    private $db_host;


    //Constructor
    public function __construct(){
        $this->db_name = DB_NAME;
        $this->db_username = DB_USER;
        $this->db_password = DB_USER_PASSWORD;
        $this->db_host = DB_HOST_ADDRESS;

        //Open database Connection
        $this->connection  = $this->OpenConnection();
    }

    //Open DB Connection
    function OpenConnection(){

        $this->connection = new mysqli($this->db_host, $this->db_username, $this->db_password, $this->db_name);

        //Show error if the connection couldn't be made
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
            
        }
        
        return $this->connection;
    }

    //Close DB Connection
    function CloseConnection(){
        $this->connection->close();
    }


    function GetAllPosts(){

        //Prepare query statement
        $stmt = $this->connection->prepare("SELECT user.username, user.firstName, user.lastName,
        post.title, post.text, post.creationDate, post.postId, post.karma
        FROM post INNER JOIN user ON post.userId=user.userId");
        $stmt->execute();
        $data = $stmt->get_result();
    

        //Create a list of posts and fill them with the results we got from our query
        $posts=[];

        while($row = mysqli_fetch_object($data)){
            $posts[] = array("username" => $row->username, "firstname" => $row->firstName, "lastname" => $row->lastName, 
            "title" => $row->title, "text" => $row->text, "date" => $row->creationDate, "postId" => $row->postId, "karma" => $row->karma);
        }

        return $posts;
        
    }

    //takes a specific ID and gets a post with its information 
    function GetPostWithId($postID){

        //Prepare query statement
        $sql = "SELECT user.username, user.firstName, user.lastName,
        post.title, post.text, post.creationDate, post.postId, post.karma
        FROM post INNER JOIN user ON post.userId=user.userId WHERE post.postId = ?";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param('i',$postID);
        $stmt->execute();
        $result = $stmt->get_result();

        //Doesn't return anything if no or more than 1 post with the ID was found
        if(mysqli_num_rows($result) == 0 || mysqli_num_rows($result) > 1){
            return null; 
        }
        else if(mysqli_num_rows($result) == 1){
            return mysqli_fetch_object($result);
        }
    }
	
	function UpdatePostKarma($postID, $newKarma){
		//Prepare Sql Statement for update
		$sql = "UPDATE post SET karma=? WHERE postId=?";
		$stmt = $this->connection->prepare($sql);
		$stmt->bind_param("ii", $newKarma, $postID);
		
		//Execute returns a boolean if it was successfull or not
        if($stmt->execute()){
            //Success Message for user
        } 
        else{
            echo "Error: <br>" .mysqli_error($this->connection);

        } 
	}
    
    //Registers a new user in the Database
    function RegisterUser($username, $password, $email, $firstName, $lastName, $role){

        //Prepare SQL Statement for INSERT with parameters
        $stmt = $this->connection->prepare("INSERT INTO user (username, firstName, lastName, email, roleId, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssis', $username, $firstName, $lastName, $email, $role, $password);
        
        //Execute returns a boolean if it was successfull or not
        if($stmt->execute()){
            //Success Message for user
        } 
        else{
            echo "Error: <br>" .mysqli_error($this->connection);

        }  
    }

    //Checks if a User with the enterd username and password exists in the database
    function IsUserRegistered($username, $password){
        //Prepare SQL Query Statement with parameters
        $stmt = $this->connection->prepare("SELECT * FROM user WHERE username=? AND password=?");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();

        $result = $stmt->get_result();

        //Check if a user was found and return either the user or nothing
        if(mysqli_num_rows($result) == 0 || mysqli_num_rows($result) > 1){
            return null; 
        }
        else if(mysqli_num_rows($result) == 1){
            return mysqli_fetch_object($result);
        }       
    }

    //Inserts a user created post into the database
    function UploadPost($date, $articleTitle, $articleText, $userid){

        //Prepare SQL Statement for INSERT with parameters
        $stmt = $this->connection->prepare("INSERT INTO post (creationdate, title, text, userId) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sssi', $date, $articleTitle, $articleText, $userid);

        //Execute returns a boolean if it was successfull or not
        if($stmt->execute()){
            //Success Message for user
        } 
        else{
            echo "Error: " .$sql . "<br>" .mysqli_error($this->connection);

        }    
    }

    //Check if a post with the same title already exists in the database
    function DoesPostTitleAlreadyExist($articleTitle){

        //Prepare SQL Query Statement with one parameter
        $stmt = $this->connection->prepare("SELECT title FROM post WHERE title=?");
        $stmt->bind_param('s', $articleTitle);
        $stmt->execute();

        $result = $stmt->get_result();

        //If 1 or more Posts with that title were found return true otherwise return false
        if(mysqli_num_rows($result) == 0){
            return false; 
        }
        else if(mysqli_num_rows($result) >= 1){
            return true;
        }
    }

    //Checks if a user with the same username or email already exists in the database
    function DoesUserAlreadyExist($username, $email){

        //Prepare SQL Query Statement with parameters
        $stmt = $this->connection->prepare("SELECT username, email FROM user WHERE username=? OR email=? ");
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();

        $result = $stmt->get_result();

        //If 1 or more Users with that username/email were found return true otherwise return false
        if(mysqli_num_rows($result) == 0){
            return false; 
        }
        else if(mysqli_num_rows($result) >= 1){
            return true;
        }
    }



}
?>