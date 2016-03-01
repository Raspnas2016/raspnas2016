<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ .'/objects/Functions.php');
require_once(__DIR__ .'/php/configuration.php');

if (basename($_SERVER['SCRIPT_NAME']) <> 'index.php' && !isset($_SESSION['username'])) {
    header("location: index.php");
	die();
}

$_SESSION['secret'] = md5(uniqid());

?>

<!DOCTYPE html>
<html lang="de" ><!--xmlns="http://www.w3.org/1999/html"-->
<head>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery-1.12.0.min.js"></script>
    <title><?php echo $title; ?></title>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href = "index.php">
			<img src="Pi_Logo.png" alt="Pi_Logo" height="50px"/>
			</a>
            <!--<a class="navbar-brand" href="index.php">Startseite</a>-->
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  
<?php if( isset($_SESSION['username']) ){ ?>

	        <ul class="nav navbar-nav">
				<li class="<?php if ($_SERVER['SCRIPT_NAME'] == "/index.php") echo "active" ?>"><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Startseite</a></li>
                <li class="<?php if ($_SERVER['SCRIPT_NAME'] == "/config.php") echo "active" ?>"><a href="config.php"><span class="glyphicon glyphicon-cog" aria-hidden="true" data-toggle="tooltip" title="Einstellungen" data-placement="right"></span> Einstellungen</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            	<li><a id="logout" href="#"><b>Logout</b></a></li>
            <ul>

<?php } else {?>

            <form class="navbar-form navbar-right" id="loginForm">
                <div class="form-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Benutzername" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Passwort" required>
                </div>
                <button type="submit" class="btn btn-default" id="login">Login</button>
            </form>

<?php } ?>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<input id="secret" type="hidden" value="<?php echo $_SESSION['secret']?>">
<div class="container-fluid">
    <div class="alert alert-danger alert-dismissible collapse" role="alert">
            <span id="errorMsg"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="alert alert-success alert-dismissible collapse" role="alert">
            <span id="successMsg"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>