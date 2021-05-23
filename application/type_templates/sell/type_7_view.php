<?php

?>

<p>Коммерческая Продажа</p>

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
	
	<label for="house">№</label>
	<input id="house" name="house" type="text" value="<?php if($data_res['house']) {echo $data_res['house']; } ?>" />
	
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($data_res['orientir']) {echo $data_res['orientir']; } ?>" />
	
</fieldset>

<fieldset>
	<legend>Описание Объекта</legend>
	
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Тип
		</div>
		
		
		<input id="k" value="39"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 39) echo "checked"; ?> /> 
		<label id="label" for="k">бизнес-центр</label>
		
		<input id="k-1" value="40"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 40) echo "checked"; ?> /> 
		<label id="label" for="k-1">готовый бизнес</label>
		
		<input id="k-2" value="41"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 41) echo "checked"; ?> /> 
		<label id="label" for="k-2">отдельно строящиеся здание</label>
		<br /><br />
		<input id="k-3" value="42"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 42) echo "checked"; ?> /> 
		<label id="label" for="k-3">офисное помещение</label>
		
		<input id="k-4" value="43"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 43) echo "checked"; ?> /> 
		<label id="label" for="k-4">производственное помещение</label>
		
		<input id="k-5" value="44"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 44) echo "checked"; ?> /> 
		<label id="label" for="k-5">складское помещение</label>
		<br /><br />
		<input id="k-6" value="45"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 45) echo "checked"; ?> /> 
		<label id="label" for="k-6">производственно-складское помещение</label>
		
		<input id="k-7" value="46"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 46) echo "checked"; ?> /> 
		<label id="label" for="k-7">торговая площадь</label>
		
		<input id="k-8" value="47"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 47) echo "checked"; ?> /> 
		<label id="label" for="k-8">универсальное</label>
	</div>
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Площадь
		</div>
		<label for="sq_all">Общая</label>
		<input id="sq_all" name="sq_all" type="text" value="<?php if($data_res['sq_all']) {echo $data_res['sq_all']; } ?>" />
	</div>

	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Телефон
		</div>
		<input id="yes" value="1"  type="radio" class="invisible"  name="tel" <?php if($data_res['tel'] == 1) echo "checked"; ?> /> 
		<label id="label" for="yes">есть</label>
		
		<input id="no" value="0"  type="radio" class="invisible"  name="tel" <?php if($data_res['tel'] == 0) echo "checked"; ?> /> 
		<label id="label" for="no">нету</label>
	</div>
	
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Интернет
		</div>
		<input id="inetyes" value="1"  type="radio" class="invisible"  name="inet" <?php if($data_res['inet'] == 1) echo "checked"; ?> /> 
		<label id="label" for="inetyes">есть</label>
		
		<input id="inetno" value="0"  type="radio" class="invisible"  name="inet" <?php if($data_res['inet'] == 0) echo "checked"; ?> /> 
		<label id="label" for="inetno">нету</label>
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

