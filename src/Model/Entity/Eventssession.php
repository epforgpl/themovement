<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Eventssession extends Entity
{

    public function isSubscribable()
    {
	    
	    return $this->events_subsessions ? false : $this->subscribable;
	    
    }

}