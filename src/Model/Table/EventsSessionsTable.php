<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class EventsSessionsTable extends Table
{
	
	public function initialize(array $config)
    {
        $this->hasMany('EventsSubsessions');
    }

}