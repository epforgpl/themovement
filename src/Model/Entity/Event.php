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
	
	public function groupRelatedEvents()
	{
		
		$groups = [];
		
		if( $this->related_events ) {
			
			$labels = [
				1 => 'Core Events',
				2 => 'Satellite Events',
			];
						
			foreach( $this->related_events as $r ) {
								
				$groups[ $r['_joinData']->type ]['type'] = [
					'id' => $r['_joinData']->type,
					'label' => array_key_exists($r['_joinData']->type, $labels) ? $labels[ $r['_joinData']->type ] : 'See also',
				];
				$groups[ $r['_joinData']->type ]['events'][] = $r;
				
			}
			
			$groups = array_values($groups);
						
		}
		
		return $groups;
		
	}

}