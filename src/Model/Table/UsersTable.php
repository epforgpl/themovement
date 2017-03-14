<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;

class UsersTable extends Table
{
	
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Professions');
        $this->hasMany('Registrations');
    }
	
	public function beforeSave($event, $entity, $options)
	{
		
		$_slug = strtolower( Inflector::slug( $entity->name ) );
		$slug = $_slug;
		$i = 0;
		
		while( true ) {
			
			if( $i )
				$slug = $_slug . '-' . $i;
				
			
			$user = $this->find('all', [
				'conditions' => [
					'slug' => $slug,
				],
			])->first();
			
			if( !$user ) {
				break;
			}
			
			$i++;
			
		}
		
		$entity->slug = $slug;
		
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
				
				if( !isset($data['organization']) ) {
					$data['organization'] = false;
					$data['organization_name'] = '';
					$data['organization_www'] = '';
					$data['organization_role'] = '';
				}
				
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
	
	public function markRegistrationMails()
	{
		
		$users = $this->find()->select('id')->where([
			'Users.registration_mail' => 0,
		])->notMatching('Registrations', function ($q) {
			return $q;
		})->toArray();
		
		foreach( $users as $u ) {
			
			$u->registration_mail = 1;
			$this->save($u);
			
		}		
		
	}
	
}