<?php
namespace App\Controller;

use App\Controller\AppController;

class CountriesController extends AppController
{
    
    public function index(){
	    
	    $items = [];
	    
	    foreach( $this->Countries->find('all', [
		    'order' => [
			    'name' => 'ASC',
		    ],
	    ]) as $e ) {
		    $items[] = [
			    'iso' => $e->iso,
			    'name' => $e->nicename,
		    ];
	    }
	    
	    $this->set('items', $items);
	    $this->set('_serialize', 'items');
	    
    }
    
}