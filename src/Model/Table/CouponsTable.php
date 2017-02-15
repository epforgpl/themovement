<?php
namespace App\Model\Table;

use Cake\ORM\Table;

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

}