<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class TopicsController extends AppController
{
	public function index()
    {
		
		$items = TableRegistry::get('Topics')->find('all', [
			'fields' => ['id', 'img', 'version', 'slug', 'name'],
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
	    	    
	    if(
		    ( $slug ) && 
		    ( $item = TableRegistry::get('Topics')->find()->where([
			    'Topics.slug' => $slug
		    ])->limit(1)->first() )
	    ) {
		    
		    $this->set('item', $item);
		    
	    } else {
		    
		    $this->redirect([
			    'controller' => 'Topics',
			    'action' => 'index',
		    ]);
		    
	    }
	    	    
    }
}