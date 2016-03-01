<?php
	session_start();
	#Löschen der Session-Variablen, wenn 'logout' gepostet wird
	if(isset($_POST['logout'])){
		session_destroy();
		exit();
	}

	include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'configuration.php';

	#Wenn 'username','password' und 'secret' gepostet werden und diese die richtigen Werte enthalten => login
	if (isset($_POST['username'],$_POST['password'],$_POST['secret']) &&
		$_POST['username'] == $GLOBALS['username'] && 
		hash('sha256', $_POST['password'] . $GLOBALS['salt']) == $GLOBALS['password'] && 
		$_POST['secret'] == $_SESSION['secret']  ) {
		$_SESSION['username'] = $_POST['username'] ;
	}else{ #Andernfalls Errorcode 400 (Bad Request)
		http_response_code(400);
	}
?>