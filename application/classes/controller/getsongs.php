<?php defined('SYSPATH') OR die('No Direct Script Access');
 
Class Controller_getsongs extends Controller
{
    function action_index()
    {
        $view = View::factory('json');

        //make sure they passed in a callback
        if (!isset($_REQUEST['callback'])) {
          $view->set('callback', 'HMXSongsCallbackErrorHandler');
          $view->set('jsondata', Array('error'=>'No Callback Specified'));
        }
        //if they did, we continue
        else {
          $recache = $this->determine_recaching();
          $hmxDataHelper = new Model_HMXData;
          
          $view->set('jsondata', $hmxDataHelper->getAllSongs($recache));
          $view->set('callback', $_REQUEST['callback']);
        }
        //render
        $this->request->response = $view;
    }
    //helper function for determining if a recache request was made
    private function determine_recaching() {
      $recache = false;
      if (isset($_REQUEST['recache']) && $_REQUEST['recache'] == 'true') {
          $recache = true;
      }
      return $recache;
    }
}
