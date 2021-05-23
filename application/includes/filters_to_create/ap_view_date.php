<div class='col-xs-12'></div>
<script type="text/javascript">
	$(function(){
		if($("[name=ap_race_date]").val() == "0000-00-00"){
			$("#race-now").click();
		}
	})
</script>
<div class="col-xs-6 deployed">
	<div class="checkbox" style="margin-bottom: auto; height: 26px;">			
		<label>
			<input onClick="if($(this).is(':checked')){$('[data-name=forHidde]').val('0000-00-00').parent().hide()}else{$('[data-id=date]').val('').parent().show()}" type="checkbox" value="1" <?if($race_date)echo 'checked';?> id="race-now">
			<?php
				if($_SESSION['mobile']){ ?>
					ПОСМОТР, </label>
	</div>
					<div class="checkbox" style="margin-bottom: auto; height: 26px;"><label>
					ОФОРМЛЕНИЕ</label>
	</div>
	<div class="checkbox" style="margin-bottom: auto; height: 26px;"><label> И ЗАЕЗД СЕГОДНЯ
				<?php }else{ ?>
					ПОСМОТР, ОФОРМЛЕНИЕ И ЗАЕЗД СЕГОДНЯ			
				<?php
				}
				?>
			
		</label>
	</div>
</div>
<div class="col-xs-3 deployed">
	<div class="input-group interval xl">
		<span class="input-group-addon" id="ap_view_date">Просмотр</span>
		<input type="text" class="form-control" data-id="date" data-name="forHidde" name="ap_view_date" placeholder="не позднее" 
		value="<?php if($data_res['ap_view_date']) echo $data_res['ap_view_date']; ?>" required>	
	</div>	
</div>	