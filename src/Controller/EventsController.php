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
    
    public function imageUpload() {
	    
	    $res = [
		    'code' => 0,
		    'msg' => '',
	    ];
	    
	    $formats = [
		    'image/png' => 'png',
		    'image/gif' => 'gif',
		    'image/jpg' => 'jpg',
		    'image/jpeg' => 'jpg',
	    ];
	    	    
	    if( @$this->request->data['file'] ) {
		    if( @$this->request->data['file']['size'] ) {
		    	if( @array_key_exists($this->request->data['file']['type'], $formats) ) {
			    	
			    	$ext = $formats[ $this->request->data['file']['type'] ];
			    	$temp_file_id = uniqid();
			    	$temp_file_original = WWW_ROOT . '/temp/' . $temp_file_id . '-original.' . $ext;
			    	$temp_file_block = WWW_ROOT . '/temp/' . $temp_file_id . '-block.jpg';
			    				    	
					if( move_uploaded_file($this->request->data['file']['tmp_name'], $temp_file_original) ) {
						
						switch( $ext ) {
							case 'png': {
								$src = imagecreatefrompng( $temp_file_original );
								break;
							}
							case 'gif': {
								$src = imagecreatefromgif( $temp_file_original );
								break;
							}
							case 'jpg': {
								$src = imagecreatefromjpeg( $temp_file_original );
								break;
							}
						}
						
						$src_width = imagesx( $src );
						$src_height = imagesy( $src );
						
						if( $src_width >= $src_height ) {
							
							$dst_height = min(600, $src_height);
							$dst_width = round( $src_width / $src_height * $dst_height );
							
						} else {
							
							$dst_width = min(600, $src_width);
							$dst_height = round( $src_height / $src_width * $dst_width );
							
						}
						
						$img = imagecreatetruecolor($dst_width, $dst_height);
						imagecopyresampled($img, $src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
						imagedestroy( $src );
						imagejpeg($img, $temp_file_block, 90);
						imagedestroy( $img );
						
												
						$res = ['code' => 200, 'msg' => 'OK', 'id' => $temp_file_id];
						
					} else { $res = ['code' => 503, 'msg' => 'Unkonwn error']; }
				} else { $res = ['code' => 502, 'msg' => 'The file format is unsupported']; }
		    } else { $res = ['code' => 501, 'msg' => 'No file']; }
	    } else { $res = ['code' => 500, 'msg' => 'No file']; }
	    	    
	    $this->set('res', $res);
	    $this->set('_serialize', 'res');
	    
	    
    }
    
    public function imageSave() {
	    
	    $res = [
		    'code' => 0,
		    'msg' => '',
	    ];
	    
	    if(
	    	@$this->request->data['event_id'] && 
	    	@$this->request->data['id'] && 
	    	( $event = $this->Events->get( $this->request->data['event_id'] ) )
    	) {
	    	
	    	$tmp_file_block = WWW_ROOT . '/temp/' . $this->request->data['id'] . '-block.jpg';
			
			if( file_exists($tmp_file_block) ) {
			
		    	$file_block = WWW_ROOT . '/resources/events/' . $event->id . '-block.jpg';	    	
		    	
		    	@unlink( $file_block );
		    	rename($tmp_file_block, $file_block);
		    	
		    	$event->img = true;
		    	$event->version++;
		    	
		    	$this->Events->save( $event );
		    	
		    	$res = ['code' => 200, 'msg' => 'OK'];
	    	
	    	} else {
		    	$res = ['code' => 400, 'msg' => 'No src image'];
	    	}
	    	
    	}
	    
	    $this->set('res', $res);
	    $this->set('_serialize', 'res');
	    
    }
    
}