<div class="col-xs-2 deployed">
	<label class="signature">Парковка/гараж</label>	
	<select class="form-control" name="park" id="park">
		<option value="">выберите</option>
		<option value="отсутствует" <?php  if(Helper::FilterVal('park') == "отсутствует") echo "selected"; ?>> 
			Отсутствует
		</option>
		<option value="парковка у дома" <?php if(Helper::FilterVal('park') == 'парковка у дома') echo "selected"; ?>>
			Парковка у дома
		</option>
		<?if($parent != "Дома" && $parent != "Дачи"){?>
			<option value="парковка со шлагбаумом" <?php if(Helper::FilterVal('park') == 'парковка со шлагбаумом') echo "selected"; ?>>
				Парковка со шлагбаумом
			</option>
			<option value="подземный гараж" <?php if(Helper::FilterVal('park') == 'подземный гараж') echo "selected"; ?>>
				Подземный гараж
			</option>
			<option value="подземная парковка" <?php if(Helper::FilterVal('park') == 'подземная парковка') echo "selected"; ?>>
				Подземная парковка
			</option>
		<?}else{?>
			<option value="парковка во дворе" <?php if(Helper::FilterVal('park') == 'парковка во дворе') echo "selected"; ?>>
				Парковка во дворе
			</option>
			<option value="металлический гараж" <?php if(Helper::FilterVal('park') == 'металлический гараж') echo "selected"; ?>>
				Металлический гараж
			</option>
			<option value="капитальный гараж" <?php if(Helper::FilterVal('park') == 'капитальный гараж') echo "selected"; ?>>
				Капитальный гараж
			</option>
		<?}?>
	</select>
</div>