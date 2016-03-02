<?php
session_start();

include(__DIR__ .'/objects/Functions.php');

//Die Post-Variable req muss vorhaden sein
if(!isset($_POST['req'], $_POST['secret']) || $_SESSION['secret'] != $_POST['secret']){
	error();
}
/*#
#	Mögliche reqs:
#	-'passwort': wenn die Post-Variable pw gesetzt und länger als acht Zeichen ist wird das WLAN-Passwort dazu gesetzt
#	-'encryption': Aktiviert oder Deaktiviert, abhängig von der Post-Variable status, die WLAN-Verschlüsselung
#	-'restartWifi': startet des Service hostapd neu
#	-'read'/'write': Erlaubt/Verbietet, abhängig von der Post-Variale status, das lesen/schreiben auf den Share
#*/
Switch($_POST['req']){
	case 'wifiPassword':
		if(isset($_POST['pw']) && strlen($_POST['pw']) >= 8){
			setWifiPassword($_POST['pw']);
		}else{ error(); }
		break;
	case 'encryption':
		if(isset($_POST['status'])){
			if($_POST['status'] == 'on'){
				setEncryption(true);
			}else if($_POST['status'] == 'off'){
				setEncryption(false);
			}else{ error(); }
		}
		break;
	case 'restartPi':
		restartPi();
		break;
	case 'restartSamba':
		restartSamba();
		break;
	case 'password':
		if(isset($_POST['pw']) && strlen($_POST['pw']) >= 6){
			setPassword($_POST['pw']);
		}else{ error();}
		break;
	default:
		if(( isset($_POST['status']) &&
			 $_POST['req'] == 'read' || $_POST['req'] == 'write') &&
			($_POST['status'] == 'on' || $_POST['status'] == 'off')){
				setAccess($_POST['req'], ($_POST['status'] == 'on' ? true:false));
		}else{
			error();
		}
}

function error(){
	http_response_code(400);
	exit();
}
?>