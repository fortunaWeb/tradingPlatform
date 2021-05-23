<?php
class Controller_Admin extends Controller
{		
	function __construct()
	{
		$this->model = new Model_Admin();
		$this->view = new View();
	}
	
	function action_index()
	{
		$data = $this->model->get_data();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}

	function action_street_error()
    {
        $data = $this->model->street_error();
        $this->view->generate('admin_view.php', 'template_view.php', $data);
    }

    function action_street_change()
    {
        $this->model->street_change();
    }

    function action_address_change()
    {
        $this->model->address_change();
    }

	function action_review_list()
	{
		$data = $this->model->review_list();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_review_list_for_admin()
	{
		$this->model->review_list_for_admin();
	}
	
	function action_checked_review(){
		$this->model->checked_review();
	}
	
	function action_delete_review(){
		$this->model->delete_review();
	}
	
	function action_user_list()
	{
		$data = $this->model->user_list();		
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_find_an()
	{
		$data = $this->model->find_an();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_find_employee()
	{
		$data = $this->model->find_employee();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_find_phone()
	{
		$data = $this->model->find_phone();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_find_fio()
	{
		$data = $this->model->find_fio();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_create_profile()
	{
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_save_profile()
	{
		$data = $this->model->save_profile();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_applications()
	{
		$data = $this->model->applications();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_application_to_archive()
	{
		$this->model->application_to_archive();		
	}
	
	function action_messages()
	{
		$data = $this->model->messages();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_messages_list()
	{
		$this->model->messages_list();
	}
	
	function action_message_reply()
	{
		$this->model->message_reply();
	}
	
	function action_message_to_archive()
	{
		$this->model->message_to_archive();
	}
		
	function action_delete_message()
	{
		$this->model->delete_message();
	}
	
	function action_send_message()
	{
		$data = $this->model->send_message();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_check_rielter()
	{
		$data = $this->model->check_rielter();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_callboard()
	{
		$data = $this->model->callboard();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_order()
	{
		$data = $this->model->order();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_forum()
	{
		$data = $this->model->forum();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_recipients()
	{
		$data = $this->model->recipients();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_order_check()
	{
		$this->model->order_check();
	}
	
	function action_enter_statistics(){
		$data = $this->model->enter_statistics();
		$this->view->generate('enter_statistic_view.php', 'template_view.php', $data);
	}
	
	function action_change_group_id(){
		$this->model->change_group_id();
	}
	
	function action_services_list_show(){
		$data = $this->model->services_list_show();
		$this->view->generate('services_list_view.php', 'template_view.php', $data);
	}
	
	function action_order_list_show(){
		$data = $this->model->order_list_show();
		$this->view->generate('order_list_view.php', 'template_view.php', $data);
	}
	
	function action_functional_description(){
		$data = $this->model->functional_description();
		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
	
	function action_check_input(){
		$this->model->check_input();
	}
	
	function action_order_to_archive(){
		$this->model->order_to_archive();
	}
		
	function action_delete_order(){
		$this->model->delete_order();
	}

	function action_delete_tinkoff_payment(){
		$this->model->delete_tinkoff_payment();
	}

	function action_delete_statistic()
	{
		$data = $this->model->delete_statistic();
	}
	
	function action_delete_callboard()
	{
		$data = $this->model->delete_callboard();
	}
	
	function action_delete_parse()
	{
		$data = $this->model->delete_parse();
	}
	
	function action_trusted()
	{
		$data = $this->model->trusted();
	}
	
	function action_delete_photos()
	{
		$data = $this->model->delete_photos();
	}
	
	function action_delete_employe()
	{
		$data = $this->model->delete_employe();
	}
	
	function action_block_an()
	{
		$data = $this->model->block_an();
	}	
	
	function action_delete_an()
	{
		$data = $this->model->delete_an();
	}
	
	function action_new_street()
	{
		$data = $this->model->new_street();
	}
	
	function action_change_status()
	{
		$data = $this->model->change_status();
	}
	
	function action_find_dismiss_people()
	{
		$data = $this->model->find_dismiss_people();
	}
	
	function action_update_archive_interval()
	{
		$this->model->update_archive_interval();
	}
}

?>