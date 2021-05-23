<script type="text/javaScript">	
	//для сохранения изменений профиля
	//var confirmStr = "Обновить информацию?";
	//var postUrl = '?task=profile&action=change_user';
	$(function(){
		$(":required").each(function(){
			if($(this).val()==""){
				$(this).css("border-color", "red");
			}else{
				$(this).css("border-color", "#5cb85c");
			}
		});
		$(":required").on("change", function(){
			if($(this).val()!=""){
				$(this).css("border-color", "#5cb85c");
			}else{
				$(this).css("border-color", "red");
			}
		})
	})
</script>
<div class="col-xs-9">
	<legend>Форма создания логина</legend>	
	<form id="child_profile" action="?task=profile&action=create_profile" method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="col-xs-12 deployed" style="color: #B32424;">
				<?if($_POST) echo $data;?>
			</div>
		</div>
		<input type="hidden" name="company_id" value="<?echo $_SESSION['company_id'];?>">		
		<?include "application/includes/fields_for_profile_create.php";?>		
	</form>
</div>