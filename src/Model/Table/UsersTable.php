<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Inflector;
use Cake\Mailer\Email;

class UsersTable extends Table
{
	
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Professions');
        $this->belongsTo('Countries', [
	        'foreignKey' => 'country',
	        'bindingKey' => 'iso',
	        'propertyName' => 'country',
        ]);
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
	
	public function sendRegistrationMails()
	{
		
		$users = $this->find('all', [
			'conditions' => [
				'registration_mail' => 1,
			],
		]);
		
		foreach( $users as $u ) {
			$this->sendRegistrationMail( $u->id );
		}
		
	}
	
	public function sendRegistrationMail($user_id)
	{
		
		if( $user = $this->find('all', ['conditions' => ['id' => $user_id]])->first() ) {
						
			$email = new Email('default');
			
			$msg = '';
			if( $user->first_name )
				$msg .= 'Hi ' . $user->first_name . ",";
			
			$status = $email->from(['events@themovement.io' => 'The Movement Events'])
			    ->to([$user->email => $user->name])
			    ->subject('Registration for Personal Democracy Forum CEE 2017')
			    ->template('without_registration')
			    ->send([$msg]);
			
			$user->registration_mail = 2;
			$this->save($user);
			
		}
		
	}
	
	public function sendInfopackMails()
	{
		
		$users = $this->find('all', [
			'conditions' => [
				'infopack_mail' => false,
			],
		]);
		
		foreach( $users as $user ) {
			
			$email = new Email('default');
			
			debug('Sending mail to ' . $user->name . ' [' . $user->email . ']');
			
			$msg = '';
			if( $user->first_name )
				$msg .= 'Hi ' . $user->first_name . ",";
			
			$pdf_file = ROOT . '/webroot/resources/PDF_CEE_2017_Infopack.pdf';
			
			$status = $email->from(['events@themovement.io' => 'The Movement Events'])
			    ->to([$user->email => $user->name])
			    ->subject('PDF CEE 2017 - Infopack')
			    ->template('infopack')
			    ->addAttachments(['PDF_CEE_2017_Infopack.pdf' => [
					'data' => file_get_contents($pdf_file),
					'mimetype' => 'application/pdf'
				]])
			    ->send([$msg]);
			
			$user->infopack_mail = true;
			$this->save($user);
			
		}
		
	}
	
}