<?php

class Controller_Map extends Controller
{
	function __construct()
	{
		$this->model = new Model_Map();
		$this->view = new View();
	}
	
	function action_get_coords()
	{
		$this->model->get_coords();		
	}
	
	function action_get_data_by_coords()
	{
		$this->model->get_data_by_coords();
	}

    function action_coord_by_address()
    {
        echo $this->model->get_coord_by_address();

    }

    function action_points_on_poligon()
    {
        $this->model->get_points_on_poligon();

    }

    function action_encodePoligonPoints()
    {
        $this->model->encodePoligonPoints();

    }

    function action_map_tolist()
	{
		$data = $this->model->map_tolist();		
		$this->view->generate('product_compact_view.php', 'template_view.php', $data);
	}
}

?>