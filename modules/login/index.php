<link rel='stylesheet' href='modules/login/css/main.css'>
<script src='modules/login/js/main.class.js'></script>

<div class='section'>
	<div class='title'>Area de autenticación</div>
	<div class='box'>
		<form id='login-form' autocomplete="off">
			<div id='login'>
				<table>
					<tr>
						<td>USUARIO</td>
					</tr>
					<tr>
						<td><input type='text' name='login_username' placeholder='Ejemplo: Shadow23'></td>
					</tr>
					<tr>
						<td>CONTRASEÑA</td>
					</tr>
					<tr>
						<td><input type='password' name='login_password' placeholder='···············'></td>
					</tr>
				</table>
				<div class='button' onclick='login.start()'>CONECTAR</div>
			</div>
		</form>
	</div>
	<div class='divider'></div>
</div>