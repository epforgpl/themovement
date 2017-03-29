<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\App;

class EventsController extends AppController
{
	public function index()
    {
		
		$items = TableRegistry::get('Events')->find('all', [
			'fields' => ['id', 'version', 'slug', 'img', 'name', 'begin_date', 'begin_time', 'end_date', 'end_time'],
			'conditions' => [],
			'order' => [
				'-ord' => 'DESC',
				'begin_date' => 'ASC',
				'begin_time' => 'ASC',
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
		    TableRegistry::get('Registrations')->sendConfirmation($registration);
		    		    
		    $this->Flash->set('Your registration has been finalized.', [
			    'element' => $item->registration_photo_generator ? 'event-publisher' : 'success',
			]);
						   		    		    
	    }
	    
	    $this->redirect( $item->getUrl() );
	    
    }
    
    private function getFollowers($item, $options = [])
    {
	    
	    if( !isset($options['limit']) )
	    	$options['limit'] = 6;
	    
	    if( $item->registration ) {
			    
		    $conditions = [
			    'event_id' => $item->id,
			    'status' => 1,
		    ];
		    
		    if( isset($options['id']) )
		    	$conditions['Registrations.id <'] = $options['id'];
		    
		    $followers = TableRegistry::get('Registrations')->find('all', [
			    'fields' => ['Registrations.id', 'Registrations.created', 'Users.id', 'Users.fb_id', 'Users.first_name', 'Users.last_name', 'Users.name', 'Users.organization_name', 'Users.organization_www', 'Users.slug', 'Users.gender'],
			    'conditions' => $conditions,
			    'order' => [
				    'Registrations.id' => 'DESC',
			    ],
			    'contain' => [
				    'Users' => [],
			    ],
			    'limit' => $options['limit'],
		    ]);
		    
		} else {
		    
		    $conditions = [
			    'EventsFollowers.deleted' => false,
		    ];
		    
		    if( isset($options['id']) )
		    	$conditions['EventsFollowers.id <'] = $options['id'];
		    
		    $followers = TableRegistry::get('EventsFollowers')->find('all', [
			    'conditions' => $conditions,
			    'order' => [
				    'EventsFollowers.id' => 'DESC',
			    ],
			    'contain' => [
				    'Users' => [],
			    ],
			    'limit' => $options['limit'],
		    ]);
		    
	    }
	    
	    return $followers;
	    
    }
    
    public function view( $slug )
    {
		
		if(
			$slug &&
			$this->request->is('post') && 
			(
				isset( $this->request->data['follow'] ) || 
				isset( $this->request->data['unfollow'] )
			)
		) {
			
			if( isset($this->request->data['follow']) )
				$this->setFollow($slug, true);				
			elseif( isset($this->request->data['unfollow']) )
				$this->setFollow($slug, false);				
			
		    return $this->redirect( $this->referer() );
			
		}
			
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Events')->find()->where([
			    'Events.slug' => $slug
		    ])->contain([
		    	'EventsDays' => [],
		    	'Organizations' => [],
		    	'RelatedEvents' => [],
	    	])->limit(1)->first() )
	    ) {
		    		    	    			    
		    $this->meta['ogg:url'] = 'http://themovement.io' . $item->getUrl();
		    $this->meta['ogg:type'] = 'article';
		    $this->meta['ogg:title'] = $item->name;
		    $this->meta['ogg:description'] = $item->about;
		    
		    if( $item->img )
			    $this->meta['ogg:image'] = 'http://themovement.io/resources/events/' . $item->id . '-block.jpg?v=' . $item->version;
	    	
	    	$this->set('_meta', $this->meta);
		    
		    
		    
		    
		    
		    $menu = [];
		    
		    if( $sessions_count = TableRegistry::get('EventsSessions')->find()->where()->count() )
		    	$menu[] = [
			    	'href' => 'agenda',
			    	'label' => 'Agenda',
		    	];
		    
		    if( $followers = $this->getFollowers($item) ) {
			    $menu[] = [
			    	'href' => 'people',
			    	'label' => 'People',
		    	];
		    }
		    
		    /*
		    if( $item->surveys ) {
			    $menu[] = [
				    'href' => 'surveys',
				    'label' => 'Surveys',
			    ];
		    }
		    */
		    		    
		    if( $item->registration ) {
			    $followers_label = 'Who is going';
			} else {
			    $followers_label = 'Following';
		    }
		    
		    $this->set('followers', $followers);
		    $this->set('followers_label', $followers_label);
		    
		    $user_registration = false;
		    $user_follow = false;
		    
		    if( $user_id = $this->Auth->user('id') ) {
		    
		    
			    if( $item->registration ) {
				    
				    $user =  TableRegistry::get('Users')->get($user_id, [
					    'contain' => ['Professions'],
				    ]);
				    		    
				    $user_registration = TableRegistry::get('Registrations')->find()->where([
					    'Registrations.event_id' => $item->id,
					    'Registrations.user_id' => $user_id,
				    ])->contain([
					    'EventsDays' => [],
				    ])->limit(1)->first();
				    
				    if( !$user_registration ) {
					    $user_registration =  TableRegistry::get('Registrations')->newEntity();
				    }
				    			    
				    if( $session_data = $this->request->session()->read('Forms.Events.' . $item->id . '.register') ) {
					    				    		    
					    if( $user ) {
						    $fields = ['country', 'organization', 'organization_name', 'organization_www', 'organization_role', 'other_profession', 'about', 'gender', 'professions'];
						    foreach( $fields as $f ) {
							    
							    if( isset($session_data[ $f ]) )
							    	$user->set($f, $session_data[ $f ]);
							    
						    }
					    }
					    	
					    
					    // USER REGISTRATION
					    
					    $fields = ['dietary', 'comments', 'events_days', 'coupon'];				    
					    foreach( $fields as $f ) {
						    if( isset($session_data[ $f ]) )
						    	$user_registration->set($f, $session_data[ $f ]);
					    }
					    				    			    
				    }			    
	
				    $this->set('user', $user);
				    
			    } else {
				    
					
					$user_follow = TableRegistry::get('EventsFollowers')->find()->where([
					    'EventsFollowers.event_id' => $item->id,
					    'EventsFollowers.user_id' => $user_id,
					    'EventsFollowers.deleted' => false,
				    ])->limit(1)->first();
									    
			    }
			    
			    
			    if( $this->Auth->user('role') == 'admin' ) {
				    
				    $menu[] = [
					    'href' => 'registrations',
					    'label' => 'Registrations',
				    ];
				    
				    $menu[] = [
					    'href' => 'coupons',
					    'label' => 'Coupons',
				    ];
				    
			    }
			    			    
			    
			}
		    
		    if( $this->request->is('post') ) {
								
				if(
					$user_registration && 
					isset($this->request->data['cancel-registration'])
				) {
										
					$this->request->session()->delete('Forms.Events.' . $item->id . '.register');
					
					TableRegistry::get('Registrations')->delete($user_registration);
					$this->Flash->set('Your registration has been canceled.', [
					    'element' => 'success'
					]);
					
				}
				
				return $this->redirect( $item->getUrl() );
				
			}
			
			$item->groupOrganizations();
			
			if( $user_registration && $user_registration->coupon ) {
			    $user_registration->coupon_valid = TableRegistry::get('Coupons')->check($user_registration->coupon, $item->id);
		    }
			
						
			if( $menu )
				array_unshift($menu, [
					'href' => '',
					'label' => 'Home',
				]);
						
		    $this->set('item', $item);
		    $this->set('menu', $menu);
		    $this->set('menu_active', '');
		    $this->set('user_registration', $user_registration);
		    $this->set('user_follow', $user_follow);
		    
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
		    ( $event = $this->Events->get($this->request->data['event_id'], [
		    	'fields' => ['id', 'slug'],
		    	'contain' => [
			    	'EventsDays'
		    	],
	    	]) )
	    ) {		    
		    
		    $errors = TableRegistry::get('Users')->updateProfile($user_id, $this->request->data);
		    if( $errors ) {
			    
			    foreach( $errors as $key => $val ) {
					foreach( $val as $k => $v ) {
						
						$this->Flash->set($v, [
						    'element' => 'error'
						]);
						
						break;
					}
					break;
				}
				
				$this->request->session()->write('Forms.Events.' . $event_id . '.register', $this->request->data);
				$this->redirect('/events/' . $event->slug . '/?register');
			    
			} else {
		    			    	
		    	if( 
		    		!empty($event->events_days) && 
		    		empty($this->request->data['events_days']['_ids']) 
	    		) {
			    	
			    	$this->Flash->set('Select days', [
					    'element' => 'error'
					]);
			    	
			    	$this->request->session()->write('Forms.Events.' . $event_id . '.register', $this->request->data);
					$this->redirect('/events/' . $event->slug . '/?register');
			    	
		    	} else {
		    	
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
					    'fieldList' => ['coupon', 'dietary', 'comments', 'events_days'],
					    'associated' => ['EventsDays']
				    ]);
				    $registrationsTable->save($registration);
				    				    
				    $this->request->session()->delete('Forms.Events.' . $event_id . '.register');
				    $this->redirect('/events/' . $event->slug);
			    
			    }
		    
		    }
		    
		    
	    } else {
		    
		    $this->redirect( $this->referer() );
		    
	    }
	    	    
    }
    
    public function people( $slug )
    {
	    
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Events')->find()->where([
			    'Events.slug' => $slug
		    ])->limit(1)->first() )
	    ) {
		    
		    $this->generateMenu($item, 'people');
		    
		    $countries_data = TableRegistry::get('Registrations')->find()->select([
		    	'Users.country',
		    	'Countries.nicename',
		    	'count' => TableRegistry::get('Registrations')->find()->func()->count('*')
		    ])->matching('Users', function($q){
			    return $q->matching('Countries');
		    })->where([
			    'Registrations.status' => 1,
			    'Users.country !=' => '',
		    ])->group('Users.country')->order([
			    'count' => 'desc',
		    ]);
		    
		    $countries = [];
		    foreach( $countries_data as $c ) {
			    
			    $country = [
				    'id' => $c['_matchingData']['Users']->country,
				    'label' => $c['_matchingData']['Countries']->nicename,
				    'count' => $c['count'],
			    ];
			    
			    if(
				    isset( $this->request->query['country'] ) && 
				    ( $this->request->query['country'] == $country['id'] )
			    )
			    	$country['active'] = true;
			    
			    $countries[] = $country;
			    
		    }
		    
		    $this->paginate = [
	            'limit' => 50,
	            'contain' => [
		            'Users' => [],
	            ],
	        ];
		    
		    $conditions = [
			    'Registrations.status' => 1,
		    ];		    
		    
		    if(
			    isset( $this->request->query['country'] ) && 
			    $this->request->query['country']
		    ) {
			    $conditions['Users.country'] = $this->request->query['country'];
		    }
		    
		    $regs = $this->paginate(TableRegistry::get('Registrations')->find()->matching('Users')->where($conditions)->order([
			    'Users.last_name' => 'asc',
		    ]));
		    		    
		    $this->set('countries', $countries);
		    $this->set('item', $item);
		    $this->set('regs', $regs);
		    
		} else {
			
			$this->redirect([
			    'controller' => 'Events',
			    'action' => 'index',
		    ]);
			
		}
	    
    }
    
    public function surveys($slug)
    {
	 		 	   
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Events')->find()->where([
			    'Events.slug' => $slug
		    ])->limit(1)->first() )
	    ) {
		    
		    $this->generateMenu($item, 'surveys');
		    $this->set('item', $item);
		    
		}
		
	}
	
	public function surveysManager($slug)
    {
	 		 	   
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Events')->find()->where([
			    'Events.slug' => $slug
		    ])->contain([
			    'SurveysQuestions' => [
				    'sort' => [
					    'SurveysQuestions.ord' => 'asc',
				    ],
				    'SurveysAnswers' => [
					    'sort' => [
						    'SurveysAnswers.ord' => 'asc',
					    ],
				    ],
			    ],
		    ])->limit(1)->first() )
	    ) {
		    		    
		    $this->generateMenu($item, 'surveys');
		    $this->set('item', $item);
		
		}
		
	}
	
	public function surveysPresent($slug)
    {
	 		 	   
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Events')->find()->where([
			    'Events.slug' => $slug
		    ])->limit(1)->first() )
	    ) {
		    
		    $this->generateMenu($item, 'surveys');
		    $this->set('item', $item);
		
		}
		
	}
    
    public function agenda($slug)
    {
	 		 	   
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Events')->find()->where([
			    'Events.slug' => $slug
		    ])->contain([
		    	'EventsSessions' => [
			    	'sort' => [
				    	'EventsSessions.time' => 'ASC'
			    	],
			    	'EventsSubsessions' => [
				    	'sort' => [
					    	'EventsSubsessions.ord' => 'ASC',
				    	],
			    	],
		    	],
	    	])->limit(1)->first() )
	    ) {
		    
		    $this->generateMenu($item, 'agenda');
		    
		    $sessions = [];
		    $dates = [];
		    $date_active = false;
		    
		    foreach( $item->events_sessions as $session ) {
			    
			    $date = $session->time->format('Y-m-d');
			    
			    if( !$date_active )
			    	$date_active = $date;
			    
			    if( !array_key_exists($date, $dates) )
			    	$dates[ $date ] = $session->time;
			    	
			    $sessions[ $date ][] = $session;
			    				    
		    }
		    
		    unset( $item->events_sessions );
		    		     
		    $this->set('date_active', $date_active);
		    $this->set('dates', $dates);
		    $this->set('item', $item);
		    $this->set('sessions', $sessions);
		    
		} else {
			
			$this->redirect([
			    'controller' => 'Events',
			    'action' => 'index',
		    ]);
			
		}
	
	}
    
    public function registrations($slug)
    {
	 		 	   
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Events')->find()->where([
			    'Events.slug' => $slug
		    ])->contain([
		    	'EventsDays' => [],
	    	])->limit(1)->first() ) &&
	    	( $this->Auth->user('role')=='admin' )
	    ) {
		    
		    $this->generateMenu($item, 'registrations');
		    
		    $registrations = TableRegistry::get('Registrations')->find('all', [
			    'conditions' => [
				    'Registrations.event_id' => $item->id,
				    'Registrations.status !=' => -1,
			    ],
			    'contain' => [
				    'Users' => [],
			    ],
			    'limit' => 1000,
			    'order' => [
				    'Registrations.created' => 'DESC',
			    ],
		    ]);
		    
		    $this->set('item', $item);
		    $this->set('registrations', $registrations);
		    
		} else {
			
			$this->redirect([
			    'controller' => 'Events',
			    'action' => 'index',
		    ]);
			
		}
	
	}
		
	public function coupons($slug)
    {
	 		 	   
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Events')->find()->where([
			    'Events.slug' => $slug
		    ])->contain([
		    	'EventsDays' => [],
	    	])->limit(1)->first() ) &&
	    	( $this->Auth->user('role')=='admin' )
	    ) {
		    
		    $this->generateMenu($item, 'coupons');
		    
		    $coupons = TableRegistry::get('Coupons')->find('all', [
			    'conditions' => [
				    'Coupons.event_id' => $item->id,
			    ],
			    /*
			    'contain' => [
				    'Users' => [],
			    ],
			    */
			    'limit' => 100,
			    'order' => [
				    'Coupons.id' => 'DESC',
			    ],
		    ]);
		    
		    $this->set('item', $item);
		    $this->set('coupons', $coupons);
		    		    
		} else {
			
			$this->redirect([
			    'controller' => 'Events',
			    'action' => 'index',
		    ]);
			
		}
	
	}
	
	private function setFollow($slug, $status) {
		
		$follow = false;
		
		if(
		    ( $slug ) && 
		    ( $user_id = $this->Auth->user('id') ) && 
		    ( $item = TableRegistry::get('Events')->find('all', [
		    	'conditions' => [
		    		'slug' => $slug,
	    		], 
		    	'limit' => 1
	    	])->first() )
	    ) {
		    
		    $followsTable = TableRegistry::get('EventsFollowers');
		    
		    $follow = $followsTable->find('all', [
			    'conditions' => [
				    'EventsFollowers.event_id' => $item->id,
				    'EventsFollowers.user_id' => $user_id,
			    ],
		    ])->first();
		    
		    if( !$follow ) {
			    $follow = $followsTable->newEntity([
				    'event_id' => $item->id,
				    'user_id' => $user_id,
			    ]);
		    }
		    
		    $follow->deleted = !$status;
		    
		    $followsTable->save( $follow );		    
		    
		    if( $follow->deleted )
			    $this->Flash->set('You have unfollowed ' . $item->name, ['element' => 'success']);
			else
			    $this->Flash->set('You are now following ' . $item->name, ['element' => 'success']);
		    						   		    		    
	    }
	    
	    $this->set('res', $follow);
	    $this->set('_serialize', 'res');
		
	}
	
	public function follow($slug)
    {
	    	    
	    $this->setFollow($slug, true);
	    $this->redirect( $this->referer() );
	    
    }
    
    public function unfollow($slug)
    {
	    	    
	    $this->setFollow($slug, false);
	    $this->redirect( $this->referer() );
	    
    }
    
    public function following( $slug )
    {
		
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Events')->find()->where([
			    'Events.slug' => $slug
		    ])->limit(1)->first() )
	    ) {
        	
        	$options = [
	        	'limit' => 20
        	];
        	
        	if(
	        	isset( $this->request->query['id'] ) && 
	        	( $id = (int) $this->request->query['id'] )
        	) {
	        	$options['id'] = $id;
        	}
        	
        	$followers = $this->getFollowers($item, $options);
        	$this->set('followers', $followers);
        	        
        }
        
        $this->viewBuilder()->layout('blank');
        
    }
    
    private function generateMenu($item, $active = '')
    {
	    
	    $menu = [];
	    
	    if( $sessions_count = TableRegistry::get('EventsSessions')->find()->where([
	    	'EventsSessions.event_id' => $item->id
    	])->count() )
	    	$menu[] = [
		    	'href' => 'agenda',
		    	'label' => 'Agenda',
	    	];
	    	
	    if( $followers_count = TableRegistry::get('Registrations')->find()->where([
		    'Registrations.event_id' => $item->id,
		    'status' => 1,
	    ])->count() )
	    	$menu[] = [
		    	'href' => 'people',
		    	'label' => 'People',
	    	];	    
	    
	    /*
	    if( $item->surveys ) {
		    
		    $menu[] = [
			    'href' => 'surveys',
			    'label' => 'Surveys',
		    ];
		    		    
	    }
	    */
	    	
	    if( $this->Auth->user('role') == 'admin' ) {
		    
		    $menu[] = [
			    'href' => 'registrations',
			    'label' => 'Registrations',
		    ];
		    
		    $menu[] = [
			    'href' => 'coupons',
			    'label' => 'Coupons',
		    ];
		    
	    }
	    
	    if( $menu )
			array_unshift($menu, [
				'href' => '',
				'label' => 'Home',
			]);
	    
	    $this->set('menu', $menu);
	    $this->set('menu_active', $active);
	    
    }
    
    public function setActiveQuestion($id)
    {
	    
	    if( $id ) {
	    	
	    	$value = @$this->request->data['question_id'] ? $this->request->data['question_id'] : null;
	    	
		    $this->Events->query()->update()->set([
			    'surveys_question_id' => $value,
		    ])->where([
			    'id' => $id,
		    ])->execute();
		    
		    $message = 'Set';

		} else {
			
			$message = 'Failed';
			
		}
		
		$this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
	    
    }
    
    public function getActiveQuestion($id)
    {
	    
	    $question = false;
	    
	    if( $id ) {
	    	
	    	$event = $this->Events->get($id, [
		    	'fields' => ['surveys_question_id'],
	    	]);
	    	
	    	if( $event && $event->surveys_question_id ) {
		    	
		    	$question = TableRegistry::get('SurveysQuestions')->get($event->surveys_question_id, [
			    	'fields' => ['id', 'text'],
			    	'contain' => [
				    	'SurveysAnswers' => [
					    	'fields' => ['id', 'text', 'question_id'],
						    'sort' => [
							    'SurveysAnswers.ord' => 'asc',
						    ],
					    ],
			    	],
		    	]);
		    			    	
	    	}

		}
		
		$this->set([
            'question' => $question,
            '_serialize' => 'question'
        ]);
	    
    }
    
}