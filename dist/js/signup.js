function SubmitSignUp(){

	var $form = $("#LoginForm"),
	url = $form.attr('action');
	var formData = new FormData();
	formData.append('firstname', $('#firstname').val());
	formData.append('lastname', $('#lastname').val());
	formData.append('password_1', $('#password_1').val());
	formData.append('password_2', $('#password_2').val());
	formData.append('email', $('#email').val());
	formData.append('phone', $('#phone').val());
	formData.append('alert', $('#alert').val());
	formData.append('location', $('#location').val());
	formData.append('lat', $('#lat').val());
	formData.append('lon', $('#lon').val());
	
	$.ajax({
       url : '_serv/signup.php',
       type : 'POST',
       data : formData,
       processData: false,  // no process
       contentType: false,  // no contentType
       success : function(data){
           if(data == "Success!"){
                alert("Successfully Registered, You may Login now.");
                $('#signupbox').hide();
                $('#loginbox').show();
           }else{
               alert(data);
           }
       }
	});

	return false;
};