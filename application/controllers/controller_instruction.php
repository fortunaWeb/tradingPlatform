<?php
class Controller_Instruction extends Controller
{
	function __construct()
	{
		$this->model = new Model_Instruction();
		$this->view = new View();
	}
	
	function action_index()
	{
		$data = $this->model->get_data();		
		$this->view->generate('instruction_view.php', 'template_view.php', $data);
	}
}
?>