<?php
class Controller_Chat extends Controller
{
	function __construct()
	{
		$this->model = new Model_Chat();
		$this->view = new View();
	}
	
	function action_send_call()
	{
		$this->model->send_call();	
	}
	
	function action_read_mes()
	{
		$this->model->read_mes();
	}
	
	function action_read_mes_rent()
	{
		$this->model->read_mes_rent();
	}
	
	function action_nick_create(){
		$this->model->nick_create();
	}
	
	function action_new_chat_mess(){
		$this->model->new_chat_mess();
	}
	
	function action_chat()
	{	
		$this->view->generate('chat_view.php', 'template_view.php');
	}
	
	function action_chat_mess_count()
	{	
		$this->model->chat_mess_count();
	}
	
	function action_chat_user_info()
	{	
		$this->model->chat_user_info();
	}
}
?>