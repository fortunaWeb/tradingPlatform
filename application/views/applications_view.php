<?if ($_SESSION['admin'] == "1"){?>
<script type="text/javascript">
	$(function(){
		$("#application a").on("click", function(){	
			var row = $(this).parent().parent(),
				appl = $(this);
			alertify.confirm($(this).data("confirm"), function (result) {
				if (result) {
					$.post($(appl).data("url"), $(appl).data("str"), function() {						
						$(row).slideUp();
						$($(".badge")[0]).text(parseInt($($(".badge")[0]).text())-1);					
					});	
				}
			})
		});
		$(document).on("click", "tr", function(e){
			if(!$(e.target).is($("a"))){
				ShowEmployees($(this).data("id"));
			}
		})
	})
	//для сохранения
	var confirmStr = "Обновить информацию?";
	var postUrl = '?task=profile&action=change_user';
</script>
<div class="col-xs-9">
	<legend>Список заявок на изменение данных</legend>	
	<table id="application" class="table table-striped">
		<thead><tr><th>#</th><th>Логин</th><th>ФИО</th><th>АН</th><th>Коментарий</th><th>Дата</th><th></th></tr></thead>
		<tbody>
			<?for($i=0; $i<count($data); $i++){
				if($data[$i]['comment'] == "Новый сотрудник"){
					$data_url = "?task=profile&action=user_activation";
					$data_str = "user_id=".$data[$i]['user_id']."&application_id=".$data[$i]['id'];
					$data_confirm = "Новый сотрудник будет активирован автоматически. Подтвердить заявку?";
				}else if(ereg("Удаление номера", $data[$i]['comment'])){
					$data_url = "?task=profile&action=phone_to_archive";
					$data_str = "app_id=".$data[$i]['id']."&phone=".preg_replace("/Удаление номера /", "" ,$data[$i]['comment'])."&people_id=".$data[$i]['people_id'];
					$data_confirm = "Номер будет перемещен в архив номеров данного сотрудника автоматически. Подтвердить заявку?";
				}else{
					$data_url = "?task=admin&action=application_to_archive";
					$data_str ="id=".$data[$i]['id'];
					$data_confirm = "Данный вид заявок несет информативный характер и не производит никаких автомических действий. Перенести заявку а архив?";
				}
			echo "<tr id='".$data[$i]['company_id']."' style='cursor:pointer' data-id='".$data[$i]['company_id']."'>
					<td>".($i+1)."</td>
					<td id='user_id' data-user='".$data[$i]['user_id']."'>".Get_functions::Get_login_by_id($data[$i]['user_id'])."</td>
					<td>".Get_functions::Get_fio_by_people_id($data[$i]['people_id'])."</td>
					<td>".Get_functions::Get_company_name_by_id($data[$i]['company_id'])."</td>	
					<td id='comment'>".$data[$i]['comment']."</td>	
					<td>".Translate::month_ru(date('d/m/Y H:i', strtotime($data[$i]['date'])))."</td>
					<td><a href='javascript:void(0)' data-str='".$data_str."' data-url='".$data_url."' data-confirm='".$data_confirm."'>Подтвердить</a></td>
				</tr>";
			}?>
		</tbody>
	</table>
</div>
<?}?>