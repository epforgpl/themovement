<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\App;
use Cake\Mailer\Email;

class EventsController extends AppController
{
	public function index()
    {
		
		$items = TableRegistry::get('Events')->find('all', [
			'fields' => ['id', 'version', 'slug', 'img', 'name', 'begin_date', 'begin_time', 'end_date', 'end_time'],
			'conditions' => [],
			'order' => [
				'id' => 'ASC',
			],
			'limit' => 30,
		]);
		
		$this->set('items', $items);
		
    }
    
    public function finishRegistration($slug)
    {
	    	    
	    if(
		    ( $slug ) && 
		    ( $user_id = $this->Auth->user('id') ) && 
		    ( $item = TableRegistry::get('Events')->find('all', [
		    	'conditions' => [
		    		'slug' => $slug,
		    		'registration' => true
	    		], 
		    	'limit' => 1
	    	])->first() ) &&
	    	( $registration = TableRegistry::get('Registrations')->find('all', [
		    	'conditions' => [
		    		'event_id' => $item->id,
		    		'user_id' => $user_id
	    		], 
		    	'limit' => 1
	    	])->first() ) && 
	    	( $user = TableRegistry::get('Users')->find('all', [
		    	'conditions' => [
		    		'id' => $user_id
	    		], 
		    	'limit' => 1
	    	])->first() ) 
	    ) {
		    
		    $registration->status = 1;
		    TableRegistry::get('Registrations')->save($registration);
		    
		    $this->Flash->set('Your registration has been finalized.', [
			    'element' => 'event-publisher'
			]);
						
			$email = new Email('default');
						
			$status = $email->from(['events@themovement.io' => 'The Movement'])
			    ->to([$user->email => $user->name])
			    ->subject('Personal Democracy Forum CEE 2017')
			    ->template('register')
			    ->send([$user->first_name]);
			   		    		    
	    }
	    
	    $this->redirect( $item->getUrl() );
	    
    }
    
    public function view( $slug )
    {
			
		$registrations_conditions = [
			'Registrations.status' => 1,
		];
		
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Events')->find()->where([
			    'Events.slug' => $slug
		    ])->contain(['Registrations' => [
		    	'conditions' => $registrations_conditions
	    	]])->limit(1)->first() )
	    ) {
		    					    
		    $this->meta['ogg:url'] = 'http://themovement.io' . $item->getUrl();
		    $this->meta['ogg:type'] = 'article';
		    $this->meta['ogg:title'] = $item->name;
		    $this->meta['ogg:description'] = $item->about;
		    
		    if( $item->img )
			    $this->meta['ogg:image'] = 'http://themovement.io/resources/events/' . $item->id . '-block.jpg?v=' . $item->version;
	    	
	    	
	    	$this->set('_meta', $this->meta);
		    		    
		    $user_registration = false;
		    if( $user_id = $this->Auth->user('id') ) {
			    
			    $user =  TableRegistry::get('Users')->get($user_id, [
				    'contain' => ['Professions'],
			    ]);
			    $this->set('user', $user);
			    		    
			    $user_registration = TableRegistry::get('Registrations')->find()->where([
				    'Registrations.event_id' => $item->id,
				    'Registrations.user_id' => $user_id,
			    ])->limit(1)->first();
			    
			    if( @$user_registration->coupon ) {
				    $user_registration->coupon_valid = TableRegistry::get('Coupons')->check($user_registration->coupon, $item->id);
			    }
			    
		    }
		    
		    if( $this->request->is('post') ) {
				
				if(
					$user_registration && 
					isset($this->request->data['cancel-registration'])
				) {
					
					TableRegistry::get('Registrations')->delete($user_registration);
					$this->Flash->set('Your registration has been canceled.', [
					    'element' => 'success'
					]);
					
				}
				
				return $this->redirect( $item->getUrl() );
				
			}
			
		    $this->set('item', $item);
		    $this->set('user_registration', $user_registration);
		    
	    } else {
		    
		    $this->redirect([
			    'controller' => 'Events',
			    'action' => 'index',
		    ]);
		    
	    }
	    	    
    }
    
    public function register()
    {
	    	    
	    if(
		    ( $user_id = $this->Auth->user('id') ) && 
		    @$this->request->data &&
		    ( $event_id = @$this->request->data['event_id'] ) && 
		    ( $event = $this->Events->get($this->request->data['event_id'], ['fields' => ['id', 'slug']]) )
	    ) {		    
		    
		    $errors = TableRegistry::get('Users')->updateProfile($user_id, $this->request->data);
		    // debug($errors); die();
		    
		    $registrationsTable = TableRegistry::get('Registrations');
		    
		    $registration = $registrationsTable->find('all', [
			    'conditions' => [
				    'Registrations.event_id' => $event_id,
				    'Registrations.user_id' => $user_id,
			    ],
		    ])->first();
		    
		    if( !$registration ) {
			    $registration = $registrationsTable->newEntity([
				    'event_id' => $event_id,
				    'user_id' => $user_id,
			    ]);
		    }
		    
		    $registrationsTable->patchEntity($registration, $this->request->data, [
			    'fieldList' => ['coupon', 'dietary', 'comments'],
		    ]);
		    $registrationsTable->save( $registration );
		    		    
		    $this->redirect('/events/' . $event->slug);
		    
		    
	    } else {
		    
		    $this->redirect( $this->referer() );
		    
	    }
	    	    
    }
        
}