<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class EventsOrganizationsRolesTable extends Table
{
	
	public function initialize(array $config)
    {
        $this->belongsToMany('Organizations', [
	        'through' => 'EventsOrganizations',
	        'foreignKey' => 'role_id',
        ]);
    }

}