


$(document).ready(function(){
	
	// Form Validation
    $("#basic_validate").validate({
		rules:{
			nome:{
				required:true,
				minlength:6,
				maxlength:30,	
			},
			email:{
				required:true,
				email:true
			},
			telefone:{
				required:true,
				minlength:10
			},
			cidade:{
				required:true
			},
			estado:{
				required:true
			},
			assunto:{
				required:true
			},
			mensagem:{
				required:true
			}
            
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
});
