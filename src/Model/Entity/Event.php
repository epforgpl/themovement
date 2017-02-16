<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Event extends Entity
{

	public function getUrl()
	{
		return '/events/' . $this->slug;
	}
	
	public function groupOrganizations()
	{
		
		$groups = [];
		
		if( $this->organizations ) {
			
			$roles = [
				1 => 'Organizers',
				2 => 'Co-organisers',
				3 => 'Sponsors',
				4 => 'Partners',
			];
						
			foreach( $this->organizations as $o ) {
				$groups[ $o['_joinData']->role_id ]['role'] = [
					'id' => $o['_joinData']->role_id,
					'name' => array_key_exists($o['_joinData']->role_id, $roles) ? $roles[ $o['_joinData']->role_id ] : '',
				];
				$groups[ $o['_joinData']->role_id ]['organizations'][] = $o;
			}
			
			$groups = array_values($groups);
						
		}
		
		$this->organizations_groups = $groups;
	}

}