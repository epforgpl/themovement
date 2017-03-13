<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;

class RegistrationsTable extends Table
{
	
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('EventsDays');
        $this->belongsTo('Users');
    }
    
    public function sendConfirmation( $registration ) {
	    
	    if( !is_object($registration) ) {
		    $registration = TableRegistry::get('Registrations')->get($registration);
	    }
	    
	    if(
		    $registration && 
		    $registration->user_id && 
		    ( $user = TableRegistry::get('Users')->get($registration->user_id) ) && 
		    ( $event = TableRegistry::get('Events')->get($registration->event_id) )
	    ) {
	    		    	 	
		    $email = new Email('default');
			
			$msg = '';
			
			if( $user->first_name )
				$msg .= 'Hi ' . $user->first_name . ",\n\n";
				
			$msg .= "Thank you for registering to " . $event->name . "!\n";
			
			if( $event->registration_mail )
				$msg .= "\n" . $event->registration_mail;
																
			$status = $email->from(['events@themovement.io' => 'The Movement Events'])
			    ->to([$user->email => $user->name])
			    ->subject( $event->name )
			    ->template('register')
			    ->send([$msg]);
		    
		}
	    
    }
    
    public function sendQuestion( $registration ) {
	    
	    if( !is_object($registration) ) {
		    $registration = TableRegistry::get('Registrations')->get($registration);
	    }
	    
	    if(
		    $registration && 
		    $registration->user_id && 
		    ( $user = TableRegistry::get('Users')->get($registration->user_id) ) && 
		    ( $event = TableRegistry::get('Events')->get($registration->event_id) )
	    ) {
	    		    	 	
		    $email = new Email('default');
			
			$msg = '';
			
			if( $user->first_name )
				$msg .= 'Hi ' . $user->first_name . ",";
																				
			$status = $email->from(['events@themovement.io' => 'The Movement Events'])
			    ->to([$user->email => $user->name])
			    ->subject( $event->name )
			    ->template('ask')
			    ->send([$msg]);
		    
		}
	    
    }

}