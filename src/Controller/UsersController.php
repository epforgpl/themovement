<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Facebook;
use Cake\Event\Event;
use Cake\Validation\Validator;

class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['logout', 'facebookLogin', 'facebookCallback', 'register', 'view']);
    }

     public function index()
     {
        $this->set('users', $this->Users->find('all'));
    }

    public function view($slug)
    {
        
        if( $item = $this->Users->find('all', [
	        'conditions' => [
		        'slug' => $slug
	        ],
	        'contain' => ['Professions']
        ])->first() ) {
	        	        
	        $this->set('item', $item);
	        
        } else {
	        
	        return $this->redirect('/');
	        
        }
                
    }
    
    public function edit($slug)
    {
        
        if( 
        	( $item = $this->Users->find('all', [
        		'conditions' => ['slug' => $slug],
        		'contain' => ['Professions']
    		])->first() ) && 
        	( $item->isLoggedUser() )
        ) {
	        
	        if( $this->request->is('post') ) {
		        
		        if(
			        $item->isLoggedUser() && 
			        isset( $this->request->data['save'] )
		        ) {
			        
			        $errors = $this->Users->updateProfile($item->id, $this->request->data);
			        
			        if( empty($errors) ) {
			        
				        $this->Flash->set('Your profile has been updated.', [
						    'element' => 'success'
						]);
						
						$this->redirect([
					        'controller' => 'Users',
					        'action' => 'view',
					        $item->slug
				        ]);
					
					} else {
						
						foreach(['first_name', 'last_name', 'country', 'organization', 'organization_name', 'organization_www', 'organization_role', 'professions', 'other_profession', 'about'] as $field) {
							if( isset($this->request->data[$field]) ) {
								$item->set($field, $this->request->data[$field]);
							}
						}
						
						foreach( $errors as $key => $val ) {
							foreach( $val as $k => $v ) {
								
								$this->Flash->set($v, [
								    'element' => 'error'
								]);
								
								break;
							}
							break;
						}
												
					}
			        
		        }
		        
		        
		        
	        }
	        
	        $this->set('item', $item);
	        
        } else {
	        
	        return $this->redirect('/');
	        
        }
                
    }
	
	/*
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
	            
                $this->Flash->success(__('Your account has been created'));
                
                $user = $this->Auth->identify();
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
                
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }
    */

    public function login()
    {
	    
        if ($this->request->is('post')) {
            
            if( isset($this->request->data['login']) ) { 
                    
	            $user = $this->Auth->identify();
	                        
	            if ($user) {
	                $this->Auth->setUser($user);
	                return $this->redirect($this->Auth->redirectUrl());
	            }
	            
	            $this->Flash->error(__('Invalid username or password, try again'));
            
            } elseif( isset($this->request->data['create']) ) {
	            
	            $validator = new Validator();
				$validator
				    ->requirePresence('email')
				    ->add('email', 'validFormat', [
				        'rule' => 'email',
				        'message' => 'E-mail must be valid'
				    ])
				    ->requirePresence('password')
				    ->notEmpty('password', 'Please provide a password.')
				    ->add('confirmPassword', [
					    'compare' => [
					        'rule' => ['compareWith', 'password']
					    ]
					])
				    ->requirePresence('first_name')
				    ->notEmpty('first_name', 'Please fill out your first name.')
				    ->requirePresence('last_name')
				    ->notEmpty('last_name', 'Please fill out your last name.')
				    ->requirePresence('birthdayYear')
				    ->notEmpty('birthdayYear')
				    ->requirePresence('birthdayMonth')
				    ->notEmpty('birthdayMonth')
				    ->requirePresence('birthdayDay')
				    ->notEmpty('birthdayDay')
				    ->requirePresence('gender')
				    ->notEmpty('gender');
				    
				 
				// debug( $this->request->data ); 
									
				$errors = $validator->errors($this->request->data);
				if( empty($errors) ) {
				    
					
					$user = $this->Users->find('all', [
						'conditions' => [
							'email' => $this->request->data['email'],
						],
					])->first();
					
					if( $user ) {
						
						$this->Flash->error(__('User with e-mail address that you provided already exists.'));
						
					} else {
						
						$this->request->data['name'] = $this->request->data['first_name'] . ' ' . $this->request->data['last_name'];
						$this->request->data['birthday'] = $this->request->data['birthdayYear'] . '-' . $this->request->data['birthdayMonth'] . '-' . $this->request->data['birthdayDay']
						
						$user = $this->Users->newEntity();
			            $user = $this->Users->patchEntity($user, $this->request->data);
			            if ($this->Users->save($user)) {
				            					            
			                $this->Flash->success(__('Your account has been created'));
			                $user = $this->Auth->identify();
			                $this->Auth->setUser($user);
			                return $this->redirect($this->Auth->redirectUrl());
			                
			            }
			            $this->Flash->error(__('Unable to add the user.'));
				        $this->set('user', $user);
						
					}
					
				
				} else {
					
				    if( isset($errors['email']) ) {
					    
					    $this->Flash->error(__('E-mail must be valid.'));
					    
				    } elseif( isset($errors['password']) ) {
					    
					    $this->Flash->error(__('Please provide a password.'));
					    
				    } elseif( isset($errors['confirmPassword']) ) {
					    
					    $this->Flash->error(__('Passwords don\'t match.'));
					    
				    } elseif( isset($errors['first_name']) ) {
					    
					    $this->Flash->error(__('Please fill out your first name.'));
					    
				    } elseif( isset($errors['last_name']) ) {
					    
					    $this->Flash->error(__('Please fill out your last name.'));
					    
				    } elseif( isset($errors['birthdayYear']) ) {
					    
					    $this->Flash->error(__('Please fill out your birthday year.'));
					    
				    } elseif( isset($errors['birthdayMonth']) ) {
					    
					    $this->Flash->error(__('Please fill out your birthday month.'));
					    
				    } elseif( isset($errors['birthdayDay']) ) {
					    
					    $this->Flash->error(__('Please fill out your birthday day.'));
					    
				    } elseif( isset($errors['gender']) ) {
					    
					    $this->Flash->error(__('Please fill out your gender.'));
					    
				    }
						
				}
				
				
	            
            } else {
	            
	            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
	            
            }
            
        }        
        
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
    
    public function facebookLogin()
    {
	    	    
	    $fb = new \App\Model\Facebook();
	    
	    $next = '/';
	    if( isset($this->request->query['next']) )
	    	$next = $this->request->query['next'];
	    
        $fbLoginUrl = $fb->getLoginUrl( $next );
	    return $this->redirect( $fbLoginUrl );
	    
    }
    
    public function facebookCallback()
    {
	    	    
	    $fb = new \App\Model\Facebook();
		$login = $fb->loginCallback();
		
		switch( @$login['code'] ) {
			case 500: {
				$this->Flash->set("Can't login via Facebook", [
				    'element' => 'error'
				]);
				break;
			}
			case 401: {
				$this->Flash->set("Can't login via Facebook", [
				    'element' => 'error'
				]);
				break;
			}
			case 400: {
				$this->Flash->set("Can't login via Facebook", [
				    'element' => 'error'
				]);
				break;
			}
			case 200: {
				
				if( $fb_user = @$login['user'] ) {
					
					if(
						( $fb_id = $fb_user->getId() ) && 
						( $email = $fb_user->getEmail() )
					) {
																								
						$user = $this->Users->find()->where([
							'email' => $email
						])->first();
						
						if( !$user ) {
							$user = $this->Users->newEntity([
								'email' => $email,
							]);
						}
						
						$user->fb_id = $fb_user->getId();
						$user->first_name = $fb_user->getFirstName();
						$user->last_name = $fb_user->getLastName();
						$user->name = $fb_user->getName();
						
						$user->age_range_min = ( $age_range = $fb_user->getField('age_range') ) ? ( $age_range->getField('min') ? $age_range->getField('min') : null ) : null;
						$user->age_range_max = ( $age_range = $fb_user->getField('age_range') ) ? ( $age_range->getField('max') ? $age_range->getField('max') : null ) : null;
													
						$user->gender = $fb_user->getGender() ? $fb_user->getGender() : null;
						
						$this->Users->save( $user );
						$this->Auth->setUser( $user );
						
					} else {
						$this->Flash->set("Unable to obtain user email from Facebook", [
						    'element' => 'error'
						]);
					}
										
				} else {
					$this->Flash->set("Can't login via Facebook", [
					    'element' => 'error'
					]);
				}
				
				break;
			}
			default: {
				$this->Flash->set("Can't login via Facebook", [
				    'element' => 'error'
				]);
			}
		}
		
		$this->redirect( isset($this->request->query['next']) ? $this->request->query['next'] : '/' );
					    
    }

}