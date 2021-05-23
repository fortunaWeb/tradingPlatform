<?php

?>

<p>Дача Аренда</p>

<fieldset>
	<legend>Местоположение</legend>
	
	<label for="live_point">Р-н области</label>
	<input id="live_point" name="live_point" type="text" required  value="<?php if($data_res['live_point']) {echo $data_res['live_point']; } ?>"  />
	
	<label for="dis">Населенный пункт</label>
	<input id="dis" name="dis" type="text" required value="<?php if($data_res['dis']) {echo $data_res['dis']; } ?>" />
	
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($data_res['orientir']) {echo $data_res['orientir']; } ?>" />
	
</fieldset>

<fieldset>
	<legend>Описание Объекта</legend>
	
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Тип
		</div>
		
		
		<input id="k" value="30"  type="radio" class="invisible"  name="type_id" required  <?php if($data_res['type_id'] == 30) echo "checked"; ?> /> 
		<label id="label" for="k">Дача</label>
		
		<input id="k-1" value="31"  type="radio" class="invisible"  name="type_id" required  <?php if($data_res['type_id'] == 31) echo "checked"; ?> /> 
		<label id="label" for="k-1">Садовый участок</label>

	</div>
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Площадь
		</div>
		<label for="sq_all">Общая</label>
		<input id="sq_all" name="sq_all" type="text" value="<?php if($data_res['sq_all']) {echo $data_res['sq_all']; } ?>" />
		
		<label for="sq_land">Площадь участка</label>
		<input id="sq_land" name="sq_land" type="text" value="<?php if($data_res['sq_land']) {echo $data_res['sq_land']; } ?>" />
	</div>

	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Туалет
		</div>
		<input id="wc_typeyes" value="1"  type="radio" class="invisible"  name="wc_type"  <?php if($data_res['wc_type'] == 1) echo "checked"; ?> /> 
		<label id="label" for="wc_typeyes">есть</label>
		
		<input id="wc_typeno" value="0"  type="radio" class="invisible"  name="wc_type"  <?php if($data_res['wc_type'] == 0) echo "checked"; ?> /> 
		<label id="label" for="wc_typeno">нету</label>
	</div>

	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Электричество
		</div>
		<input id="elecyes" value="1"  type="radio" class="invisible"  name="elec"  <?php if($data_res['elec'] == 1) echo "checked"; ?> /> 
		<label id="label" for="elecyes">есть</label>
		
		<input id="elecno" value="0"  type="radio" class="invisible"  name="elec"  <?php if($data_res['elec'] == 0) echo "checked"; ?> /> 
		<label id="label" for="elecno">нету</label>
	</div>
	
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Вода
		</div>
		<input id="wateryes" value="1"  type="radio" class="invisible"  name="water"  <?php if($data_res['water'] == 1) echo "checked"; ?> /> 
		<label id="label" for="wateryes">есть</label>
		
		<input id="waterno" value="0"  type="radio" class="invisible"  name="water"  <?php if($data_res['water'] == 0) echo "checked"; ?> /> 
		<label id="label" for="waterno">нету</label>
	</div>
	
	<div>

	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Посадки
		</div>
		<input id="posadkiyes" value="1"  type="radio" class="invisible"  name="posadki"  <?php if($data_res['posadki'] == 1) echo "checked"; ?> /> 
		<label id="label" for="posadkiyes">есть</label>
		
		<input id="posadkino" value="0"  type="radio" class="invisible"  name="posadki"  <?php if($data_res['posadki'] == 0) echo "checked"; ?> /> 
		<label id="label" for="posadkino">нету</label>
	</div>
	
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Теплица
		</div>
		<input id="grhouseyes" value="1"  type="radio" class="invisible"  name="grhouse"  <?php if($data_res['grhouse'] == 1) echo "checked"; ?> /> 
		<label id="label" for="grhouseyes">есть</label>
		
		<input id="grhouseno" value="0"  type="radio" class="invisible"  name="grhouse"  <?php if($data_res['grhouse'] == 0) echo "checked"; ?> /> 
		<label id="label" for="grhouseno">нету</label>
	</div>
	
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Баня
		</div>
		<input id="banyayes" value="1"  type="radio" class="invisible"  name="banya"  <?php if($data_res['banya'] == 1) echo "checked"; ?> /> 
		<label id="label" for="banyayes">есть</label>
		
		<input id="banyano" value="0"  type="radio" class="invisible"  name="banya"  <?php if($data_res['banya'] == 0) echo "checked"; ?> /> 
		<label id="label" for="banyano">нету</label>
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

