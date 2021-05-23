<script type="text/javascript">
	$(function(){
		if($("input#alert").length == 1)
		{
			alertify.alert($("input#alert").val());
		}
	}
</script>
<?
if($data[0]=="ex_of_acc"){

	echo "<div class='container col-md-9 col-md-offset-3' style='margin-top: 45px;'>";
	if(intval($_SESSION["order_access"])==1){
		include "application/includes/profile_pages/order_view.php";
	}else if(intval($_SESSION["order_access"])==0){
		$data = Helper::Services_data();
        include "application/includes/profile_pages/services_view_tinkoff.php";
		unset($data, $_SESSION);
	}
	echo "</div>";
}elseif(count($data)==1 && (!isset($_GET) || $_GET['task']=="login") ){

	echo "<input type='hidden' id='alert' value='".$data."'>";
	
}else{
    echo "<input type='hidden' id='alert' value='".$data."'>";
   }
?>