<link rel='stylesheet' href='modules/register/css/main.css'>
<script src='modules/register/js/register.class.js'></script>

<div class='title'>REGISTRO DE USUARIO</div>
<form id='register-form'>
	<div id='register'>
		<table>
			<tr>
				<td>NOMBRE DE USUARIO</td>
			</tr>
			<tr>
				<td><input type='text' name='register_username' size='50' placeholder='Ejemplo: Shadow23'></td>
			</tr>
		</table>
		<table>
			<tr>
				<td>CORREO ELECTRONICO</td>
			</tr>
			<tr>
				<td><input type='email' name='register_email' size='50' placeholder='Ejemplo@hotmail.com'></td>
			</tr>
		</table>
		<table>
			<tr>
				<td>CONTRASEÑA</td>
			</tr>
			<tr>
				<td><input type='password' name='register_password' size='50' placeholder='···············'></td>
			</tr>
		</table>
		<table>
			<tr>
				<td>COMPROBAR CONTRASEÑA</td>
			</tr>
			<tr>
				<td><input type='password' name='register_rpassword' size='50' placeholder='···············'></td>
			</tr>
		</table>
		<div class='button' onclick="Register.start()">FINALIZAR</div>
	</div>
</form>