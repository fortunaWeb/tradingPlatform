<?php
class Controller_Profile extends Controller
{
	function __construct()
	{
		$this->model = new Model_Profile();
		$this->view = new View();
	}
	
	function action_index()
	{
		$data = $this->model->get_data();		
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_mytype()
	{
		$data = $this->model->get_data_type();
		$this->view->generate('mytype_view.php', 'template_view.php', $data);
	
	}

	function action_mysample()
	{
		$data = $this->model->my_sample();
		$this->view->generate('my_sample.php', 'template_view.php', $data);
	
	}

	
	function action_create_payment_tinkoff()
	{
		$data = $this->model->create_payment_tinkoff();
	}

	function action_edit()
	{
		$data = $this->model->get_data_edit();
		$this->view->generate('newvar_view.php', 'template_view.php', $data);
	}

	function action_deletevar()
	{
		$data = $this->model->deletevar();		
		$this->view->generate('delete_view.php', 'template_view.php', $data);
	}
	
	function action_newvar()
	{
		$data = $this->model->newvar();		
		if($_SESSION['moblile']){
			$this->view->generate('newvar_mobile_view.php', 'template_view.php', $data);
		}else{
			$this->view->generate('newvar_view.php', 'template_view.php', $data);	
		}
		
	}
	
	function action_edit_group(){
		$this->model->edit_group();
	}
	
	function action_newvar_old()
	{
		$data = $this->model->newvar_old();		
		$this->view->generate('newvar_old_view.php', 'template_fortunasib_view.php', $data);
	}
	
	function action_savevar_old()
	{
		$data = $this->model->savevar_old();
		$this->view->generate('savevar_old_view.php', 'template_view.php', $data);
	}
	
	function action_search_street()
	{
		$this->model->search_street();	
	}
	
	function action_search_city(){
		$this->model->search_city();	
	}
	
	function action_search_an()
	{
		$this->model->search_an();	
	}
		
	function action_add_photo()
	{
		$this->model->savevar();
	}

    function action_edit_sample()
    {
        $data = $this->model->get_data_edit_sample();
        $this->view->generate('new_samplevar_view.php', 'template_view.php', $data);
    }

    function action_sample_add()
    {
        $data = $this->model->saveSample();
        $this->view->generate('new_samplevar_view.php', 'template_view.php', $data);
    }

    function action_collect_sample()
    {
        $this->model->collectSample();
    }

	function action_archive()
	{
		$data = $this->model->archive();		
		$this->view->generate('archive_view.php', 'template_view.php', $data);
	}
	
	function action_archive_list()
	{
		$data = $this->model->archive_list();		
		$this->view->generate('mytype_view.php', 'template_view.php', $data);
	}
	
	function action_from_archive()
	{
		$data = $this->model->from_archive();		
		$this->view->generate('from_archive_view.php', 'template_view.php', $data);
	}
	
	function action_change_profile()
	{
		$data = $this->model->change_profile();		
		$this->view->generate('change_profile_view.php', 'template_view.php', $data);
	}
		
	function action_change_user(){
		$this->model->change_user();
	}	
	
	function action_create_child_profile() 
	{	
		$this->view->generate('create_child_profile_view.php', 'template_view.php');
	}
	
	function action_favorites()
	{
		$data = $this->model->get_data_type();		
		$this->view->generate('mytype_view.php', 'template_view.php', $data);
	}
	
	function action_favorites_parse()
	{
		$data = $this->model->get_data_type();		
		$this->view->generate('mytype_view.php', 'template_view.php', $data);
	}
	
	function action_favorites_pay_parse()
	{
		$data = $this->model->get_data_type();		
		$this->view->generate('mytype_view.php', 'template_view.php', $data);
	}

	function action_clear_favorites()
	{
		$data = $this->model->clear_favorites();		
	}

	function action_sample()
	{
		$data = $this->model->sample();		
		$this->view->generate('mytype_view.php', 'template_view.php', $data);
	}

	
	function action_recipients()
	{
		$data = $this->model->recipients();
		$this->view->generate('mytype_view.php', 'template_view.php', $data);
	}
	
	function action_forum_rent_add()
	{
		$this->model->forum_rent_add();				
	}
	
	function action_save_profile()
	{
		$this->model->save_profile();				
	}
	
	function action_get_template()
	{
		$data = $this->model->get_template();

        if ($data['type_id'] == 1) {
            include_once 'application/type_templates/sell/type_1_view.php';
        } else if ($data['type_id'] == 2) {
            include_once 'application/type_templates/sell/type_2_view.php';
        } else if ($data['type_id'] == 3) {
            include_once 'application/type_templates/sell/type_3_view.php';
        } else if ($data['type_id'] == 4) {
            include_once 'application/type_templates/sell/type_4_view.php';
        } else if ($data['type_id'] == 5) {
            include_once 'application/type_templates/sell/type_5_view.php';
        } else if ($data['type_id'] == 6) {
            include_once 'application/type_templates/sell/type_6_view.php';
        } else if ($data['type_id'] == 7) {
            include_once 'application/type_templates/sell/type_7_view.php';
        }
	}
	

	function action_delete_profile()
	{
		$this->model->delete_profile();
	}
	
	function action_add_sample()
	{
		$this->model->add_sample();
	}
	
	function action_sample_delete_var()
	{
		$this->model->sample_delete_var();
	}
	


	function action_delete_sample()
	{
		$this->model->delete_sample();
	}

	function action_clear_sample()
	{
		$this->model->clear_sample();
	}

	function action_sample_add_var()
	{
		$this->model->sample_add_var();
	}


	
	function action_profile_to_archive()
	{
		$this->model->profile_to_archive();
	}
	
	function action_add_favorites()
	{
		$data = $this->model->add_favorites();
		echo ($data);
	}
	
	function action_remove_from_favorites(){
		$this->model->remove_from_favorites();
	}
	
	function action_var_extend()
	{
		$data = $this->model->var_extend();
		echo ($data);
	}
	function action_var_extend_one()
	{
		$data = $this->model->var_extend_one();
		echo ($data);
	}
		
	function action_create_login()
	{
		if($_POST['create']) {
			$this->model->create_login();
			header("Location: http://". $_SERVER['SERVER_NAME']."/?task=admin&action=user_list");
		} else {
			$data = $this->model->show_formnew();		
			$this->view->generate('show_formnew_view.php', 'template_view.php', $data);
		}
	}
	
	function action_add_phone()
	{
		$this->model->add_phone();
	}
	
	function action_add_email_work()
	{
		$this->model->add_email_work();
	}
	
	function action_add_email_pass()
	{
		$this->model->add_email_pass();
	}

	function action_add_external_login()
	{
		$this->model->add_external_login();
	}

	function action_add_external_pass()
	{
		$this->model->add_external_pass();
	}

	function action_set_photo_limit()
	{
		$this->model->set_photo_limit();
	}
	
	function action_add_ip()
	{
		$this->model->add_ip();
	}
	
	function action_del_ip()
	{
		$this->model->del_ip();
	}

	function action_delete_session()
	{
		$this->model->delete_session();
	}
	
	function action_update_ip()
	{
		$this->model->update_ip();
	}
	
	function action_phone_to_archive()
	{
		$this->model->phone_to_archive();
	}
	
	function action_delete_phone()
	{
		$this->model->delete_phone();
	}
	
	// function action_applications()
	// {
		// $data = $this->model->applications();
		// $this->view->generate('applications_view.php', 'template_view.php', $data);
	// }
	
	function action_user_activation()
	{
		$this->model->user_activation();
	}
	
	function action_employee_list()
	{
		$data = $this->model->employee_list();
		$this->view->generate('employee_list_view.php', 'template_view.php', $data);
	}	
	
	function action_an_info()
	{
		$this->model->an_info();
	}
	
	function action_send_review()
	{
		$this->model->send_review();
	}	
	
	function action_check_comment_set()
	{
		$this->model->check_comment_set();
	}
	
	function action_messages()
	{
		$data = $this->model->messages();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_send_message()
	{
		$data = $this->model->send_messages();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}

    function action_order()
    {
        $data = $this->model->order();
        $this->view->generate('profile_view.php', 'template_view.php', $data);
    }

    function action_order_txt()
    {
        $data = $this->model->order_txt();
        $this->view->generate('profile_view.php', 'template_view.php', $data);
    }

    function action_order_send()
	{
		$data = $this->model->order_send();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_check_rielter()
	{
		$data = $this->model->check_rielter();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_callboard()
	{
		$data = $this->model->callboard();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_create_profile(){
		$data = $this->model->create_profile();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_user_list()
	{
		$data = $this->model->employee_list();		
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}	
	
	function action_services()
	{
		$data = $this->model->services();		
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_forum()
	{
		$data = $this->model->forum();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_forum_rent()
	{
		$data = $this->model->forum();
		$this->view->generate('forum_rent_view.php', 'template_view.php', $data);
	}
	
	function action_forum_comments()
	{
		$data = $this->model->forum_comments();
		$this->view->generate('forum_comments_view.php', 'template_view.php', $data);
	}
	
	function action_delete_from_forum()
	{
		$this->model->delete_from_forum();
	}

	function action_services_payment()
	{
		$this->model->services_payment();
	}

	function action_services_pay()
	{
        $data = $this->model->services_pay();
		$this->view->generate('tinkoff_success_view.php', 'template_view.php', $data);

	}

	function action_find_rielter()
	{
		$this->model->find_rielter();
	}
	
	function action_tariffs()
	{
        $data = $this->model->get_data_tarifs();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_rules()
	{
        $data = $this->model->get_data_rules();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_contacts()
	{
		$this->view->generate('profile_view.php', 'template_view.php', null);
	}
	
	function action_caution()
	{
		$data = $this->model->caution();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_delete_caution()
	{
		$data = $this->model->delete_caution();
	}
	
	function action_lists()
	{
		$data = $this->model->lists();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_update()
	{
		$data = $this->model->update();
	}
	function action_updateById()
	{
		$data = $this->model->updateById();
	}
	
	function action_delete()
	{
		$data = $this->model->delete();
	}

	function action_coord_by_address()
	{
		$this->model->coord_by_address();
	}

	function action_find_on_phone()
	{
		$this->model->find_on_phone();
	}
	


	function action_for_open_site()
	{
		$this->model->for_open_site();
	}
	
	function action_session_update()
	{
		$this->model->session_update();
	}
	
	function action_group_setting()
	{
		$data = $this->model->group_setting();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}
	
	function action_delete_callboard()
	{
		$data = $this->model->delete_callboard();
	}
}
