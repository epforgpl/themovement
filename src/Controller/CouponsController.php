<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\App;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\ConflictException;
use Cake\Network\Exception\InternalErrorException;

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
    
    public function add() {
	    	    	        
	    if(
	    	( $code = @$this->request->data['code'] ) &&
	    	( $event_id = @$this->request->data['event_id'] )
    	) {
		    
		    $coupon_data = [
			    'code' => $code,
			    'event_id' => $event_id,
		    ];
		    $coupon = $this->Coupons->find('all', [
			    'conditions' => $coupon_data,
		    ])->first();
		    
		    if( !$coupon ) {
			    
			    $coupon = $this->Coupons->newEntity($coupon_data);
			    
			    if( @$this->request->data['send'] && ( $this->request->data['send'] != 'false' ) ) {
			    	if(
				    	( $name = @$this->request->data['name'] ) && 
				    	( $email = @$this->request->data['email'] ) 
			    	) {
				    	
				    	$coupon->send = true;
				    	$coupon->name = $name;
				    	$coupon->email = $email;
				    	
			    	} else { throw new \Cake\Network\Exception\BadRequestException(); }
		    	} else {
			    	
			    	$coupon->send = false;
			    	
		    	}
			    
			    if( $this->Coupons->save($coupon) ) {			    	
			    	
			    	if( $coupon->send ) {
			    		$coupon->send_status = $this->Coupons->sendInstructions($coupon);
			    	}
			    	
				    $this->set('coupon', $coupon);
				    $this->set('_serialize', 'coupon');
			    
			    } else { throw new \Cake\Network\Exception\InternalErrorException(); }
		    } else { throw new \Cake\Network\Exception\ConflictException(); }
	    } else { throw new \Cake\Network\Exception\BadRequestException(); }
	    	    
    }
    
}