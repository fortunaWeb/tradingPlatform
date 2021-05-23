<?php

?>

<p>Коттедж-дом Продажа</p>

<fieldset>
	<legend>Местоположение</legend>
	
	<label for="live_point">Населенный пункт</label>
	<input id="live_point" name="live_point" type="text" required  value="<?php if($data_res['live_point']) {echo $data_res['live_point']; } ?>"  />
	
	<label for="dis">Район</label>
	<input id="dis" name="dis" type="text" required value="<?php if($data_res['dis']) {echo $data_res['dis']; } ?>" />
	
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
		
		
		<input id="k" value="25"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 25) echo "checked"; ?> /> 
		<label id="label" for="k">Дом</label>
		
		<input id="k-1" value="26"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 26) echo "checked"; ?> /> 
		<label id="label" for="k-1">Часть дома</label>
		
		<input id="k-2" value="27"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 27) echo "checked"; ?> /> 
		<label id="label" for="k-2">Коттедж</label>
		
		<input id="k-3" value="28"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 28) echo "checked"; ?> /> 
		<label id="label" for="k-3">Часть коттеджа</label>
		
		<input id="k-4" value="29"  type="radio" class="invisible"  name="type_id" required <?php if($data_res['type_id'] == 29) echo "checked"; ?> /> 
		<label id="label" for="k-4">Таунхаус</label>

	</div>
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Площадь
		</div>
		<label for="sq_all">Общая</label>
		<input id="sq_all" name="sq_all" type="text" value="<?php if($data_res['sq_all']) {echo $data_res['sq_all']; } ?>" /> / 
		<label for="sq_live">Жилая</label>
		<input id="sq_live" name="sq_live" type="text" value="<?php if($data_res['sq_live']) {echo $data_res['sq_live']; } ?>" /> / 
		<label id="sq_k" for="sq_k">Кухня</label>
		<input id="sq_k" name="sq_k" type="text" value="<?php if($data_res['sq_k']) {echo $data_res['sq_k']; } ?>" />
	</div>
	
	<div class="control-group">
		<label class="control-label" id="planning">Планировка</label>
		
			<select class="controls-select" name="planning" id="planning" >
				<option value="изолированная" <?php if($data_res['planning'] == "изолированная") echo "selected"; ?> >изолированная</option>
				<option value="смежная" <?php if($data_res['planning'] == "смежная") echo "selected"; ?> >смежная</option>
				<option value="см-изолированная" <?php if($data_res['planning'] == "см-изолированная") echo "selected"; ?> >см-изолированная</option>
				<option value="свободная" <?php if($data_res['planning'] == "свободная") echo "selected"; ?> >свободная</option>
				<option value="студия" <?php if($data_res['planning'] == "студия") echo "selected"; ?> >студия</option>
				<option value="иное" <?php if($data_res['planning'] == "иное") echo "selected"; ?> >иное</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="ap_layout">Количество комнат</label>
		
			<select class="controls-select" name="ap_layout" id="ap_layout" >
				<option value="1" <?php if($data_res['ap_layout'] == "1") echo "selected"; ?> >1</option>
				<option value="2" <?php if($data_res['ap_layout'] == "2") echo "selected"; ?> >2</option>
				<option value="3" <?php if($data_res['ap_layout'] == "3") echo "selected"; ?> >3</option>
				<option value="4" <?php if($data_res['ap_layout'] == "4") echo "selected"; ?> >4</option>
				<option value="5" <?php if($data_res['ap_layout'] == "5") echo "selected"; ?> >5</option>
				<option value="6+" <?php if($data_res['ap_layout'] == "6+") echo "selected"; ?> >6+</option>
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="wc_type">Санузел</label>
		
			<select class="controls-select" name="wc_type" id="wc_type" >
				<option value="раздельный" <?php if($data_res['wc_type'] == "раздельный") echo "selected"; ?> >раздельный</option>
				<option value="совмещенный" <?php if($data_res['wc_type'] == "совмещенный") echo "selected"; ?> >совмещенный</option>
				<option value="без удобств" <?php if($data_res['wc_type'] == "без удобств") echo "selected"; ?> >без удобств</option>
				<option value="ванна" <?php if($data_res['wc_type'] == "ванна") echo "selected"; ?> >ванна</option>
				<option value="душ" <?php if($data_res['wc_type'] == "душ") echo "selected"; ?> >душ</option>
				<option value="2 санузла" <?php if($data_res['wc_type'] == "2 санузла") echo "selected"; ?> >2 санузла</option>
				<option value="3 санузла" <?php if($data_res['wc_type'] == "3 санузла") echo "selected"; ?> >3 санузла</option>
				<option value="на улице" <?php if($data_res['wc_type'] == "на улице") echo "selected"; ?> >на улице</option>
				
			</select>
		
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
	
	<div class="control-group">
		<label class="control-label" id="own_type">Форма собственности</label>
		
			<select class="controls-select" name="own_type" id="own_type" >
				<option value="частная" <?php if($data_res['own_type'] == 'частная') echo "selected"; ?> >частная</option>
				<option value="государственная" <?php if($data_res['own_type'] == 'государственная') echo "selected"; ?> >государственная</option>
				<option value="кооперативная" <?php if($data_res['own_type'] == 'кооперативная') echo "selected"; ?> >кооперативная</option>
				<option value="не оформлено" <?php if($data_res['own_type'] == 'не оформлено') echo "selected"; ?> >не оформлено</option>
			</select>
		
	</div>
	
	
	<div class="control-group">
		<label class="control-label" id="park">Парковка/гараж</label>
		
			<select class="controls-select" name="park" id="park" >
				<option value="Благоустроенная парковка у дома" <?php if($data_res['park'] == 'частная') echo "selected"; ?> >Благоустроенная парковка у дома</option>
				<option value="Парковка со шлагбаумом" <?php if($data_res['park'] == 'Парковка со шлагбаумом') echo "selected"; ?> >Парковка со шлагбаумом</option>
				<option value="Подземный гараж" <?php if($data_res['park'] == 'Подземный гараж') echo "selected"; ?> >Подземный гараж</option>
				<option value="Подземная парковка" <?php if($data_res['park'] == 'Подземная парковка') echo "selected"; ?> >Подземная парковка</option>
			</select>
		
	</div>
	
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Этажность
		</div>
		
		<input id="floor_count" name="floor_count" type="text" value="<?php if($data_res['floor_count']) echo $data_res['floor_count']; ?>" />
	</div>
	

	
	<div class="control-group">
		<label class="control-label" id="wall_type">Материал стен</label>
		
			<select class="controls-select" name="wall_type" id="wall_type" >
				<select class="controls-select" name="wall_type" id="wall_type" >
				<option value="кирпичный" <?php if($data_res['wall_type'] == 'кирпичный') echo "selected"; ?> >кирпичный</option>
				<option value="панельный" <?php if($data_res['wall_type'] == 'панельный') echo "selected"; ?> >панельный</option>
				<option value="деревянный" <?php if($data_res['wall_type'] == 'деревянный') echo "selected"; ?> >деревянный</option>
				<option value="монолит" <?php if($data_res['wall_type'] == 'монолит') echo "selected"; ?> >монолит</option>
			</select>
				<option value="сибит" <?php if($data_res['wall_type'] == 'сибит') echo "selected"; ?> >сибит</option>
				<option value="шлакоблок" <?php if($data_res['wall_type'] == 'шлакоблок') echo "selected"; ?> >шлакоблок</option>
				<option value="пенобетон" <?php if($data_res['wall_type'] == 'пенобетон') echo "selected"; ?> >пенобетон</option>
			</select>
		
	</div>
	
	<div class="control-group checklabel switch_buy_rent">
		<div class="header-3">
			Электричество
		</div>
		<input id="elecyes" value="1"  type="radio" class="invisible"  name="elec" <?php if($data_res['elec'] == 1) echo "checked"; ?> /> 
		<label id="label" for="elecyes">есть</label>
		
		<input id="elecno" value="0"  type="radio" class="invisible"  name="elec" <?php if($data_res['elec'] == 0) echo "checked"; ?> /> 
		<label id="label" for="elecno">нету</label>
	</div>
	
	<div>	
	<label for="water">Вода</label>
		<select class="controls-select" name="water" id="water" >
				<option value="есть" <?php if($data_res['water'] == 'есть') echo "selected"; ?> >есть</option>
				<option value="нету" <?php if($data_res['water'] == 'нету') echo "selected"; ?> >нету</option>
				<option value="автономное" <?php if($data_res['water'] == 'автономное') echo "selected"; ?> >автономное</option>
				<option value="центральное" <?php if($data_res['water'] == 'центральное') echo "selected"; ?> >центральное</option>
		</select>
	</div>
	
	<div>
	<label for="gas">Газ</label>
		<select class="controls-select" name="gas" id="gas" >
				<option value="есть" <?php if($data_res['gas'] == 'есть') echo "selected"; ?> >есть</option>
				<option value="нету" <?php if($data_res['gas'] == 'нету') echo "selected"; ?> >нету</option>
				<option value="автономное" <?php if($data_res['gas'] == 'автономное') echo "selected"; ?> >автономное</option>
				<option value="центральное" <?php if($data_res['gas'] == 'центральное') echo "selected"; ?> >центральное</option>
		</select>
	</div>
	
	<div>
	<label for="heating">Отопление</label>
		<select class="controls-select" name="heating" id="heating" >
				<option value="есть" <?php if($data_res['heating'] == 'есть') echo "selected"; ?>  >есть</option>
				<option value="нету" <?php if($data_res['heating'] == 'нету') echo "selected"; ?> >нету</option>
				<option value="автономное" <?php if($data_res['heating'] == 'автономное') echo "selected"; ?> >автономное</option>
				<option value="центральное" <?php if($data_res['heating'] == 'центральное') echo "selected"; ?> >центральное</option>
		</select>
	</div>
	
	<div>	
	<label for="heating_type">Тип отопления</label>
		<select class="controls-select" name="heating_type" id="heating_type" >
				<option value="водяное" <?php if($data_res['heating_type'] == 'водяное') echo "selected"; ?>  >водяное</option>
				<option value="газовое" <?php if($data_res['heating_type'] == 'газовое') echo "selected"; ?> >газовое</option>
				<option value="паровое" <?php if($data_res['heating_type'] == 'паровое') echo "selected"; ?> >паровое</option>
				<option value="печное" <?php if($data_res['heating_type'] == 'печное') echo "selected"; ?> >печное</option>
				<option value="печное-водяное" <?php if($data_res['heating_type'] == 'печное-водяное') echo "selected"; ?> >печное-водяное</option>
				<option value="элекстрическое" <?php if($data_res['heating_type'] == 'элекстрическое') echo "selected"; ?> >элекстрическое</option>
	
		</select>
	</div>
	
	<div>	
	<label for="sewage">Канализация</label>
		<select class="controls-select" name="sewage" id="sewage" >
				<option value="есть" <?php if($data_res['sewage'] == 'есть') echo "selected"; ?>  >есть</option>
				<option value="нету" <?php if($data_res['sewage'] == 'нету') echo "selected"; ?> >нету</option>
				<option value="автономная" <?php if($data_res['sewage'] == 'автономная') echo "selected"; ?> >автономная</option>
				<option value="центральная" <?php if($data_res['sewage'] == 'центральная') echo "selected"; ?> >центральная</option>
		</select>
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

