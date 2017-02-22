<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class EventsFollowersTable extends Table
{
	
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users');
    }

}