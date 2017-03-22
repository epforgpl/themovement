<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class EventsTable extends Table
{
	
	public function initialize(array $config)
    {
        $this->hasMany('Registrations');
        $this->hasMany('EventsDays');
        $this->hasMany('EventsSessions');
        $this->belongsToMany('Users', [
	        'through' => 'Registrations',
        ]);
        /*
        $this->hasMany('Followers', [
	        'className' => 'Users',
	        'joinTable' => 'events_followers',
        ]);
        */
        $this->belongsToMany('Organizations');
        $this->belongsToMany('RelatedEvents', [
	        'className' => 'Events',
	        'joinTable' => 'events_related',
	        'foreignKey' => 'parent_id',
	        'targetForeignKey' => 'child_id',
        ]);
    }

}