
<div class="info">
	<div class="row">
		<div class="col-xs-12">
			<legend>Местоположение</legend>
		</div>
		<div class="col-xs-2">
			<input type="text" name="live_point" class="form-control" placeholder="Введите город" required 
			value="<?php if($data_res['live_point']) { echo $data_res['live_point']; }else{echo 'Новосибирск';} ?>">										
		</div>
		<div class="col-xs-2">
			<input type="text" class="form-control" placeholder="Район"  name="dis" type="text" required 
			value="<?php if($data_res['dis']) {echo $data_res['dis']; } ?>">
		</div>
		<div class="col-xs-2">
			<input type="text" id="str" name="street" class="form-control" placeholder="Улица" required 
			value="<?php if($data_res['street']) {echo $data_res['street']; } ?>">
		</div>
		<div class="col-xs-1">
			<input type="text" name="house" class="form-control" placeholder="Дом"  
			value="<?php if($data_res['house']) {echo $data_res['house']; } ?>">
		</div>
		<div class="col-xs-2">
			<input type="text" name="orientir" class="form-control" placeholder="Ориентир"  
			 value="<?php if($data_res['orientir']) {echo $data_res['orientir']; } ?>">
		</div>
	</div>	
</div>

<div class="info">
	<div class="row">
		<div class="col-xs-12">
			<legend>Описание Объекта</legend>
		</div>			
		<div class="col-xs-4">
			<div class="btn-group medium toggle">
				<button type="button" class="btn btn-default
					<?php if($data_res['type_id'] == 8) echo " active"; ?>" 
					value="8" name="type_id" value="8" onClick="$(this).toggleClass('active')">комната
				</button>
				<button type="button" class="btn btn-default
					<?php if($data_res['type_id'] == 9) echo " active"; ?>" 
					value="9" name="type_id" value="9">1-к
				</button>
				<button type="button" class="btn btn-default
					<?php if($data_res['type_id'] == 10) echo " active"; ?>" 
					value="10" name="type_id" value="10">2-к
				</button>
				<button type="button" class="btn btn-default
					<?php if($data_res['type_id'] == 11) echo " active"; ?>" 
					value="11" name="type_id" value="11">3-к
				</button>
				<button type="button" class="btn btn-default
					<?php if($data_res['type_id'] == 15) echo " active"; ?>" 
					value="15" name="type_id" value="15">4-к
				</button>
				<button type="button" class="btn btn-default
					<?php if($data_res['type_id'] == 16) echo " active"; ?>" 
					value="16" name="type_id" value="16">5-к
				</button>
				<button type="button" class="btn btn-default
					<?php if($data_res['type_id'] == 17) echo " active"; ?>" 
					value="17" name="type_id" value="17">6-к+
				</button>
			</div> 
		</div>	
		<div class="col-xs-3">			
			<div class="input-group interval">
				<span class="input-group-addon">Площадь</span>
				<input type="text" id="sq_all" name="sq_all" class="form-control" placeholder="общ."  size="3" maxlength="3"  value="<?php if($data_res['sq_all']) {echo $data_res['sq_all']; } ?>">
				<input type="text" id="sq_live" name="sq_live" class="form-control" placeholder="жил." size="3" maxlength="3"  value="<?php if($data_res['sq_all']) {echo $data_res['sq_live']; } ?>">
				<input type="text" id="sq_k" name="sq_k" class="form-control" placeholder="кух." size="3" maxlength="3"  value="<?php if($data_res['sq_all']) {echo $data_res['sq_k']; } ?>">
			</div>	
		</div>
		<div class="col-xs-2">
			<select class="form-control" name="ap_layout" >
				<option value="">тип квартиры</option>
				<option value="общежитие" <?php if($data_res['ap_layout'] == "общежитие") echo "selected"; ?>>
					Общежитие
				</option>
				<option value="малосемейка" <?php if($data_res['ap_layout'] == "малосемейка") echo "selected"; ?>>
					Малосемейка
				</option>
				<option value="улучшеная планировка" <?php if($data_res['ap_layout'] == "улучшеная планировка") echo "selected"; ?>>
					Улучшеная планировка
				</option>
				<option value="типовая" <?php if($data_res['ap_layout'] == "типовая") echo "selected"; ?>>
					Типовая
				</option>
				<option value="хрещевка" <?php if($data_res['ap_layout'] == "хрещевка") echo "selected"; ?>>
					Хрущевка
				</option>
				<option value="полногабаритная" <?php if($data_res['ap_layout'] == "полногабаритная") echo "selected"; ?>>
					Полногабаритная
				</option>
				<option value="малоэтажка" 
					<?php if($data_res['ap_layout'] == "малоэтажка") echo "selected"; ?>>
					Малоэтажка
				</option>
				<option value="пентхаус" <?php if($data_res['ap_layout'] == "пентхаус") echo "selected"; ?>>
					Пентхаус
				</option>
				<option value="двухуровневая" <?php if($data_res['ap_layout'] == "двухуровневая") echo "selected"; ?>>
					Двухуровневая
				</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2">
			<select class="form-control"  name="planning" >
				<option value="">планировка</option>
				<option value="изолированная" <?php if($data_res['planning'] == "изолированная") echo "selected"; ?>>
					Изолированная
				</option>
				<option value="смежная" <?php if($data_res['planning'] == "смежная") echo "selected"; ?>>
					Смежная
				</option>
				<option value="см-изолированная" <?php if($data_res['planning'] == "см-изолированная") echo "selected"; ?>>
					См-изолированная
				</option>
				<option value="свободная" <?php if($data_res['planning'] == "свободная") echo "selected"; ?>>
					Свободная
				</option>
				<option value="студия" <?php if($data_res['planning'] == "студия") echo "selected"; ?>>
					Студия
				</option>
				<option value="иное" <?php if($data_res['planning'] == "иное") echo "selected"; ?>>
					Иное
				</option>
			</select>
		</div>		
		<div class="col-xs-2">
			<select class="form-control" name="wc_type" >
				<option value="">санузел</option>
				<option value="раздельный" <?php if($data_res['wc_type'] == "раздельный") echo "selected"; ?>>
					Раздельный
				</option>
				<option value="совмещенный" <?php if($data_res['wc_type'] == "совмещенный") echo "selected"; ?>>
					Совмещенный
				</option>
				<option value="без удобств" <?php if($data_res['wc_type'] == "без удобств") echo "selected"; ?>>
					Без удобств
				</option>
				<option value="ванна" <?php if($data_res['wc_type'] == "ванна") echo "selected"; ?>>
					Ванна
				</option>
				<option value="душ" <?php if($data_res['wc_type'] == "душ") echo "selected"; ?>>
					Душ
				</option>
				<option value="2 санузла" <?php if($data_res['wc_type'] == "2 санузла") echo "selected"; ?>>
					2 санузла
				</option>
				<option value="3 санузла" <?php if($data_res['wc_type'] == "3 санузла") echo "selected"; ?>>
					3 санузла
				</option>
			</select>
		</div>
		<div class="col-xs-3">
			<div class="input-group interval">
				<span class="input-group-addon">Балконов/лоджий</span>
				<input type="text" id="val_bal" name="val_bal"  class="form-control" placeholder="кол.">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-8">
			<div class="btn-group medium multi-active">
				<button type="button" name="inet" class="btn btn-default <?php if($data_res['conditioner'] == 1) echo "active"; ?>">
					Интернет
				</button>
				<button type="button" name="furn" class="btn btn-default <?php if($data_res['furn'] == 1) echo "active"; ?>">
					Мебель
				</button>
				<button type="button" name="tv" class="btn btn-default <?php if($data_res['tv'] == 1) echo "active"; ?>">
					Телевизор
				</button>
				<button type="button" name="washing" class="btn btn-default <?php if($data_res['washing'] == 1) echo "active"; ?>">
					Стиральная машина
				</button>
				<button type="button" name="refrig" class="btn btn-default <?php if($data_res['refrig'] == 1) echo "active"; ?>">
					Холодильник
				</button>
				<button type="button" name="conditioner" class="btn btn-default <?php if($data_res['conditioner'] == 1) echo "active"; ?>">
					Кондиционер
				</button>				
			</div> 
		</div>	
		<div class="col-xs-3">
			<select class="form-control" name="park" id="park">
				<option value="">парковка/гараж</option>
				<option value="благоустроенная парковка у дома" <?php if($data_res['park'] == 'частная') echo "selected"; ?>>
					Благоустроенная парковка у дома
				</option>
				<option value="парковка со шлагбаумом" <?php if($data_res['park'] == 'парковка со шлагбаумом') echo "selected"; ?>>
					Парковка со шлагбаумом
				</option>
				<option value="подземный гараж" <?php if($data_res['park'] == 'подземный гараж') echo "selected"; ?>>
					Подземный гараж
				</option>
				<option value="подземная парковка" <?php if($data_res['park'] == 'подземная парковка') echo "selected"; ?>>
					Подземная парковка
				</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-3">	
			<div class="input-group interval" style="display:flex;">		
				<span class="input-group-addon">Этаж/этажность</span>			
				
				<input type="text" id="floor" name="floor" class="form-control" placeholder=""  size="3" maxlength="3" value="<?php if($data_res['floor']) echo $data_res['floor']; ?>">
				
				<span class="input-group-addon xs" id="sq_live2">/</span>
				
				<input type="text" name="floor_count" class="form-control" placeholder="" size="3" maxlength="3" value="<?php if($data_res['floor_count']) echo $data_res['floor_count']; ?>">	
			</div>
		</div>	
		<div class="col-xs-2">
			<select class="form-control" name="wall_type" id="wall_type">
				<option value="">материал стен</option>
				<option value="кирпичный" <?php if($data_res['wall_type'] == 'кирпичный') echo "selected"; ?>>
					Кирпичный
				</option>
				<option value="панельный" <?php if($data_res['wall_type'] == 'панельный') echo "selected"; ?>>
					Панельный
				</option>
				<option value="деревянный"<?php if($data_res['wall_type'] == 'деревянный') echo "selected"; ?>>
					Деревянный
				</option>
				<option value="монолит"<?php if($data_res['wall_type'] == 'монолит') echo "selected"; ?>>
					Монолит
				</option>
			</select>
		</div>
	</div>
