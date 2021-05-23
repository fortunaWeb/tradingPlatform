<h1>Страница авторизации</h1>
<p>
<form action="/?task=login&action=enter" method="post">
<table class="login">
	<tr>
		<th colspan="2">Авторизация</th>
	</tr>
	<tr>
		<td>Логин</td>
		<td><input type="text" name="login"></td>
	</tr>
	<tr>
		<td>Пароль</td>
		<td><input type="password" name="password"></td>
	</tr>
	<th colspan="2" style="text-align: right">
	<input type="submit" value="Войти" name="btn"
	style="width: 150px; height: 30px;"></th>
</table>
</form>
</p>


<p><?php if($data) echo $data; else echo ""; ?></p>


<p>
<br />
После переноса сайта, все пароли не удалось сохранить, теперь для того чтобы войти, сделайте данную операцию один раз.
<br />
1) Введите имя своего пользователя в форму и нажмите отправить.<br />
2) Вам, на вашу почту, указанную при регистрации придет уведомление с новым паролем.<br />
3) Войдите на сайт под новым паролем.<br />
<input type="text" name="login_back" id="login_back"/>
<input type="submit" onclick="loginBack()"/>
</p>
<span id="login_back_res" style="background-color: green; display: none;"></span>
<script>

	function loginBack() {
		var login = document.getElementById('login_back').value
		jQuery.ajax({
								type: 'POST',
							    url: '?task=login&action=login_back', 
							    data: 'login=' + login, 
							    success: function(html) { 
									document.getElementById('login_back_res').style.display = 'block'
									document.getElementById('login_back_res').innerHTML = html
								}
		})
	}

</script>

