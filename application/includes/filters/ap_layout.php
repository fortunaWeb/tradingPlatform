<div class="col-xs-1 deployed">	
<?php if($parent == "Квартиры" || $parent == "Новостройки"){ 
	$ap_layout = Helper::FilterVal('ap_layout');?>	
	<label class="signature">тип</label>
	<select class="form-control" name="ap_layout" >
		<option value="">тип квартиры</option>
		<option value="типовая" <?php if($ap_layout == "типовая") echo "selected"; ?>>
			Типовая
		</option>
		<option value="улучшеная планировка" <?php if($ap_layout == "улучшеная планировка") echo "selected"; ?>>
			Улучшеная планировка
		</option>	
		<option value="полногабаритная" <?php if($ap_layout == "полногабаритная") echo "selected"; ?>>
			Полногабаритная
		</option>
		<option value="хрещевка" <?php if($ap_layout == "хрещевка") echo "selected"; ?>>
			Хрущевка
		</option>
		<option value="малосемейка" <?php if($ap_layout == "малосемейка") echo "selected"; ?>>
			Малосемейка
		</option>
		<option value="малоэтажка" 
			<?php if($ap_layout == "малоэтажка") echo "selected"; ?>>
			Малоэтажка
		</option>
		<?php if(isset($_SESSION['post'])) { ?>
		<!--<option value="общежитие" <?php if($_SESSION['post']['ap_layout'] == "общежитие") echo "selected"; ?>>
			Общежитие
		</option>
		<option value="пентхаус" <?php if($_SESSION['post']['ap_layout'] == "пентхаус") echo "selected"; ?>>
			Пентхаус
		</option>
		<option value="двухуровневая" <?php if($_SESSION['post']['ap_layout'] == "двухуровневая") echo "selected"; ?>>
			Двухуровневая
		</option>-->
		<?php } ?>
	</select>			
<?	unset($ap_layout);
	}else{
	$type_id = Helper::FilterVal('type_id');?>
	<label class="signature" style='text-transform: lowercase;'>тип <?php /*(substr($parent, 0, 8)) */?></label>
	<select class="form-control" name="type_id">			
		<?if($parent == "Дома"){?>	
			<option value="">тип дома</option>
			<option value="25" <?php if($type_id == "25") echo "selected"; ?>>
				Дом
			</option>
			<option value="26" <?php if($type_id == "26") echo "selected"; ?>>
				Часть дома
			</option>
			<option value="27" <?php if($type_id == "27") echo "selected"; ?>>
				Коттедж
			</option>
			<option value="28" <?php if($type_id == "28") echo "selected"; ?>>
				Часть коттеджа
			</option>
			<option value="29" <?php if($type_id == "29") echo "selected"; ?>>
				Таунхаус
			</option>					
		<?}else if($_GET['type_id'] == 4 || $parent == "Дачи"){?>	
			<option value="">тип дачи</option>
			<option value="30" <?php if($type_id == "30") echo "selected"; ?>>
				Дачу
			</option>
			<option value="31" <?php if($type_id == "31") echo "selected"; ?>>
				Садовый участок
			</option>
		<?}else if($parent == "Земля"){?>
			<option value="">тип земли</option>
			<option value="32" <?php if($type_id == "32") echo "selected"; ?>>
				Земельный участок
			</option>
			<option value="33" <?php if($type_id == "33") echo "selected"; ?>>
				Землеотвод
			</option>
			<option value="34" <?php if($type_id == "34") echo "selected"; ?>>
				Коммерческая земля
			</option>
		<?}else if ($parent == "Гаражи"){?>
			<option value="">тип гаража</option>
			<option value="35" <?php if($type_id == "35") echo "selected"; ?>>
				Капитальный гараж
			</option>
			<option value="36" <?php if($type_id == "36") echo "selected"; ?>>
				Металлический гараж
			</option>
			<option value="37" <?php if($type_id == "37") echo "selected"; ?>>
				Парковочное место
			</option>
			<option value="38" <?php if($type_id == "38") echo "selected"; ?>>
				Овощехранилище
			</option>			
		<?}else if ($parent == "Коммерческая"){?>
			<option value="">тип недвижимости</option>
			<option value="39" <?php if($type_id == "39") echo "selected"; ?>>
				Бизнес-центр
			</option>
			<option value="40" <?php if($type_id == "40") echo "selected"; ?>>
				Готовый бизнес
			</option>
			<option value="41" <?php if($type_id == "41") echo "selected"; ?>>
				Отдельно строящиеся здание
			</option>
			<option value="42" <?php if($type_id == "42") echo "selected"; ?>>
				Офисное помещение
			</option>
			<option value="43" <?php if($type_id == "43") echo "selected"; ?>>
				Производственное помещение
			</option>
			<option value="44" <?php if($type_id == "44") echo "selected"; ?>>
				Складское помещение
			</option>
			<option value="45" <?php if($type_id == "45") echo "selected"; ?>>
				Производственно-складское помещение
			</option>
			<option value="46" <?php if($type_id == "46") echo "selected"; ?>>
				Торговую площадь
			</option>
			<option value="47" <?php if($type_id == "47") echo "selected"; ?>>
				Универсальное помещение
			</option>			
		<?}else if ($parent == "Комната" && $topic== "Аренда"){?>
			<option value="">тип комнаты</option>
			<option value="48" <?php if($type_id == "48") echo "selected"; ?>>
				Койко-место
			</option>
			<option value="49" <?php if($type_id == "49") echo "selected"; ?>>
				Комната
			</option>
			<option value="50" <?php if($type_id == "50") echo "selected"; ?>>
				Коммуналка
			</option>
			<option value="51" <?php if($type_id == "51") echo "selected"; ?>>
				2 смежные комнаты
			</option>	
			<option value="52" <?php if($type_id == "52") echo "selected"; ?>>
				2 смежные коммуналки
			</option>	
		<?}else if($parent == "Комната" && $topic== "Продажа"){?>
			<option value="">тип комнаты</option>
			<option value="50" <?php if($type_id == "50") echo "selected"; ?>>
				Комнату
			</option>
			<option value="52" <?php if($type_id == "52") echo "selected"; ?>>
				2 смежные комнаты
			</option>	
		<?}?>
	</select>				
<?unset($type_id);}?>			
</div>
<?if ($parent == "Комната"){
	$ap_layout = Helper::FilterVal('ap_layout');?>
	<div class="col-xs-1 deployed">			
		<label class="signature">тип </label>
		<select class="form-control" name="ap_layout" >
			<option value="">тип объекта</option>
			<option value="в квартире" <?php if($ap_layout == "в квартире") echo "selected"; ?>>
				в квартире
			</option>
			<option value="в общежитии" <?php if($ap_layout == "в общежитии") echo "selected"; ?>>
				в общежитии
			</option>	
			<?if($topic== "Аренда"){?>
				<option value="в частном доме" <?php if($ap_layout == "в частном доме") echo "selected"; ?>>
					в частном доме
				</option>
				<option value="в коттедже" <?php if($ap_layout == "в коттедже") echo "selected"; ?>>
					в коттедже
				</option>
			<?}?>
		</select>
	</div>
<?unset($ap_layout);}?>