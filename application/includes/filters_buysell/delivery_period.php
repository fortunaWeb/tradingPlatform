<?
	$del_period = Helper::FilterVal('deliv_period');
?>
<div class="col-xs-1 deployed" style="min-width:110px !important">
	<label class="signature">Период сдачи</label>
	<select class="form-control" name="deliv_period" id="deliv_period" >
		<option value="">не важно</option>
		<option value="14" <?php if($del_period == '14') echo "selected"; ?>>Длительно</option>
		<option value="15" <?php if($del_period == '15') echo "selected"; ?>>На продаже</option>
		<option value="13" <?php if($del_period == '13') echo "selected"; ?>>Лето</option>
		<option value="16" <?php if($del_period == '16') echo "selected"; ?>>Сутки</option>
		<?for($i=1; $i<=12; $i++){
			$selected = $del_period == $i ? "selected" : "";
			echo "<option value='".$i."' ".$selected.">".$i." мес.</option>";
			}
		?>		
	</select>
</div>
<?
	unset($del_period);
?>