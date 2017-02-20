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
		    ( $user = TableRegistry::get('Users')->get($registration->user_id) )
	    ) {
	    		    	
		    $email = new Email('default');
												
			$status = $email->from(['events@themovement.io' => 'The Movement'])
			    ->to([$user->email => $user->name])
			    ->subject('Personal Democracy Forum CEE 2017')
			    ->template('register')
			    ->send([$user->first_name]);
		    
		}
	    
    }

}