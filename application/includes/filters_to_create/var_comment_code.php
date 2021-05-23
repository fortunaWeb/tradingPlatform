<textarea id="text" name="text"  class="form-control" placeholder="описание варианта" rows="5" cols="70"><?php if ($data_res['text']) echo $data_res['text']; ?></textarea> <br />
<textarea id="text" name="hidden_text"  class="form-control" placeholder="скрытое описание, видное только Вам" rows="2" cols="70"><?php if ($data_res['hidden_text']) echo $data_res['hidden_text']; ?></textarea> <br />

<?/*<div class="row">
	<div class="col-xs-6">
		<input id="var_code" name="var_code" class="form-control" placeholder="Код варианта" value="<?php if ($data_res['var_code']) echo $data_res['var_code']; ?>" />
	</div>
</div>*/?>