<?php

class Controller_External extends Controller
{
	function __construct()
	{
		$this->model = new Model_External();
		$this->view = new View();
	}
	
	function action_index()
	{
		$data = $this->model->get_data();		
		$this->view->generate('external_view.php', 'template_external_view.php', $data);
	}

	function action_photo()
	{
		$data = $this->model->photo();		
		$this->view->generate('external_photo.php', 'template_external_view.php', $data);
	}


}
?>