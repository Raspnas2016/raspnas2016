<?php
session_start();
include(__DIR__ .'/objects/User.php'); // Includes Login Script
include(__DIR__ .'/objects/Database.php');

$rights = User::getUserRights(); //Überprüft ob der user admin rechte hat
if($rights != "admin"){
    header("location: index.php");
	die();
}
 //passwort zurücksetzt mit überprüfung von shared secret
if(isset($_POST['userToReset'])){
	if($_SESSION['identityAdm'] == $_POST['identityAdm']){
    User::resetPassword($_POST);
	}else{
		$attack = true;
	}
}
 // User hinzufügen
if(isset($_POST['NEWusername'])){
	if($_SESSION['identityAdm'] == $_POST['identityAdm']){
    User::addUser($_POST);
	}else{
		$attack = true;
	}
}
User::isOnline($_SESSION["login_user"]);
User::setTime($_SESSION["login_user"]);
$identityAdm = md5(uniqid()); // initialisierung von shared secret
$_SESSION['identityAdm'] = $identityAdm;
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <title>Adminseite</title>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
	<script language="JavaScript" type="text/javascript">
 // Funktion um User als offline in der db zu haben auch wenn tab geschlossen wird
$(function() {
	$(window).on('beforeunload ',function() {
		sendUserOfflineAjax();
});
function sendUserOfflineAjax(){
	var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "logout.php?name=<?php echo $_SESSION["login_user"] ?>&fu=true", true);
xhttp.send();
}});
    </script>
	
<script> // funktion für info kästchen 
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
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
			<img src="Pi_Logo.png" alt="Pi_Logo" height="50px"/>&nbsp;
            <!--<a class="navbar-brand" href="profile.php">User-Area</a>-->
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
			<li><a href="profile.php">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;<span class="sr-only">(current)</span></a></li>
                <li  class="active"><a href="admin.php">Adminbereich <span class="sr-only">(current)</span></a></li>
                <li><a href="change.php">Passwort ändern</a></li>
				<li><a href="config.php">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-cog" aria-hidden="true" data-toggle="tooltip" title="Einstellungen" data-placement="right"></span>&nbsp;&nbsp;&nbsp;</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><img src="Raspbian_logo.png" alt="Raspbian_logo" height="50px"/> </li>
                <li><a href="logout.php?name=<?php echo User::getUserName(); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span><b> Log Out</b></a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div id="admin" align="center">
    <h1><b id="welcome">Hey  <i><?php echo User::getUserName(); ?></i>, du befindest dich im Adminbereich.</b></h1>
</div>
<br>
<div role="alert" class="alert alert-danger col-xs-12 col-sm-8 col-sm-offset-2 <?php if(!$attack){ echo "hidden";} ?>">
    <?php echo "Potentieller Angriff erkannt. Bitte kontaktieren Sie einen Administrator.Fehlercode CSRF."; ?>
    <br>
</div>
<br><br>

