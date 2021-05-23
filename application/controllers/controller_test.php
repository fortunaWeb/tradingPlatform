<?php
class Controller_Test extends Controller
{
	function __construct()
	{
		$this->model = new Model_Test();
		$this->view = new View();
	}
	
	function action_site()
	{
		$data = $this->model->site();		
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
	
	function action_parse()
	{
		$data = $this->model->parse();		
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
	
	function action_pay_parse()
	{
		$data = $this->model->pay_parse();		
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
}
?>