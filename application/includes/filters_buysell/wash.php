<?$wash = Helper::FilterVal('wash');?>
<div class="col-xs-2 deployed">
	<label class="signature">Мыться</label>	
	<select class="form-control" name="wash" >
		<option value="">не важно</option>
		<option value="баня" <?php if($wash == "баня") echo "selected"; ?>>
			Баня
		</option>
		<option value="душ" <?php if($wash == "душ") echo "selected"; ?>>
			Душ
		</option>
		<option value="негде" <?php if($wash == "негде") echo "selected"; ?>>
			Негде
		</option>
	</select>
</div>
<?unset($wash);?>