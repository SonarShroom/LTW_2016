<?php
	include("header.php");
	include("verify_code_duplicates.php");
	

	// recebe os valores enseridos , envia por mail o link para fazer a recuperaçao da pass

	
	if(isset($_POST['log_email'])) {
		$postemail = htmlentities($_POST['log_email']);
	} else {
		header("recovery.php");
	}
	
	$db = new PDO('sqlite:rest.db');
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('SELECT * FROM user WHERE email LIKE ?');
	$stmt->execute(array($postemail)); 
    $result=$stmt->fetchAll();

	if(count($result)>0) {
		
		$length = 10;
		$code = "";
		$valid = "0123456789abcdefghijklmnopqrstuvwxyz";
		
		do {
			for ($i = 0; $i < $length; $i++) {
				$code.=$valid[mt_rand(0, strlen($valid))];
			}
		} while(recovery_code($code)>0);
	
		$user_id = $result[0]['id'];
		$username = $result[0]['username'];
		$stmt = $db->prepare("INSERT INTO pass_recovery VALUES(?,?)");
		
		$stmt->execute(array($user_id,$code));
			
		$ip=$_SERVER['REMOTE_ADDR'];
		$link="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/recovery_change_pass.php?code=$code";
		$subject = "Recovery Password";
		$msg = "-- Please do not reply to this e-mail --\r\n \r\n
		Hello, $username. Someone requested to changed your password!\r\n
		To change your password, simply click <a href='$link'>this link</a>.\r\n
		If you didn't request any password change or don't know what this is about, please ignore this email.\r\n \r\n IP Request: $ip";
		$from = "restfeed.admin@fe.up.pt";
		$headers = "From: $from \r\n";
		$headers .= "Reply-To: $from \r\n";
		$headers .= "Return-Path: $from\r\n";
		$headers .= "X-Mailer: PHP \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
		
		mail($postemail,$subject,$msg,$headers);
		
		echo "<script type='text/javascript'>alert('Instructions to change password sent to your email. Please check your receive box or spam');window.location.href = 'main.php';</script>";
		return '';
	}
	else {
		echo "<script type='text/javascript'>alert('Email not valid.');window.location.href = 'recovery.php';</script>";
	}
	
	
?>