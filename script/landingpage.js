"use-strict";
const loginURL = "API/login.php";
const myProfilePage = "myprofilepage.html";
const cookieName = "session";

$(window).load(function() {
	if(getCookie(cookieName) != ""){
		window.location.href= myProfilePage;
		return;
	}
	
	$("#login_btn").click(function() {
		var username = $("#inputUsername").val();
		var password = $("#inputPassword").val();
		// if(username.length < 1 || password.length < 1){
		// alert("invalid username or password");
		// return;
		// }
		$.ajax({
			type : "POST",
			url : loginURL,
			data : {
				'username' : username,
				'password' : password
			}
		}).always(function(returnData) {
			//'cast' to a json object
			var json = JSON.parse(returnData);
			if(json.error){
				alert("invalid username/password :" + json.err_pos);
			}else{
				if(json.cookie != null){
					if(parseInt(json.cookie.length) == 40 ){
						setCookie(cookieName,json.cookie);
						window.location.href= myProfilePage;
						return;
					}
				}
				alert(json);
			}
		});
	});
});


