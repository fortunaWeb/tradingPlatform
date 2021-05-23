<?php

class Controller_Media extends Controller
{

	function __construct()
	{
		$this->model = new Model_Media();
		$this->view = new View();
	}
	
	function action_push_photo()
	{
		$data = $this->model->push_photo();
	//	echo $data;
		
	}
	
	function action_get_photos() 
	{
		$data = $this->model->get_photos();
		echo $data;
	}
	
	function action_delete_photo()
	{
		$data = $this->model->delete_photo();
		echo $data;
	}
	
	function action_rotate()
	{
		$this->model->rotate();
	}
}

