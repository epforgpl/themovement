<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class RegistrationsTable extends Table
{
	
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('EventsDays');
        $this->belongsTo('Users');
    }

}