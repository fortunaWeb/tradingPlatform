

<p>Вторичка Продажа</p>

<fieldset>
	<legend>Местоположение</legend>
	
	<label for="live_point">Населенный пункт</label>
	<input id="live_point" name="live_point" type="text" required value="<?php if($data_res['live_point']) {echo $data_res['live_point']; } ?>" />
	
	<label for="dis">Район</label>
	<input id="dis" name="dis" type="text" required  value="<?php if($data_res['dis']) {echo $data_res['dis']; } ?>" />
	
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
			Количество комнат
		</div>
		
		
		<input id="k" value="18"  type="radio" class="invisible" <?php if($data_res['type_id'] == 18) echo "checked"; ?>  name="type_id" required /> 
		<label id="label" for="k">Комната</label>
		
		<input id="k-1" value="19"  type="radio" class="invisible" <?php if($data_res['type_id'] == 19) echo "checked"; ?> name="type_id" required /> 
		<label id="label" for="k-1">1-к</label>
		
		<input id="k-2" value="20"  type="radio" class="invisible" <?php if($data_res['type_id'] == 20) echo "checked"; ?> name="type_id" required /> 
		<label id="label" for="k-2">2-к</label>
		
		<input id="k-3" value="21"  type="radio" class="invisible" <?php if($data_res['type_id'] == 21) echo "checked"; ?> name="type_id" required /> 
		<label id="label" for="k-3">3-к</label>
		
		<input id="k-4" value="22"  type="radio" class="invisible" <?php if($data_res['type_id'] == 22) echo "checked"; ?> name="type_id" required /> 
		<label id="label" for="k-4">4-к</label>
		
		<input id="k-5" value="23"  type="radio" class="invisible" <?php if($data_res['type_id'] == 23) echo "checked"; ?> name="type_id" required /> 
		<label id="label" for="k-5">5-к</label>
		
		<input id="k-6" value="24"  type="radio" class="invisible" <?php if($data_res['type_id'] == 24) echo "checked"; ?> name="type_id" required /> 
		<label id="label" for="k-6">6-к +</label>
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
		<label class="control-label" id="ap_layout">Тип квартиры</label>
		
			<select class="controls-select" name="ap_layout" id="ap_layout" >
				<option value="общежитие" <?php if($data_res['ap_layout'] == "общежитие") echo "selected"; ?> >общежитие</option>
				<option value="малосемейка" <?php if($data_res['ap_layout'] == "малосемейка") echo "selected"; ?> >малосемейка</option>
				<option value="улучшеная планировка" <?php if($data_res['ap_layout'] == "улучшеная планировка") echo "selected"; ?> >улучшеная планировка</option>
				<option value="типовая" <?php if($data_res['ap_layout'] == "типовая") echo "selected"; ?> >типовая</option>
				<option value="хрещевка" <?php if($data_res['ap_layout'] == "хрещевка") echo "selected"; ?> >хрещевка</option>
				<option value="полногабаритная" <?php if($data_res['ap_layout'] == "полногабаритная") echo "selected"; ?> >полногабаритная</option>
				<option value="малоэтажка" <?php if($data_res['ap_layout'] == "малоэтажка") echo "selected"; ?> >малоэтажка</option>
				<option value="пентхаус" <?php if($data_res['ap_layout'] == "пентхаус") echo "selected"; ?> >пентхаус</option>
				<option value="двухуровневая" <?php if($data_res['ap_layout'] == "двухуровневая") echo "selected"; ?> >двухуровневая</option>
				
			
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
				
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="val_bal">Количество балконов</label>
		<input id="val_bal" name="val_bal" type="text"  value="<?php if($data_res['val_bal']) {echo $data_res['val_bal']; } ?>" /> 
		
		<label class="control-label" id="val_lodg">Количество лоджий</label>
		<input id="val_lodg" name="val_lodg" type="text" value="<?php if($data_res['val_lodg']) {echo $data_res['val_lodg']; } ?>"  /> 
		
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
			Этаж / Этажность
		</div>
		
		<input id="floor" name="floor" type="text" value="<?php if($data_res['floor']) echo $data_res['floor']; ?>" /> / 
		
		<input id="floor_count" name="floor_count" type="text" value="<?php if($data_res['floor_count']) echo $data_res['floor_count']; ?>" />
	</div>
	
	<div class="control-group">
		<label class="control-label" id="wall_type">Материал стен</label>
		
			<select class="controls-select" name="wall_type" id="wall_type" >
				<option value="кирпичный" <?php if($data_res['wall_type'] == 'кирпичный') echo "selected"; ?> >кирпичный</option>
				<option value="панельный" <?php if($data_res['wall_type'] == 'панельный') echo "selected"; ?> >панельный</option>
				<option value="деревянный" <?php if($data_res['wall_type'] == 'деревянный') echo "selected"; ?> >деревянный</option>
				<option value="монолит" <?php if($data_res['wall_type'] == 'монолит') echo "selected"; ?> >монолит</option>
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
		
	</div>
	
</fieldset>

