<?php

class Controller_Tinkoff extends Controller
{
    function __construct()
    {
        $this->model = new Model_Tinkoff();
        parent::__construct();
    }


    function action_notty()
    {
        $this->model->notty();
    }

    function action_get_state()
    {
        $data = $this->model->getState(
            Helper::FilterVal('PaymentId')
                ? ['PaymentId' => Helper::FilterVal('PaymentId')]
                : []
        );
        $this->view->generate('tinkoff_view.php', 'template_view.php', $data);
    }

    function action_create_payment()
    {
        $data = $this->model->create_payment();
        $this->view->generate('','tinkoff_view.php',  $data);
    }
}