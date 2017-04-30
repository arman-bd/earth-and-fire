// Ajax Form Submission
function SubmitForm(){

	var $form = $("#ReportForm"),
	url = $form.attr('action');
	var formData = new FormData();

    // Time Zone
    var split = new Date().toString().split(" ");
    var timeZoneFormatted = split[split.length - 2] + " " + split[split.length - 1];
    var tzone = new Date().toString().match(/([A-Z]+[\+-][0-9]+)/)[1];

	formData.append('_ukey', $('#ukey').val());
	formData.append('_user', readCookie("user"));
	formData.append('_token', readCookie("token"));
	formData.append('lat', $('#lat').val());
	formData.append('lon', $('#lon').val());
	formData.append('location', $('#location').val());
	formData.append('date', $('#dateField').val()+" "+tzone);
	formData.append('type', $('#fire_type').val());
	formData.append('recaptcha', $("#g-recaptcha-response").val());
	formData.append('image', $('#image_file')[0].files[0]);
	
	
	
	$.ajax({
       url : '_serv/report.php',
       type : 'POST',
       data : formData,
       cache: false,
       processData: false,  // no process
       contentType: false,  // no contentType
       success : function(data){
           if(data == "Success!"){
               document.getElementById('final_result').style.display = "";
               document.getElementById('ReportForm').style.display = "none";

               if($('#location').val().indexOf("Dhaka") > 0){
                   document.getElementById('emergency_support').style.display = "";
               }
           }else{
               alert(data);
           }
       }
	});

	
	return false;
};

