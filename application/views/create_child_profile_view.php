<script type="text/javaScript">
	$(function(){
		$("form").submit(function(e){
			e.preventDefault();		
			if(confirm("Создать нового пользователя?")){
				jQuery.ajax({
					type: 'POST',
					url: '?task=profile&action=save_profile', 
					data: decodeURIComponent($("form").serialize()),
					success: function(html){
						if(html == "﻿1"){
							window.location = "?task=profile&action=change_profile";
						}else{
							alert(html);
						}					
					}			
				});	
			}			
		});
	})
</script>
<div class="row">
<?php 
echo '<form id="child_profile" action="?task=profile&action=save_profile" method="POST">'; 
if ($_SESSION['parent'] == '0') {
	$address_rent = Get_functions::Get_address_by_people_id($_SESSION['people_id'], 'rent');		
	$address_sell = Get_functions::Get_address_by_people_id($_SESSION['people_id'], 'sell');

	echo "<legend>Форма создания логина для подчиненных</legend>";
	include "application/includes/fields_for_profile_create.php";

} else {
	DB::Delete("re_session", "people_id = ".$_SESSION['people_id']);
	session_destroy();
	header('Location: /?task=login&action=enter');
}
echo '</form>';

?>
</div>