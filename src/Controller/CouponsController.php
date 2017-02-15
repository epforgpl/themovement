<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\App;

class CouponsController extends AppController
{
    
    public function check() {
	    
	    $res = false;
	    
	    if(
	    	( $code = @$this->request->query['code'] ) && 
	    	( $event_id = @$this->request->query['event_id'] )
    	) {
		    $res = $this->Coupons->check($code, $event_id);
	    }
	    
	    $this->set('res', $res);
	    $this->set('_serialize', 'res');
	    
    }
    
}