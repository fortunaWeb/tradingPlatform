<?
	$parent_id = Helper::FilterVal('parent_id');
	echo "!!!". $_GET['parent_id']."????";
?>
<div class="col-xs-1 deployed" style="min-width:110px !important">
	<label class="signature">Тип жилья</label>
	<select class="form-control" name="parent_id" id="parent_id" >
		<option value="">Все</option>
		<option value="18" <?php if($parent_id == '18') echo "selected"; ?>>Комната</option>
		<option value="1" <?php if($parent_id == '1') echo "selected"; ?>>Квартира</option>
		<option value="3" <?php if($parent_id == '3') echo "selected"; ?>>Дом</option>
	</select>
</div>
<?
	unset($parent_id);
?>