<?php
require_once(__DIR__ .'/../php/configuration.php');
//Gibt das aktuell verwendete WLAN-Passwort zurück
//return: boolean
function getWifiPassword(){
	return exec("sed -n 's/.*wpa_passphrase=//p' /etc/hostapd/hostapd.conf");
}
//Setzt das aktuelle WLAN-Passwort
function setWifiPassword($pw){
	exec("sed -i 's/wpa_passphrase=.*/wpa_passphrase=".$pw."/' /etc/hostapd/hostapd.conf");
}
//Aktiviert/Deaktiviert die Verschlüsselung des WLANs
//input: boolean
function setEncryption($on){
	if ($on) {
		exec("sed -ri '/(^#wpa|^#rsn)/s/^#//g' /etc/hostapd/hostapd.conf");
	}else{
		exec("sed -ri '/(^wpa|^rsn)/s/^/#/g' /etc/hostapd/hostapd.conf");
	}
}
//Gibt zurück, ob aktuell die WLA-Verschlüsselung aktiv ist
//return: boolean
function getEncryption(){
	return (trim(exec("sed -n 's/wpa_passphrase.*//p' /etc/hostapd/hostapd.conf")) == "");
}

//Neustart des Raspberry Pis
function restartPi(){
	exec("sudo /etc/init.d/hostapd stop && sudo /sbin/reboot");
}

//Neustart des Sambas
function restartSamba(){
	exec("sudo /etc/init.d/samba stop");
	exec("sudo /etc/init.d/samba start");
}

//Setzt die Zugriffsberechtigung für den Share
//input: String("read"/"write"), boolean
function setAccess($attr, $on){	
	if($attr == "read"){
		exec("sed -ri '/(guest ok)/s/=.*$/= ".($on?"yes":"no")."/g' /etc/samba/smb.conf");
	}else{
		exec("sed -ri '/(read only)/s/=.*$/= ".($on?"no":"yes")."/g' /etc/samba/smb.conf");
	}
}

//Gibt die aktuelle Zugriffsbrechtigung für das übergebene Attribut zurück
//input: String("read"/"write")
function getAccess($attr){
	if($attr == "read"){
		return (trim(exec("sed -n 's/guest ok = //p' /etc/samba/smb.conf")) == "yes");
	}else{
		return (trim(exec("sed -n 's/read only = //p' /etc/samba/smb.conf")) == "no");
	}
}

function setPassword($pw){
	exec("sed -ri '/(password)/s/= .*$/= \\x27".(hash('sha256', $pw . $GLOBALS['salt']))."\\x27;/g' /var/www/html/php/configuration.php");
}
?>