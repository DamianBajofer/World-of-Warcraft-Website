class RegisterModule{

	start(){
		var data = $("#register-form").serialize();
		$.ajax({
			type: "POST",
			url: "modules/register/php/register.controller.php",
			data: data,
			success: (response) => {
				alert(response);
			},
			error: () => {
				alert("ERROR FATAL DE MODULO.");
			},
			beforeSend: () => {
				var Element = $("#register .button");
				Element.removeClass().addClass("button process").html("PROCESANDO");
			},
			complete: () => {
				var Element = $("#register .button.process");
				Element.removeClass().addClass("button").html("FINALIZAR");
			}
		});
	}

} var Register = new RegisterModule();