<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Inflector;

class UsersTable extends Table
{
	
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Professions');
    }
	
	public function beforeSave($event, $entity, $options)
	{
		
		$entity->slug = strtolower( Inflector::slug( $entity->name ) );
		
	}
	
	public function updateProfile($user_id, $data) {
		
		if( $user = $this->get($user_id) ) {
			
			$validator = new Validator();
			$validator
				->requirePresence('country')
			    ->notEmpty('country', 'Please provide your country.')
			    ->requirePresence('birthdayYear')
			    ->notEmpty('birthdayYear', 'Please provide your birthday year.')
			    ->requirePresence('birthdayMonth')
			    ->notEmpty('birthdayMonth', 'Please provide your birthday month.')
			    ->requirePresence('birthdayDay')
			    ->notEmpty('birthdayDay', 'Please provide your birthday day.')
			    ->requirePresence('gender')
			    ->notEmpty('gender', 'Please provide your gender.');
			
			$errors = $validator->errors($data);
			if( empty($errors) ) {
									
				$data['birthday'] = $data['birthdayYear'] . '-' . $data['birthdayMonth'] . '-' . $data['birthdayDay'];
					
				$this->patchEntity($user, $data, [
				    'fieldList' => ['organization', 'organization_name', 'organization_www', 'organization_role', 'other_profession', 'about', 'gender', 'country', 'birthday', 'professions'],
				    'associated' => ['Professions']
			    ]);
			    
			    $this->save($user);
		    
		    }
		    
		    return $errors;
						
		} else {
			return false;
		}
				
	}
	
}