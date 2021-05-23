<?$director = $_SESSION["parent"] == 0;?>
<p class='center' style = "color: rgb(205, 24, 24); font-size: 18px;" >Личный кабинет <?=($director ? "директора АН «{$_SESSION['company_name']}»" : "сотрудника АН «{$_SESSION['company_name']}»")?></p>

<?php
if(!$_SESSION['mobile']) {
?>
<div style="width: 215px;display: inline-block;float: left;">
	<ul class="admin-menu">
		<?if($director){?>
            <a href="?task=profile&action=services"><li class='<?if($_GET['action']=='services')echo "active";?>'>
                    <font style = 'color: #884535'>Продление доступа</font></li></a>

            <a href="?task=profile&action=order_txt"><li class='<?if($_GET['action']=='order_txt')echo "active";?>'>
                    <font style = 'color: #884535'>Как оплатить доступ</font></li></a>


            <a href="?task=profile&action=order"><li class='<?if($_GET['action']=='order')echo "active";?>'>
                    <font style = 'color: #884535'>Отправка данных  об оплате</font></li></a>

            <a href="?task=profile&action=user_list"><li class='<?if($_GET['action']=='user_list' || $_GET['action']=='create_profile')echo "active";?>'>Список сотрудников</li></a>
            <a href="?task=profile&action=tariffs"><li class='<?if($_GET['action']=='tariffs')echo "active";?>'>Оферта</li></a>
		<?}?>
		    <a href="?task=profile&action=rules"><li class='<?if($_GET['action']=='rules')echo "active";?>'>Правила</li></a>
        <?php if($_SESSION['login'] == 'admin'){ ?>
            <a href="?task=profile&action=messages"><li class='<?if($_GET['action']=='messages')echo "active";?>'>
                  Сообщения от администратора (<?echo Get_functions::Get_message_count($_SESSION['people_id']);?>)
            </li></a>
        <?php } ?>
		<a href="?task=profile&action=send_message"><li class='<?if($_GET['action']=='send_message')echo "active";?>'>Написать администратору</li></a>
		<?if($director){?>
			<a href="?task=profile&action=contacts"><li class='<?if($_GET['action']=='contacts')echo "active";?>'>Контакты администратора</li></a>
		<?}?>
	</ul>
</div>
<?
}
if($_GET['action'] == "messages"){
	include "application/views/messages_view.php";
}else if($_GET['action'] == "order" && $director){
	include "application/includes/profile_pages/order_view.php";
}else if($_GET['action'] == "send_message"){
	include "application/includes/profile_pages/send_message_view.php";
}else if($_GET['action'] == "check_rielter"){
	include "application/views/check_rielter_view.php";
}else if($_GET['action'] == "callboard"){
	include "application/views/callboard_view.php";
}else if($_GET['action'] == "create_profile" || $_GET['action'] == "save_profile"){
	include "application/includes/profile_pages/create_profile_view.php";
}else if($_GET['action'] == "user_list"){
	include "application/includes/profile_pages/user_list_view.php";
}else if($_GET['action'] == "services"){
//    include "application/includes/profile_pages/services_view_tinkoff.php";
    include "application/includes/profile_pages/services_view.php";
}else if($_GET['action'] == "forum" && $_SESSION['block_forum'] == 0){
	include "application/views/forum_view.php";
}else if($_GET['action'] == "tariffs"){
	include "application/includes/profile_pages/tariffs_view.php";
}else if($_GET['action'] == "rules"){
	include "application/includes/profile_pages/rules_view.php";
}else if($_GET['action'] == "contacts"){
	include "application/includes/profile_pages/contacts_view.php";
}else if($_GET['action'] == "caution"){
	include "application/views/caution_view.php";
}else if($_GET['action'] == "lists"){
	include "application/views/lists_view.php";
}else if($_GET['action'] == "group_setting"){
	include "application/includes/profile_pages/group_setting_view.php";
}else if($_GET['action'] == "order_txt"){
	include "application/includes/profile_pages/order_view_txt.php";
}
?>
