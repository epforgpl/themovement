<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class OrganizationsTable extends Table
{
	
	public function initialize(array $config)
    {
        $this->belongsToMany('EventsOrganizationsRoles', [
	        'through' => 'EventsOrganizations',
	        'bindingKey' => 'role_id'
        ]);
    }

}