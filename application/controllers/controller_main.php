<?php

class Controller_Main extends Controller
{
	function __construct()
	{
		$this->model = new Model_Main();
		$this->view = new View();
	}
	
	function action_out()
	{
		$data = $this->model->get_data();		
		$this->view->generate('out_view.php', 'out_view.php', $data);
	}
	
	function action_index()
    {
//        if(isset($_SESSION['fio'])) {
//            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/?task=main&action=pay_parse&parent_id=1&topic_id=2");
//        }
		$this->view->generate('main_view.php', 'template_view.php', $this->model->get_data());
	}
	
	function action_parse()
	{
        if($_SESSION["tariff_id"] == '1'){
            header("Location: http://{$_SERVER['SERVER_NAME']}/?task=main&action=index&topic_id={$_SESSION['topic_id']}&parent_id=1");
        }
		$data = $this->model->parse();		
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
	
	function action_pay_parse()
	{
        if($_SESSION["tariff_id"] == '1'){
            header("Location: http://{$_SERVER['SERVER_NAME']}/?task=main&action=index&topic_id={$_SESSION['topic_id']}&parent_id=1");
        }
		$data = $this->model->pay_parse();		
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
	
	function action_check_var()
	{
		$data = $this->model->check_var();		
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
	
	function action_get_type()
	{
		$data = $this->model->get_type();		
		//$this->view->generate('main_view.php', 'template_view.php', $data);
	}
	
	function action_search()
	{
		$data = $this->model->search();	
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
	
	function action_search_street()
	{
		//$data = 
		$this->model->search_street();		
		//$this->view->generate('newvar_view.php', 'template_view.php', $data);
	}
	
	function action_street_in_parse(){
		$this->model->street_in_parse();
	}
	
	function action_get_search_template()
	{
		if($_POST['template']) {
			include_once "application/search_templates/". $_POST['template'] .".php";
		} else {
			echo 'извините произошла ошибка.';
		}
	}
	
	function action_save_limit()
	{
		$this->model->save_limit();
		
	}
	
	function action_save_page()
	{
		$this->model->save_page();		
	}
	
	function action_refresh()
	{
		$this->model->refresh();
	}
	
	function action_advanced_view()
	{
		$data = $this->model->another_view();
		$this->view->generate('product_view.php', 'template_view.php', $data);
	}
	
	function action_compact_view()
	{
		$data = $this->model->another_view();
		$this->view->generate('compact_view.php', 'template_view.php', $data);
	}

}
?>