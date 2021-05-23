<?
	if($topic == "Аренда"){
		$rentOrSell = array( 
					1 => "1",
					2 => "сдам",
					3 => "3",
					4 => "сниму");
	}else{
		$rentOrSell = array( 
					1 => "2",
					2 => "продам",
					3 => "4",
					4 => "куплю");	
	}
?>
<div class="col-xs-2 deployed" style="max-width: 130px;  min-width: 150px  !important;">
	<div class="btn-group medium" data-toggle="buttons">
	  <label class="btn btn-default active">
		<input type="radio" name="topic_id" 
		value="1" checked><?echo $rentOrSell[2];?>
	  </label>
	</div>
</div> 