<?if($_SESSION['search_user_id'] != "ngs" && $_GET['action']!="pay_parse" && $_GET['action']!="parse"){?>		
	<div class="col-xs-2 deployed">	
		<input type="text" class="form-control" data-name="an-list" placeholder="агентство" value="<?if(Helper::FilterVal("company_id")!="") echo $data[0]['company_name'];?>">
		<div class="an_list" style="display: none;overflow: auto; height: 250px;"></div>
		<input type="hidden" name="company_id" value="<?if(Helper::FilterVal("company_id")!="") echo Helper::FilterVal("company_id");?>">		
	</div>
	<?$order = Helper::FilterVal("order");?>

	<div class="col-xs-2 deployed" style="width: 150px;">			
		<select class="form-control" name="order">
			<option value="date_last_edit" <?php if($order == "date_last_edit") echo "selected"; ?>>
				по продлению333
			</option>
			<option value="date_added" <?php if($order == "date_added") echo "selected"; ?>>
				по созданию
			</option>	
			<option value="while_list" <?php if($order == "while_list") echo "selected"; ?>>
				белый список
			</option>
			<option value="status=3" <?php if($order == "status=3") echo "selected"; ?>>
				нет в инете
			</option>
			<option value="prolong_garant" <?php if($order == "prolong_garant") echo "selected"; ?>>
				актуальные 100%
			</option>
		</select>
	</div>
	<?php
	unset($order);
	}
	if($_SESSION['search_user_id'] != "ngs" && 
		$_SESSION['topic_id']%2!=0 && 
		$_GET['action']!="pay_parse" && 
		$_GET['action']!="parse" ){
	$hours = Helper::FilterVal("hours");?>	

	<?php
	unset($hours);
}else if($_GET['action']=="pay_parse" || $_GET['action']=="parse_buysell" ){
    include "application/includes/filters/origins.php";
}else if($_GET['action']=="parse" ){
	Helper::OriginsParse();


}else if($_SESSION['topic_id']%2==0 && $_SESSION['search_user_id'] != "ngs"){

$hours = Helper::FilterVal("hours");?>

<?unset($hours);
}else if($_GET['action']!="pay_parse" && $topic_id%2!=0 ){
	$user_id = Helper::FilterVal("user_id");?>
	<div class="col-xs-1 deployed">
		<select class="form-control" name="user_id">
			<option value="">
				все
			</option>
			<option value="avito" <?php if($user_id == "avito") echo "selected"; ?>>
				авито
			</option>
			<option value="ngs" <?php if($user_id == "ngs") echo "selected"; ?>>
				нгс
			</option>
		</select>
	</div>
	<?php
	unset($user_id);
	}
?>

<?if($_GET['action']!="pay_parse"){?>
	<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;min-width: 60px;">
		<label onClick="HideContacts($(this))" class="btn btn-default
			<?php
				if(
					Helper::FilterVal('without_cont') == 1 ||
					$_SESSION["post"]["without_cont"]==1
				) echo "active";
			?>">
					<input type="checkbox" name="without_cont" value="1"
			<?php
				if(
					Helper::FilterVal('without_cont') == 1 ||
					$_SESSION["post"]["without_cont"]==1
					) echo "checked";
			?>>ВИД
		</label>
	</div>
	<?if($_GET["action"]=="parse"){?>
	<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;">
		<label class="btn btn-default <?php if(Helper::FilterVal('photos') != "") echo "active"; ?>">
			<input type="checkbox" name="photos" value="1" <?php if(Helper::FilterVal('photos') == "1") echo "checked"; ?>>С фото
		</label>
	</div>
	<?}else{?>
		<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;">
			<label class="btn btn-default <?php if(Helper::FilterVal('photo') == 1) echo "active"; ?>">
				<input type="checkbox" name="photo" value="1" <?php if(Helper::FilterVal('photo') == 1) echo "checked"; ?>>С фото
			</label>
		</div>
	<?}?>
<?}else{?>
	<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;">
		<label class="btn btn-default <?php if(Helper::FilterVal('photos') == 1) echo "active"; ?>">
			<input type="checkbox" name="photos" value="1" <?php if(Helper::FilterVal('photos') == 1) echo "checked"; ?>>С фото
		</label>
	</div>
<?}?>