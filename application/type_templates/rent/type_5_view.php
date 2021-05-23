<?php

?>

<p>Земля Аренда</p>

<fieldset>
	<legend>Местоположение</legend>
	
	<label for="live_point">Р-н области</label>
	<input id="live_point" name="live_point" type="text" required  value="<?php if($data_res['live_point']) {echo $data_res['live_point']; } ?>"  />
	
	<label for="dis">Населенный пункт</label>
	<input id="dis" name="dis" type="text" value="<?php if($data_res['dis']) {echo $data_res['dis']; } ?>" />
	
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($data_res['orientir']) {echo $data_res['orientir']; } ?>" />
	
</fieldset>

<fieldset>
	<legend>Описание Объекта</legend>
	
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Тип
		</div>
		
		
		<input id="k" value="32"  type="radio" class="invisible"  name="type_id" required  <?php if($data_res['type_id'] == 32) echo "checked"; ?> /> 
		<label id="label" for="k">Земельный участок</label>
		
		<input id="k-1" value="33"  type="radio" class="invisible"  name="type_id" required  <?php if($data_res['type_id'] == 33) echo "checked"; ?> /> 
		<label id="label" for="k-1">Землеотвод</label>
		
		<input id="k-1" value="34"  type="radio" class="invisible"  name="type_id" required  <?php if($data_res['type_id'] == 34) echo "checked"; ?> /> 
		<label id="label" for="k-1">Коммерческая земля</label>

	</div>
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Площадь
		</div>
		
		<label for="sq_land">Площадь участка</label>
		<input id="sq_land" name="sq_land" type="text" value="<?php if($data_res['sq_land']) {echo $data_res['sq_land']; } ?>" />
		<span>1 гектар = 100 соток</span>
		
	</div>

</fieldset>

<fieldset>
	<legend>Комментарии</legend>
	
	<textarea id="text" name="text" rows="10" cols="70"><?php if ($data_res['text']) echo $data_res['text']; ?></textarea> <br />
	<label for="var_code">код варианта</label>
	<input id="var_code" name="var_code" value="<?php if ($data_res['var_code']) echo $data_res['var_code']; ?>" />
</fieldset>

<fieldset>
	<legend>Цена и условия</legend>
			
		
		<label for="price">Цена</label>
		<input id="price" name="price" type="text" value="<?php if ($data_res['price']) echo $data_res['price']; ?>" /> 
		
		<label for="torg">Торг</label>
		<input id="torg" name="torg" type="checkbox" <?php if($data_res['torg'] == 'on') echo "checked"; ?>/> 
		
	
</fieldset>

