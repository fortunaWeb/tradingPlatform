<div class="col-xs-2 deployed">	
	<?php if($parent == "Квартиры" || $parent == "Новостройки"){ ?>	
		<label class="signature">Тип квартиры</label>
		<select class="form-control" name="ap_layout">
			<option value="">выберите</option>
			<option value="типовая" <?php if($data_res['ap_layout'] == "типовая") echo "selected"; ?>>
				Типовая
			</option>
			<option value="улучшеная планировка" <?php if($data_res['ap_layout'] == "улучшеная планировка") echo "selected"; ?>>
				Улучшеная планировка
			</option>	
			<option value="полногабаритная" <?php if($data_res['ap_layout'] == "полногабаритная") echo "selected"; ?>>
				Полногабаритная
			</option>
			<option value="хрещевка" <?php if($data_res['ap_layout'] == "хрещевка") echo "selected"; ?>>
				Хрущевка
			</option>
			<option value="малосемейка" <?php if($data_res['ap_layout'] == "малосемейка") echo "selected"; ?>>
				Малосемейка
			</option>
			<option value="малоэтажка" 
				<?php if($data_res['ap_layout'] == "малоэтажка") echo "selected"; ?>>
				Малоэтажка
			</option>					
		</select>			
	<?}else{?>						
		<?if($parent == "Дома"){?>	
		<label class="signature">Тип дома</label>
		<select class="form-control" name="type_id" required>	
			<option value="">выберите</option>
			<option value="25" <?php if($data_res['type_id'] == "25") echo "selected"; ?>>
				Дом
			</option>
			<option value="26" <?php if($data_res['type_id'] == "26") echo "selected"; ?>>
				Часть дома
			</option>
			<option value="27" <?php if($data_res['type_id'] == "27") echo "selected"; ?>>
				Коттедж
			</option>
			<option value="28" <?php if($data_res['type_id'] == "28") echo "selected"; ?>>
				Часть коттеджа
			</option>
			<option value="29" <?php if($data_res['type_id'] == "29") echo "selected"; ?>>
				Таунхаус
			</option>	
		</select>	
		<?}else if($_GET['type_id'] == 4 || $parent == "Дачи"){?>
		<label class="signature">Тип дачи</label>
		<select class="form-control" name="type_id" required>
			<option value="">выберите</option>
			<option value="30" <?php if($data_res['type_id'] == "30") echo "selected"; ?>>
				Участок с домиком
			</option>
			<option value="31" <?php if($data_res['type_id'] == "31") echo "selected"; ?>>
				Садовый участок
			</option>
		</select>	
		<?}else if($parent == "Земля"){?>
		<label class="signature">Тип земли</label>
		<select class="form-control" name="type_id" required>
			<option value="">выберите</option>
			<option value="32" <?php if($data_res['type_id'] == "32") echo "selected"; ?>>
				Земельный участок
			</option>
			<option value="33" <?php if($data_res['type_id'] == "33") echo "selected"; ?>>
				Землеотвод
			</option>
			<option value="34" <?php if($data_res['type_id'] == "34") echo "selected"; ?>>
				Коммерческая земля
			</option>
		</select>	
		<?}else if ($parent == "Гаражи"){?>
		<label class="signature">Тип гаража</label>
		<select class="form-control" name="type_id" required>
			<option value="">выберите тип</option>
			<option value="35" <?php if($data_res['type_id'] == "35") echo "selected"; ?>>
				Капитальный
			</option>
			<option value="36" <?php if($data_res['type_id'] == "36") echo "selected"; ?>>
				Металлический
			</option>
			<option value="37" <?php if($data_res['type_id'] == "37") echo "selected"; ?>>
				Парковочное место
			</option>
			<option value="38" <?php if($data_res['type_id'] == "38") echo "selected"; ?>>
				Овощехранилище
			</option>	
		</select>	
		<?}else if ($parent == "Коммерческая"){?>
		<label class="signature">Тип недвижемости</label>
		<select class="form-control" name="type_id" required>
			<option value="">выберите тип</option>
			<option value="39" <?php if($data_res['type_id'] == "39") echo "selected"; ?>>
				Бизнес-центр
			</option>
			<option value="40" <?php if($data_res['type_id'] == "40") echo "selected"; ?>>
				Готовый бизнес
			</option>
			<option value="41" <?php if($data_res['type_id'] == "41") echo "selected"; ?>>
				Отдельно строящиеся зданиео
			</option>
			<option value="42" <?php if($data_res['type_id'] == "42") echo "selected"; ?>>
				Офисное помещение
			</option>
			<option value="43" <?php if($data_res['type_id'] == "43") echo "selected"; ?>>
				Производственное помещение
			</option>
			<option value="44" <?php if($data_res['type_id'] == "44") echo "selected"; ?>>
				Складское помещение
			</option>
			<option value="45" <?php if($data_res['type_id'] == "45") echo "selected"; ?>>
				Производственно-складское помещение
			</option>
			<option value="46" <?php if($data_res['type_id'] == "46") echo "selected"; ?>>
				Торговая площадь
			</option>
			<option value="47" <?php if($data_res['type_id'] == "47") echo "selected"; ?>>
				Универсальное
			</option>	
		</select>	
		<?}else if ($parent == "Комната" && $topic == "Аренда"){?>
		<label class="signature">Тип комнаты</label>
		<select class="form-control" name="type_id" required>
			<option value="">выберите тип</option>
			<option value="48" <?php if($data_res['type_id'] == "48") echo "selected"; ?>>
				Койко-место
			</option>
			<option value="49" <?php if($data_res['type_id'] == "49") echo "selected"; ?>>
				Комната
			</option>
			<option value="50" <?php if($data_res['type_id'] == "50") echo "selected"; ?>>
				Коммуналка
			</option>
			<option value="51" <?php if($data_res['type_id'] == "51") echo "selected"; ?>>
				2 смежные комнаты
			</option>	
			<option value="52" <?php if($data_res['type_id'] == "52") echo "selected"; ?>>
				2 смежные коммнуналки
			</option>
			<option value="53" <?php if($data_res['type_id'] == "53") echo "selected"; ?>>
				Общежитие коридорного типа
			</option>
			<option value="54" <?php if($data_res['type_id'] == "54") echo "selected"; ?>>
				Общежитие секционного типа
			</option>
		</select>	
		<?}else if ($parent == "Комната" && $topic == "Продажа"){?>
			<label class="signature">Тип комнаты</label>
			<select class="form-control" name="type_id" required>
				<option value="">выберите тип</option>
				<option value="49" <?php if($data_res['type_id'] == "49") echo "selected"; ?>>
					Комната
				</option>
				<option value="52" <?php if($data_res['type_id'] == "52") echo "selected"; ?>>
					2 смежные
				</option>
				<option value="53" <?php if($data_res['type_id'] == "53") echo "selected"; ?>>
					Общежитие
				</option>
			</select>	
		<?}?>
	<?}?>			
</div>