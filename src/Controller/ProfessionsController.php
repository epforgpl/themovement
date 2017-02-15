<?php
namespace App\Controller;

use App\Controller\AppController;

class ProfessionsController extends AppController
{
    
    public function index(){
	    
	    $items = [];
	    
	    foreach( $this->Professions->find('all', [
		    'order' => [
			    'id' => 'ASC',
		    ],
	    ]) as $e ) {
		    $items[] = [
			    'id' => $e->id,
			    'name' => $e->name,
		    ];
	    }
	    
	    $this->set('items', $items);
	    $this->set('_serialize', 'items');
	    
    }
    
}