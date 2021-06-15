<div class="col-xs-3 deployed">
	<label class="signature">Период сдачи</label>
	<select class="form-control" name="deliv_period" id="deliv_period" required>
		<option value="">выберите период</option>
		<option value="14" <?php if($data_res['deliv_period'] == '14') echo "selected"; ?>>Длительно</option>
		<?if($topic_id!=3 && $topic_id!=4){?>
			<option value="15" <?php if($data_res['deliv_period'] == '15') echo "selected"; ?>>На продаже</option>
		<?}?>
		<option value="13" <?php if($data_res['deliv_period'] == '13') echo "selected"; ?>>Лето</option>
		<?for($i=1; $i<=12; $i++){
			$selected = $data_res['deliv_period'] == $i ? "selected" : "";
			echo "<option value='".$i."' ".$selected.">".$i." мес.</option>";
			}
		?>
        <option value="16" <?php if($data_res['deliv_period'] == '16') echo "selected"; ?>>Сутки</option>
	</select>
</div>