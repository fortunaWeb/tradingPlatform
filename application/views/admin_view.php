<h2 class='center'>Панель администрирования</h2>
<!--
Пока что, отобразим здесь простой текст.
Далее можно добавить в админку некоторый функционал.
Например, WYSIWYG-редактор для изменения страниц сайта (видов).
Тогда, этот вид будет содержать выпадающий список для выбора страницы, поле редактора, а также кнопку
для сохранения изменений. А некоторое действие контроллера администрирования будет описывать логику редактирования страниц.
-->
<div style="width: 215px;display: inline-block;float: left;">
	<ul class="admin-menu">
		<a href="/?task=admin"><li class='<?if(!isset($_GET['action']) || $_GET['action']=='index')echo "active";?>'>Общие сведения</li></a>
		<a href="?task=admin&action=order"><li class='<?if($_GET['action']=='order')echo "active";?>'>Оплата (<?echo Get_functions::Get_new_tinkoff_order_count();?>)</li></a>

		<li class='<?if($_GET['action']=='find_an' || $_GET['action']=='find_employee')echo "active";?>'>
			Открыть данные
			<form id='an' action="?task=admin&action=find_an" method='POST' style='margin-bottom:5px'>
				<input style='width:150px; display:inline-block' class='form-control' type='text'  form='an' name='an' placeholder='название АН' value='<?if(isset($_POST['an']))echo $_POST['an'];?>'>
				<input type='submit' form='an' value='OK'>
			</form>
			<form id='login' action='?task=admin&action=find_employee' method='POST' style='margin-bottom:5px'>
				<input style='width:150px; display:inline-block' class='form-control' type='text'  form='login' name='login' placeholder='логин' value='<?if(isset($_POST['login']))echo $_POST['login'];?>'>
				<input type='submit' form='login' value='OK'>
			</form>
			<form id='phone' action='?task=admin&action=find_phone' method='POST'>
				<input style='width:150px; display:inline-block' class='form-control' type='text'
                        data-id='phone'  form='phone' name='phone'  id="phone"
                       placeholder='телефон' value='<?=(isset($_POST['phone'])) ? $_POST['phone'] : ''?>'>
				<input type='submit' form='phone' value='OK'>
			</form>
		</li>
		<a href="?task=admin&action=user_list"><li class='<?if($_GET['action']=='user_list')echo "active";?>'>Список АН (<?echo Get_functions::Get_an_count("all");?>)</li></a>
		<a href="?task=admin&action=applications"><li class='<?if($_GET['action']=='applications')echo "active";?>'>Заявки на изменения данных (<?echo Get_functions::Get_applications_count();?>)</li></a>
		<a href="?task=admin&action=review_list"><li class='<?if($_GET['action']=='review_list')echo "active";?>'>Жалобы (<?echo DB::Select('COUNT(*)', 're_review as r, re_var as v, re_user as u', 'v.user_id = u.user_id AND v.id = r.var_id AND r.checked=0')[0]['COUNT(*)'];?>)</li></a>		
		<a href="?task=admin&action=messages"><li class='<?if($_GET['action']=='messages')echo "active";?>'>Сообщения от пользователей (<?echo Get_functions::Get_message_count($_SESSION['people_id']);?>)</li></a>
		<a href="?task=admin&action=check_rielter"><li class='<?if($_GET['action']=='check_rielter')echo "active";?>'>Проверка (АН/риэлтер) в базе</li></a>
		<a href="?task=admin&action=send_message"><li class='<?if($_GET['action']=='send_message')echo "active";?>'>Отправить сообщение</li></a>		
		<a href="?task=admin&action=create_profile"><li class='<?if($_GET['action']=='create_profile')echo "active";?>'>Добавить нового сотрудника в АН</li></a>
		<?/*<a href="?task=admin&action=forum"><li class='<?if($_GET['action']=='forum')echo "active";?>'>Форум</li></a>*/?>
		<a href="?task=admin&action=callboard&callboard_topic=sell"><li class='<?if($_GET['action']=='callboard')echo "active";?>'>Доска объявлений</li></a>
		<a href="?task=admin&action=recipients"><li class='<?if($_GET['action']=='recipients')echo "active";?>'>Подборки</li></a>
		<a href="?task=admin&action=street_error"><li class='<?if($_GET['action']=='street_error')echo "active";?>'>ОшибкиУлиц</li></a>
	</ul>
</div>
<?
if(!isset($_GET['action'])){
include "application/includes/admin_pages/main_page.php";
}else if($_GET['action'] == "review_list"){
include "application/includes/admin_pages/review_list.php";
echo Helper::Modal_win_messages();
}else if($_GET['action'] == "user_list" || $_GET['action'] == "find_an" || $_GET['action'] == "find_employee" || $_GET['action'] == "find_phone" || $_GET['action'] == "find_fio"){
include "application/views/user_list_view.php";
echo Helper::Modal_win_messages();
echo Helper::Modal_win_clean();
}/* else if($_GET['action'] == "find_employee"){
include "application/includes/admin_pages/find_employee_view.php";
}*/else if($_GET['action'] == "create_profile" || $_GET['action'] == "save_profile"){
include "application/includes/admin_pages/create_profile_view.php";
}else if($_GET['action'] == "applications"){
include "application/views/applications_view.php";
echo Helper::Modal_win_messages();
echo Helper::Modal_win_clean();
}else if($_GET['action'] == "messages"){
include "application/views/messages_view.php";
}else if($_GET['action'] == "send_message"){
include "application/includes/admin_pages/send_message_view.php";
}else if($_GET['action'] == "check_rielter"){
include "application/views/check_rielter_view.php";
}else if($_GET['action'] == "callboard"){
include "application/views/callboard_view.php";
}else if($_GET['action'] == "order"){
include "application/includes/admin_pages/order_list_view.php";
echo Helper::Modal_win_messages();
echo Helper::Modal_win_clean();
// }else if($_GET['action'] == "forum"){
// include "application/views/forum_view.php";
}else if($_GET['action'] == "recipients"){
	echo "<div class='col-xs-9'>";
		include "application/includes/recipients.php";
	echo "</div>";
}else if($_GET['action'] == "functional_description"){
	echo "<div class='col-xs-9'>";
		include "application/views/functional_description.php";
	echo "</div>";
}else if($_GET['action'] == "street_error"){
    include "application/includes/admin_pages/street_error_list_view.php";
}
?>
