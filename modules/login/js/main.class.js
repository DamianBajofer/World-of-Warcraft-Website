class LoginModule{

	start(){
		let data = $("#login-form").serialize()

		$.ajax({
			type: "POST",
			data: data,
			url: "modules/login/php/login.controller.php",
			success: (data) => {
				if(data){
					window.location.href = `${window.location.origin}?page=news`
				}else{
					alert("Datos de cuenta incorrectos.")
				}
			},
			error: () => {
				alert("Ha ocurrido un error interno del sistema")
			},
			beforeSend: () => {
				let Element = $("#login .button")
				Element.removeClass().addClass("button process").html("PROCESANDO...")
			},
			complete: () => {
				let Element = $("#login .button.process")
				Element.removeClass().addClass("button").html("CONECTAR")
			}
		})

	}

} let login = new LoginModule()