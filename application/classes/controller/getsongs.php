<?php defined('SYSPATH') OR die('No Direct Script Access');
 
Class Controller_getsongs extends Controller
{
    function action_index()
    {
        $recache = $this->determine_recaching();
        $hmxDataHelper = new Model_HMXData;
        $view = View::factory('json');
        
        $view->set('jsondata', $hmxDataHelper->getAllSongs($recache));
        $view->set('callback', $_REQUEST['callback']);
        $this->request->response = $view;
    }
    
    private function determine_recaching() {
      $recache = false;
      if (isset($_REQUEST['recache']) && $_REQUEST['recache'] == 'true') {
          $recache = true;
      }
      return $recache;
    }
}
