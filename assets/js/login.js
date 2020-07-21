$('document').ready(function()
{
     /* validation */
	 $(".form-validate").validate({
      rules:
	  {
			password: {
			required: true,
			},
			username: {
            required: true,
            },
	   },
       messages:
	   {
            password:{
            		  required: "<code>Enter your password</code>"
                     },
            username: "<code>Enter your username</code>",
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm()
	   {
		   var url = $("#url").val();
			var data = $(".form-validate").serialize();				
			$.ajax({				
			type : 'POST',
			url  : url+'ajax/login',
			data : data,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Sending ...');
			},
			success :  function(response)
			   {
					if(response=="ok"){
									
						$("#login").html('<i class="icon-spinner3 spinner"></i> &nbsp; Proses Login ...');
						setTimeout('window.location.href = "'+url+'home"; ',4000);
					}
					else{
						$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
						$("#login").html('Login <span class="icon-arrow-right14 position-right"></span>');
					});
					}
			  }
			});
				return false;
		}
	   /* login submit */
});