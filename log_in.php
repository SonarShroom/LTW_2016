<?php
include('header.php');
include('getInputSafe.php');
include('verify_code_duplicates.php');
$result;//users with given username (and password, depending on the method called)

sleep(1);//avoid spam

// ----------------------- VALIDATE OPERATION

if ($_SERVER["REQUEST_METHOD"] != "POST") 	{
	 header("location: main.php?errorMsg=".urlencode("Illegal call to log_in.php"));
	 return '';	
	}
	
	$postusername = htmlentities($_POST['log_username']);
	$postpass = htmlentities($_POST['log_password']);
	if(isset($_POST['log_type'])) {
		$posttype = htmlentities($_POST['log_type']);
	}
	if(isset($_POST['log_email'])) {
		$postemail = htmlentities($_POST['log_email']);
	}
	
	if( !isset($postusername)
	||!isset($postpass)
	//||!isset($postemail)
	||$postusername===null
	||$postusername===""
	||$postpass===null
	||$postpass==="")
	{
	 header("location: main.php?errorMsg=".urlencode("Field is Empty!"));
	 return '';	
	}
	
// ----------------------- AUX FUNCS

function number_of_usersnamed()					
{
	global $result;
	global $postusername;
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare('SELECT id FROM user WHERE UPPER(username) = UPPER(?)');
	$stmt->execute(array($postusername)); 
    $result=$stmt->fetchAll();
	return count($result);
}
function number_of_usersnamed_with_pass()    
{
	global $postusername;
	global $postpass;
	global $result;
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare('SELECT * FROM user WHERE UPPER(username) = UPPER(?) and password = ?');
	$stmt->execute(array($postusername, md5($postpass))); 
    $result=$stmt->fetchAll();
	if(count($result)>0) {
		$postusername=$result[0]['username'];
	}
	return count($result);
}


function user_type2()   //envia o username , retorna o tipo de utilizador (0 - owner , 1 - reviewer)
{
	global $postusername; //envia o username do login
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("SELECT type from user WHERE user.username = ? ");
	$stmt->execute(array($postusername)); 
    $usertype=$stmt->fetchAll();

    return ($usertype[0]['type']);

}



function number_of_users_with_email()   
{
	global $postusername;
	global $postpass;
	global $postemail;
	global $result;
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare('SELECT * FROM user WHERE email LIKE ?');
	$stmt->execute(array($postemail)); 
    $result=$stmt->fetchAll();
	return count($result);
}

// ----------------------- REGISTO
	
 if($_POST['choice']=="REGISTER")  //SE REGISTER ESCOLHIDO
{
	if($_POST['log_password_conf']!=$postpass)
	{
		header("location: main.php?errorMsg=".urlencode("\"password\" field is different than \"confirm password\""));
		return '';
	}
	
	if((validateInput($mail_match,$postemail))===false)
	{
		header("location: main.php?errorMsg=".urlencode("\"email\" not accepted"));
		return '';
	}
	
	if(number_of_usersnamed() === 0)
	{
		if(number_of_users_with_email() === 0 ) {
			
			//Gera uma serie de 10 carateres aleatorios que será usado como activation code 
			
			$length = 10;
			$code = "";
			$valid = "0123456789abcdefghijklmnopqrstuvwxyz";
			
			do {
				for ($i = 0; $i < $length; $i++) {
					$code.=$valid[mt_rand(0, strlen($valid))];  
				}
			} while(activation_code($code)>0);
			
		
			$dbh = new PDO('sqlite:rest.db');
			$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$stmt = $dbh->prepare("INSERT INTO user VALUES(NULL, ?,?,?,?,?,?)");
			$stmt->execute(array($postusername, md5($postpass),$posttype,0,$code,$postemail));
			
			
			$link="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/activate.php?code=$code";
			$subject = "Account Activation";
			$msg = "Hello, $postusername. Welcome to RestFeed!\n
			To complete your registration, simply click <a href='$link'>this link</a>. to activate your account.\n
			Thank you and see you later!";
			$from = "restfeed.admin@fe.up.pt";  //teste
			$headers = "From: $from \r\n";
			$headers .= "Reply-To: $from \r\n";
			$headers .= "Return-Path: $from\r\n";
			$headers .= "X-Mailer: PHP \r\n";
			$headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8\r\n";
		
			mail($postemail,$subject,$msg,$headers);


			
			echo "<script type='text/javascript'>alert('Account created. Check your email for verification link.');window.location.href = 'main.php';</script>";
			return '';
		}
		else {
			echo "<script type='text/javascript'>alert('Email already in use. Please, choose another.');window.location.href = 'main.php';</script>";
			return '';
		}
		
	}
	else {
		echo "<script type='text/javascript'>alert('Username already in use. Please, choose another.');window.location.href = 'main.php';</script>";
		return '';
	}
}






else if($_POST['choice']!="LOGIN")   //LOGIN ESCOLHIDO
{
	echo "INVALID ACCESS";
	return '';
}

// ----------------------- LOGIN 

if($_POST['choice']=="LOGIN" && (!isset($_POST['login_token']) || $_POST['login_token'] !== $_SESSION['login_token']) ){
	header("location: main.php?errorMsg=".urlencode("Tried to Login from unknown source."));
return;
}

    // If result matched $myusername and $mypassword, table row must be 1 row
    if (number_of_usersnamed_with_pass() >= 1) {
        //session_register("myusername");
		$aux = $result[0]['id'];
        $_SESSION['login_user'] = $aux;// $postusername;
		$_SESSION['login_username'] = $postusername;
		
		$usertype=user_type2() ;

		$_SESSION['login_type'] = $usertype;
		
		
		if(validate_user())	 //se o validate_user der true..
		{
			echo "<script type='text/javascript'>alert('Login successful');window.location.href = 'main.php';</script>"; //login success
			header('Location: ' . str_replace( "errorMsg","pEM",$_SERVER['HTTP_REFERER']));
		}
		else 
		{
			echo "<script type='text/javascript'>alert('".$login_validation_result_msg."');</script>";
			session_destroy();
			echo "<script type='text/javascript'>window.location.href = 'main.php';</script>";
		}
    } else {
        echo "<script type='text/javascript'>alert('Incorrect Username or Password.');</script>";
		session_destroy();
		echo "<script type='text/javascript'>window.location.href = 'main.php';</script>";
		
    }



?>