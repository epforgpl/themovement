<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Topic extends Entity
{

	public function getUrl()
	{
		return '/topics/' . $this->slug;
	}

}