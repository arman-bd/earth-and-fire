function SubmitLogin(){

	var $form = $("#LoginForm"),
	url = $form.attr('action');
	var formData = new FormData();
	formData.append('username', $('#username_login').val());
	formData.append('password', $('#password_login').val());
	
	$.ajax({
       url : '_serv/login.php',
       type : 'POST',
       data : formData,
       processData: false,  // no process
       contentType: false,  // no contentType
       success : function(data){
           if(data != "Invalid"){
                var dataObj = $.parseJSON(data);
                createCookie("user", dataObj['user'], 7);
                createCookie("token", dataObj['token'], 7);
                location.href = "report.html";
           }else{
               alert("Login Error!");
           }
       }
	});

	return false;
};