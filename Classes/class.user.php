<?php


class User {
    private $db;
	

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}		
	}

	public function login($username,$password){	
		
		$connection = mysql_connect('localhost', 'root', '');
		$select_db = mysql_select_db('blog');



		$query = "SELECT * FROM users WHERE username = '$username' and password = '$password'";

		$result = mysql_query($query) or die(mysql_error());
		$count = mysql_num_rows($result);
		
		if($count==1){
			$_SESSION['loggedin'] = true;
		}
			
	}

	public function returnUsername($username){
		return $username;
	}
	
		
	public function logout(){
		session_destroy();
	}
	
}
?>