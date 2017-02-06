<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class TopicsController extends AppController
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
		    ( $topic = TableRegistry::get('Topics')->find()->where([
			    'Topics.slug' => $slug
		    ])->limit(1)->first() )
	    ) {
		    
		    $this->set('topic', $topic);
		    
	    } else {
		    
		    $this->redirect([
			    'controller' => 'Topics',
			    'action' => 'index',
		    ]);
		    
	    }
	    	    
    }
}