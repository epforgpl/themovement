<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class EventsController extends AppController
{
	public function index()
    {
		
		$items = TableRegistry::get('Events')->find('all', [
			'fields' => ['id', 'slug', 'name', 'begin_date', 'begin_time', 'end_date', 'end_time'],
			'conditions' => [],
			'order' => [
				'id' => 'ASC',
			],
			'limit' => 30,
		]);
		
		$this->set('items', $items);
		
    }
    
    public function create()
    {

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
		    
		    $this->set('item', $item);
		    
		    $user_registration = false;
		    if( $user_id = $this->Auth->user('id') ) {
			    
			    $user_registration = TableRegistry::get('Registrations')->find()->where([
				    'Registrations.event_id' => $item->id,
				    'Registrations.user_id' => $user_id,
			    ])->limit(1)->first();
			    
		    }
		    
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
		    @$this->request->data &&
		    ( $event_id = @$this->request->data['event_id'] ) && 
		    ( $event = $this->Events->get($this->request->data['event_id'], ['fields' => ['id', 'slug']]) )
	    ) {		    
		    
		    $registrationsTable = TableRegistry::get('Registrations');
		    
		    $registration = $registrationsTable->find('all', [
			    'conditions' => [
				    'Registrations.event_id' => $event_id,
				    'Registrations.user_id' => $this->Auth->user('id'),
			    ],
		    ])->first();
		    
		    if( !$registration ) {
			    $registration = $registrationsTable->newEntity([
				    'event_id' => $event_id,
				    'user_id' => $this->Auth->user('id'),
			    ]);
		    }
		    
		    $registrationsTable->patchEntity($registration, $this->request->data, [
			    'fieldList' => ['organization_name', 'organization_www', 'coupon', 'dietary', 'comments'],
		    ]);
		    $registrationsTable->save( $registration );
		    
		    $this->redirect('/events/' . $event->slug);
		    
		    
	    } else {
		    
		    $this->redirect( $this->referer() );
		    
	    }
	    	    
    }
    
}