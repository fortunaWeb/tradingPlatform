<?php

class Controller_Services extends Controller
{

	function action_index()
	{
        $this->view->generate('services_view_tinkoff.php', 'template_view.php');
	}
}
