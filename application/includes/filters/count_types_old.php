<div class="col-xs-4 deployed">
	<div class="btn-group medium multi-active">
		<button type="button" id="k" data-value="18" onclick = "countType('k')" class="btn btn-default <?php if($_SESSION['post']['type_id1'] == 18) echo "active"; ?>">комната</button>
		<button type="button" id="1-k" data-value="19" onclick = "countType('1-k')" class="btn btn-default <?php if($_SESSION['post']['type_id2'] == 19) echo "active"; ?>">1-к</button>
		<button type="button" id="2-k" data-value="20" onclick = "countType('2-k')" class="btn btn-default <?php if($_SESSION['post']['type_id3'] == 20) echo "active"; ?>">2-к</button>
		<button type="button" id="3-k" data-value="21"  onclick = "countType('3-k')" class="btn btn-default <?php if($_SESSION['post']['type_id4'] == 21) echo "active"; ?>">3-к</button>
		<button type="button" id="4-k" data-value="22" onclick = "countType('4-k')" class="btn btn-default <?php if($_SESSION['post']['type_id5'] == 22) echo "active"; ?>">4-к</button>
		<button type="button" id="5-k" data-value="23" onclick = "countType('5-k')" class="btn btn-default <?php if($_SESSION['post']['type_id6'] == 23) echo "active"; ?>">5-к</button>
		<button type="button" id="6-k" data-value="24" onclick = "countType('6-k')" class="btn btn-default <?php if($_SESSION['post']['type_id7'] == 24) echo "active"; ?>">6-к+</button>
		
		<input type="hidden" name="type_id1" data-id="k" value="<?php if($_SESSION['post']['type_id1'] == 18) echo "18"; ?>">
		<input type="hidden" name="type_id2" data-id="1-k" value="<?php if($_SESSION['post']['type_id2'] == 19) echo "19"; ?>">
		<input type="hidden" name="type_id3" data-id="2-k" value="<?php if($_SESSION['post']['type_id3'] == 20) echo "20"; ?>">
		<input type="hidden" name="type_id4" data-id="3-k" value="<?php if($_SESSION['post']['type_id4'] == 21) echo "21"; ?>">
		<input type="hidden" name="type_id5" data-id="4-k" value="<?php if($_SESSION['post']['type_id5'] == 22) echo "22"; ?>">
		<input type="hidden" name="type_id6" data-id="5-k" value="<?php if($_SESSION['post']['type_id6'] == 23) echo "23"; ?>">
		<input type="hidden" name="type_id7" data-id="6-k" value="<?php if($_SESSION['post']['type_id7'] == 24) echo "24"; ?>">
		<input id="type_id" type="hidden" name="type_id" value="<?php if($_SESSION['post']['type_id']) { echo $_SESSION['post']['type_id'];} else {echo '0';} ?>" />
	</div>	
</div> 