</div>

<div class="col-xs-12">
	<div class="col-xs-6">
		<div class="info">
			<legend>Комментарии</legend>
			
			<textarea id="text" name="text"  class="form-control" rows="5" cols="70"><?php if ($data_res['text']) echo $data_res['text']; ?></textarea> <br />
			<div class="row">
				<div class="col-xs-6">
					<input id="var_code" name="var_code" class="form-control" placeholder="Код варианта" value="<?php if ($data_res['var_code']) echo $data_res['var_code']; ?>" />
				</div>
			</div>
		</div>	
	</div>
	<div class="col-xs-6">
		<div class="row info">
		<legend>Цена и условия</legend>
			<div class="col-xs-7">
				<div class="input-group interval xl">				
					<input id="price" placeholder="Цена" name="price" type="text"  class="form-control" value="<?php if ($data_res['price']) echo $data_res['price']; ?>" /> 	
					<span class="input-group-addon xm">за</span>			
					<select class="form-control" name="rent_type" id="rent_type" >
						<option value="месяц"  <?php if($data_res['rent_type'] == 'месяц') echo "selected"; ?> >месяц</option>
						<option value="сутки"  <?php if($data_res['rent_type'] == 'сутки') echo "selected"; ?> >сутки</option>
						<option value="час"  <?php if($data_res['rent_type'] == 'час') echo "selected"; ?> >час</option>
					</select>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="checkbox">			
					<label>
						<input id="torg" name="torg" type="checkbox" <?php if($data_res['torg'] == 'on') echo "checked"; ?>/>
						Торг				
					</label>
				</div>
			</div>
		</div>			
	</div>	
</div>
	