<table align="center">
    <tr>
        <td style="vertical-align: top">
            <div id="newUser" align="center">
            <form action="" method="post">
                <table>
                    <th>
                        Neuen User Erstellen:
                    </th>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr>
                        <td><label>&nbsp; Neuer Username :</label></td>
                        <td>&nbsp; <input id="NEWusername" name="NEWusername" placeholder="Neuer Username" type="text" data-toggle="tooltip" title="Usernamen können nur einmal vergeben werden." data-placement="right"></td>
                    </tr>
                    <tr>
                        <td><label>&nbsp; Neues Passwort :</label></td>
                        <td>&nbsp; <input id="NEWpassword" name="NEWpassword" placeholder="**********" type="password"></td>
                    </tr>
                    <tr>
                        <td><label>&nbsp; Passwort bestätigen :</label></td>
                        <td>&nbsp; <input id="CONFIRMpassword" name="CONFIRMpassword" placeholder="**********" type="password"></td>
                    </tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr>
                        <td><label>&nbsp; Rechte :</label></td>
                        <td><select name="NEWrights" size="2" data-toggle="tooltip" title="Standart normaler User." data-placement="right">
                            <option selected>user</option>
                            <option>admin</option>
                        </select></td>
                    </tr>
                    <tr><td>&nbsp;<input type="hidden" name="identityAdm" value="<?php echo $identityAdm; ?>" /></td><td>&nbsp;</td></tr>
                    <tr>
                        <td></td>
                        <td>&nbsp; <input name="submit" type="submit" value="Erstellen" data-toggle="tooltip" title="Erstelle einen neuen User." data-placement="right"></td>
                    </tr>
                </table>
            </form>
            </div>
        </td>
        <td width="150px"></td>
        
    </tr>
    <tr><td>
    <div role="alert" class="alert alert-danger col-xs-12 col-sm-8 col-sm-offset-2 <?php if(User::getUserError()==""){ echo "hidden";} ?>">
        <?php echo User::getUserError(); ?></td><td width="150px">
    </div>
    </td><td></td></tr>
    <tr><td>
    <div role="alert" class="alert alert-danger col-xs-12 col-sm-8 col-sm-offset-2 <?php if(User::getPWError()==""){ echo "hidden";} ?>">
        <?php echo User::getPWError(); ?></td><td width="150px">
    </div>
    </td><td></td></tr>
    <tr><td>
    <div role="" class="alert alert-success col-xs-12 col-sm-8 col-sm-offset-2 <?php if(User::getDone()==""){ echo "hidden";} ?>">
        <?php echo User::getDone(); ?></td><td width="150px">
    </div>
    </td><td></td></tr>
	<tr><td>
    <div role="" class="alert alert-success col-xs-12 col-sm-8 col-sm-offset-2 <?php if(User::getChangeDone()==""){ echo "hidden";} ?>">
        <?php echo User::getChangeDone(); ?></td><td width="150px">
    </div>
    </td><td></td></tr>

<tr><td>
        <div id="deleteUser" align="center">
        <?php
		$currentUser = User::getUserName();
        $users = User::getUsernames();
        $anzahlUser = count($users);
        echo "<br><br>Es gibt bereits folgende <span class='badge'>". $anzahlUser ."</span> User:<br>Durch klicken auf den Link wird der User <b>unwiderruflich</b> gelöscht!<br><br><table>";
        echo "<tr><td></td><td>Username:</td><td width='20px'>&nbsp;</td><td>Letzter Aufruf der User-Seite:&nbsp;&nbsp;&nbsp;</td><td>Status:&nbsp;&nbsp;</td><td>Rechte:</td></tr>";
        for($u=0; $u < $anzahlUser; $u++){
			$farbe = "#ff0000";
			if($users[$u]["status"] == "online"){
				$farbe = "#00ff00";
			}
            echo "<tr><td>". ($u +1) .". &nbsp;</td><td>";
			if ($users[$u]["username"] == $currentUser){
				echo '<a href="#" onclick="return confirm(\'Mensch '. $users[$u]["username"] .', du kannst dich nicht selber löschen!\')">'. $users[$u]["username"] .'</a>';			
			}else{
            echo '<a href="delete.php?user='. $users[$u]["username"] .'&a" onclick="return confirm(\'Bist du sicher, dass du den User <'. $users[$u]["username"] .'> löschen willst?\')">'. $users[$u]["username"] .'</a>';
			}
			echo "</td><td></td><td>". $users[$u]["lastLogin"] ."</td><td style='background-color: ". $farbe ."'>". $users[$u]["status"] ."</td><td>&nbsp;". $users[$u]["rechte"] ."</td>";
			echo '<td><form action="" method="post" onsubmit="return confirm(\'Passwort von '. $users[$u]["username"] .' wirklich zurücksetzen?\');"><input id="userToReset" name="userToReset" value="'. $users[$u]["username"] .'" type="hidden"><input type="hidden" name="identityAdm" value="'. $identityAdm .'" /><input name="submit" type="submit" value="Passwort zur&uuml;cksetzten"></form></td></tr>';
        }
        ?>
            </table>
        </div>
    </td><td></td></tr>

    <tr style="height: 100px"><td></td><td></td><td></td></tr>

</table>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>