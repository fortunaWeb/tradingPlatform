<div class="col-xs-1 deployed"
style ='<?=$_SESSION['mobile']==1?'width: 15%;margin-right: 1%;':''?>'>

	<label class="signature">До метро</label>	
	<select name="to_metro" class="form-control">
		<option value="">до метро</option>
		<?for($i=500; $i<3500; $i+=500){			
			$selected = Helper::FilterVal('to_metro')==$i ? 'selected' : '';
			echo "<option value='{$i}' {$selected}>{$i}</option>";
		}?>
	</select>
</div>