<?php

class Controller_Var extends Controller
{

	function __construct()
	{
		$this->model = new Model_Var();
		$this->view = new View();
	}
	
	function action_index()
	{
		$data = $this->model->get_data();
		$this->view->generate('var_view.php', 'template_view.php', $data);
	}
	
	function action_list_photos_mobile()
	{
		$this->model->list_photos_mobile();		
	}

	function action_list_photos_pay_parse_mobile()
	{
		$this->model->list_photos_pay_parse_mobile();		
	}

	function action_photo_list()
	{
		$this->model->photo_list();		
	}
	
	function action_black_list_comments()
	{
		$this->model->black_list_comments();
	}
	
	function action_add_to_black_list()
	{
		$this->model->add_to_black_list();
	}
	
	function action_review_list_for_rielter()
	{
		$this->model->review_list_for_rielter();
	}
	
	function action_delete_black_list_comment()
	{
		$this->model->delete_black_list_comment();
	}
	
	function action_send_favorites_to_email()
	{
		$this->model->send_favorites_to_email();
	}
	
	function action_employee_list()
	{
		$this->model->employee_list();
	}
	
	function action_change_owner()
	{
		$this->model->change_owner();
	}
	
	function action_contacts_hide()
	{
		$this->model->contacts_hide();
	}
	
	function action_contacts_show()
	{
		$this->model->contacts_show();
	}
	
	function action_send_var_to_email()
	{
		$this->model->send_var_to_email();
	}
	
	function action_photo_statistic()
	{
		$data = $this->model->photo_statistic();
		$this->view->generate('photo_statistic_view.php', 'template_view.php', $data);
	}
	
	function action_street_check()
	{
		$this->model->street_check();
	}
	
	function action_delete_recipients()
	{
		$this->model->delete_recipients();
	}
	
	function action_save_search()
	{
		$this->model->save_search();
	}
	
	function action_update_save_search(){
		$this->model->update_save_search();
	}
}

?>