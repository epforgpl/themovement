<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class EventsController extends AppController
{
	public function index()
    {

    }
    
    public function create()
    {

    }
    
    public function view( $slug )
    {
	    	    
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Events')->find()->where([
			    'Events.slug' => $slug
		    ])->limit(1)->first() )
	    ) {
		    
		    $this->set('item', $item);
		    
	    } else {
		    
		    $this->redirect([
			    'controller' => 'Events',
			    'action' => 'index',
		    ]);
		    
	    }
	    	    
    }
}