<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Mailer\Email;

class CouponsTable extends Table
{
	
	public function check($code, $event_id) {
		
		$coupon = $this->find('all', [
			'conditions' => [
				'code' => $code,
				'event_id' => $event_id,
				'used' => false,
			],
		])->first();
		
		return (boolean) $coupon;
		
	}
	
	public function sendInstructions($coupon) {
		
		$email = new Email('default');
			
		$msg = '';
		
		if( $coupon->name )
			$msg .= 'Hi ' . $coupon->name . '!' . "\n\n";
			
		$msg .= 'Here is your coupon for registering to Personal Democracy Forum CEE 2017!' . "\n";
		$msg .= 'Coupon code: ' . $coupon->code;
					
		$status = $email->from(['events@themovement.io' => 'The Movement'])
		    ->to([$coupon->email => $coupon->name])
		    ->subject('Your coupon for Personal Democracy Forum CEE 2017')
		    ->template('coupon')
		    ->send([$msg]);
			    			
		return (boolean) $status;
		
	}

}