<?
	$park = Helper::FilterVal('park');
?>
<div class="col-xs-3 deployed">
	<select class="form-control" name="park" id="park">
		<option value="">парковка/гараж</option>
		<option value="благоустроенная парковка у дома" <?php if($data_res['park'] == 'частная' || $park == 'частная') echo "selected"; ?>>
			Благоустроенная парковка у дома
		</option>
		<option value="парковка со шлагбаумом" <?php if($data_res['park'] == 'парковка со шлагбаумом' || $park == 'парковка со шлагбаумом') echo "selected"; ?>>
			Парковка со шлагбаумом
		</option>
		<option value="подземный гараж" <?php if($data_res['park'] == 'подземный гараж' || $park == 'подземный гараж') echo "selected"; ?>>
			Подземный гараж
		</option>
		<option value="подземная парковка" <?php if($data_res['park'] == 'подземная парковка' || $park == 'подземная парковка') echo "selected"; ?>>
			Подземная парковка
		</option>
		<option value="подземная парковка" <?php if($data_res['park'] == 'металический гараж' || $park == 'металический гараж') echo "selected"; ?>>
			Металический гараж
		</option>
		<option value="подземная парковка" <?php if($data_res['park'] == 'капитальный гараж' || $park == 'капитальный гараж') echo "selected"; ?>>
			Капитальный гараж
		</option>
	</select>
</div>
<?unset($park);?>