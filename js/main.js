$(function(){	
	var button; 
	$("test").alert();
	if( (button = $("#login")).length ){
		$("#loginForm").submit(function(data){
			data.preventDefault();
			if( $("#username").val() && $("#password").val() ){
				$.ajax({
					url: "php/login.php", 
					type: "POST",
					data: { username: $("#username").val(), password: $("#password").val(), secret: $("#secret").val() },
					success: function(){
						location.reload();
					},
					error: function(data){
						if( data.status == 400 ){
							$("#username, #passwort").parents().addClass("has-error");
							error("Benutzername oder Passwort sind falsch");
						}else{
							error("Ein Fehler ist aufgetreten");
						}
						$("#password").val("");
					}
				});
			}else{
				$("#username, #password").each( function(){ if(!$(this).val()){ $(this).parent().addClass("has-error")} else { $(this).parent().removeClass("has-error") }});
			}
		});
	}else if( (button = $("#logout")).length) {
		button.click(function(){
			$.ajax({
				url: "php/login.php", 
				type: "POST",
				data: { logout: "true" },
				success: function(){
					location.reload();
				},
				error: function(){
					error("Ein Fehler ist aufgetreten");
				}
			});
		});
	}
});

function error(msg){
	$("#errorMsg").html(msg).parent().fadeIn().on('close.bs.alert', function(data){
		data.preventDefault();
		$(this).hide();
	});
}

function success(msg){
	$("#successMsg").html(msg).parent().fadeIn().on('close.bs.alert', function(data){
		data.preventDefault();
		$(this).hide();
	});
}

function errorHide(){
	$("#errorMsg, #successMsg").parent().fadeOut();
}