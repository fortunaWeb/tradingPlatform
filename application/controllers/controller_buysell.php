<?php

class Controller_Buysell extends Controller
{
	function __construct()
	{
		$this->model = new Model_buysell();
		$this->view = new View();
	}

    function action_parse_var_clone()
    {

        if(!empty($this->model->parse_var_clone())){
            echo 'oK';
        }

    }

    function action_var_clone()
    {

        if(!empty($this->model->var_clone())){
            echo 'oK';
        }

    }

	function action_index()
	{
		$data = $this->model->parse_buysell();		
		$this->view->generate('buysell_view.php', 'template_buysell_view.php', $data);
	}
	
	function action_parse_buysell()
	{
		$data = $this->model->parse_buysell();		
		$this->view->generate('buysell_view.php', 'template_buysell_view.php', $data);
	}

	function action_check_var()
	{
		$data = $this->model->check_var();		
		$this->view->generate('buysell_view.php', 'template_buysell_view.php', $data);
	}
	
	function action_get_type()
	{
		$data = $this->model->get_type();
	}
	
	function action_search()
	{
		$data = $this->model->search();	
		$this->view->generate('buysell_view.php', 'template_buysell_view.php', $data);
	}
	
	function action_street_in_parse()
	{
		$this->model->street_in_parse();
	}
	
	function action_street_in_parse_buysell(){
		$this->model->street_in_parse_buysell();
	}
	
	function action_get_search_template()
	{
		if($_POST['template']) {
			include_once "application/search_templates/". $_POST['template'] .".php";
		} else {
			echo 'извините произошла ошибка.';
		}
	}

    function action_mysample()
    {
        $data = $this->model->my_sample();
        $this->view->generate('my_sample.php', 'template_view.php', $data);

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
		$this->view->generate('product_view.php', 'template_buysell_view.php', $data);
	}
	
	function action_compact_view()
	{
		$data = $this->model->another_view();
		$this->view->generate('compact_view.php', 'template_buysell_view.php', $data);
	}


}
?>