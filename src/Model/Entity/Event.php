<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Event extends Entity
{

	public function getUrl()
	{
		return '/events/' . $this->slug;
	}

}