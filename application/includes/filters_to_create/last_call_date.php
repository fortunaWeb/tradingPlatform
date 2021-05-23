<div class="col-xs-3 deployed">
		<label class="signature">дата последнего прозвона: </label>
		<input required type="text" class="form-control" data-id="date"  name="last_call_date" placeholder="дата последнего прозвона: " 
		value='
			<?php
		 		if(isset($data_res['last_call_date']))
		 		{
	 				 echo $data_res['last_call_date']; 
	 			}else if(isset($data_res['date_added'])){
	 				echo $data_res['date_added']; 
	 			}else{
	 				echo date("Y-m-d");
	 			}
		 	?>'>	
</div>