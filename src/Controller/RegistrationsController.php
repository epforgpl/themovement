<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\App;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\ConflictException;
use Cake\Network\Exception\InternalErrorException;

class RegistrationsController extends AppController
{
    
    public function finish() {
	    
	    $this->checkAccess('admin');
	    	      
	    if(
	    	( $id = @$this->request->data['id'] ) &&
	    	( isset( $this->request->data['send'] ) )
    	) {
		    		    
		    $registration = $this->Registrations->get($id, [
			    'contain' => [
				    'Users'
			    ],
		    ]);
		    
		    if( !$registration->status ) {
			    
			    $this->Registrations->patchEntity($registration, [
				    'status' => 1,
			    ]);
			    $res = $this->Registrations->save($registration);
			    			    
			    if( $this->request->data['send'] && ( $this->request->data['send'] != 'false' ) ) {
				    
				    $this->Registrations->sendConfirmation( $registration );
				    
			    }
			    
			    $this->set('status', true);
			    $this->set('_serialize', ['status']);	    
			    
		    } else { throw new \Cake\Network\Exception\BadRequestException('This registration is already finished'); }
	    } else { throw new \Cake\Network\Exception\BadRequestException(); }
	    	    
    }
    
    public function ask() {
	    
	    $this->checkAccess('admin');
	    	      
	    if( $id = @$this->request->data['id'] ) {
		    		    
		    $registration = $this->Registrations->get($id, [
			    'contain' => [
				    'Users'
			    ],
		    ]);
		    
		    if( !$registration->status==2 ) {
			    
			    $this->Registrations->patchEntity($registration, [
				    'status' => 2,
			    ]);
			    $res = $this->Registrations->save($registration);
			    			    
			    $this->Registrations->sendQuestion( $registration );
			    
			    $this->set('status', true);
			    $this->set('_serialize', ['status']);	    
			    
		    } else { throw new \Cake\Network\Exception\BadRequestException('The question for this registration has already been sent'); }
	    } else { throw new \Cake\Network\Exception\BadRequestException(); }
	    	    
    }
    
}