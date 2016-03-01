$(function(){
	//Klicken des 'Passwort anzeigen'-Buttons
	$("#visible").click(function(){
		//Den Textfeld-Typ zwischen 'text' und 'password' wechseln
		$("#wifiPassword").attr("type", (($("#wifiPassword").attr("type") == "password") ? "text": "password")); 
		//Das Icon im Button zwischen offen und geschlossenem Auge wechseln
		$(this).children(":first").toggleClass("glyphicon-eye-open").toggleClass("glyphicon-eye-close");
	});

	//Klicken auf den "Passwort festlegen"-Button
	$("#setWifiPassword").submit(function(data){
		//Submit abbreche
		data.preventDefault();
		//Prüfen, ob das Passwort acht oder mehr Zeichen lang ist
		if($("#wifiPassword").val().length < 8){
			//Fehler
			error("Das Passwort muss mindestens 8 Zeichen lang sein");
		}else{
			//Passwort ändern
			ajax({ req: "wifiPpassword", pw: $("#wifiPassword").val()});
		}
	});

	//Klicken des "WLAN-Verschlüsselung"-Sliders
	$("#switchEncrypt").click(function(){
		ajax({ req: "encryption", status: ($(this).is(":checked")?"on":"off")});
	});

	//Klicken des "Pi neustarten"-Buttons
	$("#restartPi").click(function(){
		$(this).button('loading');
		ajax({ req: "restartPi"}, 
			function(){error("Ein Fehler ist aufgetreten");},
			function(){success("Bitte die Verbindung neu aufbauen, sobald dies möglich ist und diese Seite aktualisieren");});
	});

	//Klicken der "Berechtigungen ändern"-Slider
	$("#switchRead, #switchWrite").click(function(){	
		//Werte einfach durchreichen. Validierung passiert serverseitig	
		ajax({ req: $(this).attr("name"), status: ($(this).is(":checked")?"on":"off")});
	});

	//Klicken der "Passwort festlegen"-Slider
	$("#setPassword").submit(function(data){
		//Submit abbreche
		data.preventDefault();

		var val1 = $("#password1").val();
		var val2 = $("#password2").val();

		//Werte validieren und, falls sie OK sind, an den Server senden.
		if (val1.length < 6) {
			error("Das Passwort muss mindestens 6 Zeichen lang sein");
		}else if(val1 !== val2){
			error("Die Passwörter müssen identisch sein");
		}else{
			errorHide();
			//Es reicht, ein Passwort zu übermitteln. Doppelte Eingabe ist nur für den Benutzer.
			ajax({ req: "password", pw: val1}, function(){success('Das Passwort wurde erfolgreich geändert');});
		}	
	});
});

function ajax(data, success, error){
	if (typeof success === 'undefined') {
		success = function(){
			errorHide();
		}
	}
	if (typeof error === 'undefined') {
		error = function(){
			error("Ein Fehler ist aufgetreten");
		}
	}
	data.secret = $("#secret").val;
	$.ajax({
		url: "util.php",
		type: 'POST',
		data: data,
		success: success,
		error: error
	});
}