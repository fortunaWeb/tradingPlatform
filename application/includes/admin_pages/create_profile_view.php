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
		
		$(":required").on("keyup", function(){
			if($(this).val()!=""){
				$(this).css("border-color", "#5cb85c");
				var objName = $(this).attr("name"),
					query="",
					fio = objName == "surname" || objName == "name" || objName == "second_name",
					name = $("[name=name]").val(),
					surname = $("[name=surname]").val(),
					secondName = $("[name=second_name]").val(),
					val = $(this).val();
					query = objName.split('-')[1]+"="+val;
				/*if(objName == "company_name" || objName == "login" || objName == "nickname" || objName == "phone"){
					query = objName+"="+val;
				}
				 else if(fio && name!="" && surname!="" && secondName!=""){
					// query = "fio=1&surname="+surname+"&name="+name+"&second_name"+secondName;
				// }*/
				if(query!=""){
					$.post("?task=admin&action=check_input", query, function(html){
						var ul = $("[name="+objName+"]").next().find("ul");
						if(html!=""){
							$(ul).empty();
							$(ul).append(html);
							$("[name="+objName+"]").next().slideDown();
							$("[name="+objName+"]").css("border-color", "red");
						}else{
							$(ul).empty();
							$("[name="+objName+"]").next().slideUp();
						}
					})
				}
			}else{
				$(this).css("border-color", "red");
			}
		});
		
		$(document).on("change", "[name=ad-sell-ip], [name=ad-rent-ip]", function(){
			if($("[name=ad-sell-ip]").val() != "" && $("[name=ad-rent-ip]").val() != ""){
				$("[name=us-group_topic_id]").val("3");
			}else if($(this).val() != ""){
				$("[name=us-group_topic_id]").val($("#address div").has($(this)).attr("id"));
			}else{
				$("[name=us-group_topic_id]").val("1");
			}
		});
		
		$(document).on("change", "[name=pe-surname], [name=pe-name], [name=pe-second_name]", function(){
			var name = $("[name=pe-name]").val(),
				surname = $("[name=pe-surname]").val(),
				secondName=$("[name=pe-second_name]").val(),
				data = "";
			if(name!="")data +="name="+name;
			if(surname!="")data +="&surname="+surname;
			if(secondName!="")data +="&secondName="+secondName;
			if($(this).val() != ""){
				$.post("?task=admin&action=find_dismiss_people", data, function(html){
					$("#for-table").empty().append($(html));
				})
			}
		});
		
		$(document).on('click', "[data-id=choosePeople]", function(){
			var tr = $("tr").has($(this));
			$("[name=pe-surname]").val($(tr).find('[data-id=surname]').text());
			$("[name=pe-name]").val($(tr).find('[data-id=name]').text());
			$("[name=pe-second_name]").val($(tr).find('[data-id=second_name]').text());
			$("[name=pe-phone]").val($(tr).find('[data-id=phone]').text());
			$("[name=ip]").val($(tr).find('[data-id=ips]').text().split(',')[0]);
			$("[name=old-people-id]").val($(tr).attr("id"));
			$("[name=passport]").parent().remove();
			$("[name=face]").parent().remove();
		});
	})
</script>
<div class="col-xs-9">
	<legend>Форма создания риелтора</legend>	
	<form id="child_profile" action="?task=admin&action=save_profile" method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="col-xs-12 deployed" style="color: #B32424;">
				<?if($_POST) echo $data;?>
			</div>
		</div>
		<div class="row">
			<?/*<div class="col-xs-2 deployed">			
				<label class="signature">Агентсво</label>
				<select class="form-control" name="company_id" required>
					<option value="">выберите</option>
					<?Helper::An_options();?>
				</select>				
			</div>*/?>
			<div class="col-xs-3 deployed">	
				<input type="text" class="form-control" data-name="an-list" placeholder="агентство или логин" value="">
				<div class="an_list" style="display: none;overflow: auto; height: 250px;"></div>
				<input type="hidden" name="company_id" value="">		
			</div>
			<input type="hidden" name="us-group_topic_id" value="1" >
		</div>
		<?include "application/includes/fields_for_profile_create.php";?>
		<input type="hidden" name="old-people-id" value="" />
	</form>
	<div id="for-table">
	</div>
</div>