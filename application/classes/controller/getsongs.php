<?php defined('SYSPATH') OR die('No Direct Script Access');
 
Class Controller_getsongs extends Controller
{
    function action_index()
    {
        $hmxDataHelper = new Model_HMXData;
        $view = View::factory('json');
        $view->set('jsondata', $hmxDataHelper->getAllSongs());
        $view->set('callback', $_REQUEST['callback']);
        $this->request->response = $view;
    }
}
