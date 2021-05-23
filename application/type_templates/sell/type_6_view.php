<?php

?>

<p>Гараж/парковка Продажа</p>

<fieldset>
	<legend>Местоположение</legend>
	
	<label for="live_point">Населенный пункт</label>
	<input id="live_point" name="live_point" type="text" required  value="<?php if($data_res['live_point']) {echo $data_res['live_point']; } ?>"  />
	
	<label for="dis">Район</label>
	<input id="dis" name="dis" type="text" value="<?php if($data_res['dis']) {echo $data_res['dis']; } ?>" />
	
	
	<label for="str">Улица</label>
	<input type="text" id="str" name="street" style="background: #F2D7E7;" required value="<?php if($data_res['street']) {echo $data_res['street']; } ?>"  
					
					 autocomplete="off"/> 
					 <span style="background: white; padding: 3px; border: 1px solid grey;" id="str_button" placeholder="Поиск">Поиск</span>
				
					<span id="indicator" style="height:11px; display:none;">
					</span>
					<div id="street_choices" class="autocomplete" style="height:auto; display:none; height: auto; margin-left: 2%;" >
					</div>
	
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($data_res['orientir']) {echo $data_res['orientir']; } ?>" />
	
</fieldset>

<fieldset>
	<legend>Описание Объекта</legend>
	
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Тип
		</div>
	
		
		<input id="k" value="35"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 35) echo "checked"; ?> /> 
		<label id="label" for="k">капитальный</label>
		
		<input id="k-1" value="36"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 36) echo "checked"; ?> /> 
		<label id="label" for="k-1">металлический</label>
		
		<input id="k-2" value="37"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 37) echo "checked"; ?> /> 
		<label id="label" for="k-2">парковочное место</label>
		
		<input id="k-3" value="38"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 38) echo "checked"; ?> /> 
		<label id="label" for="k-3">овощехранилище</label>
		
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
		
		<label for="chist_prod">Чистая продажа</label>
		<input id="chist_prod" name="chist_prod" type="checkbox" <?php if($data_res['chist_prod'] == 'on') echo "checked"; ?>/> 
		
		<label for="obmen">Обмен</label>
		<input id="obmen" name="obmen" type="checkbox" <?php if($data_res['obmen'] == 'on') echo "checked"; ?>/> 
		
		<label for="ipoteka">Ипотека</label>
		<input id="ipoteka" name="ipoteka" type="checkbox" <?php if($data_res['ipoteka'] == 'on') echo "checked"; ?>/> 
	
</fieldset>

