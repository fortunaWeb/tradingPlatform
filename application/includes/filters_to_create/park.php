<div class="col-xs-2 deployed">
	<label class="signature">Парковка/гараж</label>	
	<select class="form-control" name="park" id="park">
		<option value="">выберите</option>
		<option value="отсутствует" <?php if($data_res['park'] == 'отсутствует') echo "selected"; ?>>
			Отсутствует
		</option>
		<option value="парковка у дома" <?php if($data_res['park'] == 'парковка у дома') echo "selected"; ?>>
			Парковка у дома
		</option>
		<?if($parent != "Дома" && $parent != "Дачи"){?>
			<option value="парковка со шлагбаумом" <?php if($data_res['park'] == 'парковка со шлагбаумом') echo "selected"; ?>>
				Парковка со шлагбаумом
			</option>
			<option value="подземный гараж" <?php if($data_res['park'] == 'подземный гараж') echo "selected"; ?>>
				Подземный гараж
			</option>
			<option value="подземная парковка" <?php if($data_res['park'] == 'подземная парковка') echo "selected"; ?>>
				Подземная парковка
			</option>
		<?}else{?>
			<option value="парковка во дворе" <?php if($data_res['park'] == 'парковка во дворе') echo "selected"; ?>>
				Парковка во дворе
			</option>
			<option value="металлический гараж" <?php if($data_res['park'] == 'металлический гараж') echo "selected"; ?>>
				Металлический гараж
			</option>
			<option value="капитальный гараж" <?php if($data_res['park'] == 'капитальный гараж') echo "selected"; ?>>
				Капитальный гараж
			</option>
		<?}?>
	</select>
</div>